<?php

require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PotentialBroccoli\Profile;

/**
 * API for Profile class
 *
 * GET, POST, and PUT requests are supported.
 *
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 **/

//check the session status. If it is not active, start the session.
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

/**
 * Prepare an empty reply.
 *
 * Here we create a new stdClass named $reply. A stdClass is basically an empty bucket that we can use to store things in.
 *
 * We will use this object named $reply to store the results of the call to our API. The status 200 line adds a state variable to $reply called status and initializes it with the integer 200 (success code). The proceeding line adds a state variable to $reply called data. This is where the result of the API call will be stored. We will also update $reply->message as we proceed through the API.
 **/
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	//grab the database connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/rlewis37.ini");

	//determine which HTTP method, store the result in $method
	$method = array_key_exists("HTTP_x_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//sanitize and store input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$profileActivationToken = filter_input(INPUT_GET, "profileActivationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$profileEmail = filter_input(INPUT_GET, "profileEmail", FILTER_SANITIZE_EMAIL);
	$profileUsername = filter_input(INPUT_GET, "profileUsername", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//for PUT requests throw an exception if no valid $id
	if(($method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("Y U No have valid id?", 405));
	}

	//begin if blocks for the various HTTP requests
	if($method === "GET") {

		setXsrfCookie("/");

		//grab profile/profiles based upon available input
		if(empty($id) === false) {

			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} elseif(empty($profileActivationToken) === false) {

			$profile = Profile::getProfileByProfileActivationToken($pdo, $profileActivationToken);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} elseif(empty($profileEmail) === false) {

			$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} elseif(empty($profileUsername) === false) {

			$profile = Profile::getProfileByProfileUsername($pdo, $profileUsername);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} else {

			$profiles = Profile::getAllProfiles($pdo)->toArray();
			if($profiles !== null) {
				$reply->data = $profiles;
			}

		}

	} elseif($method === "PUT" || $method === "POST") {

		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check if profile email is available (required field)
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("No profile email.", 405));
		}

		//check if profile username is available (required field)
		if(empty($requestObject->profileUsername) === true) {
			throw (new \InvalidArgumentException("No profile username.", 405));
		}

		if($method === "PUT") {

			//restrict write access to profile if not logged in to the profile
			if(empty(($_SESSION["profile"]) === true) || ($_SESSION["profile"]->getProfileId() !== $id)) {
				throw (new \Exception("U are not allowed to access this profile!", 405));
			}

			//retrieve profile to update
			$profile = Profile::getProfileByProfileId($pdo, $id);
			if($profile === null) {
				throw (new RuntimeException("Profile does not exist.", 404));
			}

			//update all non-password attributes
			$profile->setProfileActivationToken($requestObject->profileActivationToken);
			$profile->setProfileEmail($requestObject->profileEmail);
			$profile->setProfileUsername($requestObject->profileUsername);

			//change password if requested
			if(empty($requestObject->currentProfilePassword) === false && empty($requestContent->newProfilePassword) === false) {

				//throw exception if new password confirmation field doesn't match
				if($requestObject->newProfilePassword !== $requestObject->newProfileConfirmPassword) {
					throw (new \RuntimeException("New passwords do not match", 401));
				}

				//throw exception if current password given doesn't hash to match what's currently in mysql
				$currentPasswordHash = hash_pbkdf2("sha512", $requestObject->currentProfilePassword, $profile->getProfileSalt(), 262144);
				if($currentPasswordHash !== $profile->getProfileHash()) {
					throw (new \RuntimeException("Current password is incorrect.", 401));
				}

				//generate new salt and hash for new password
				$newProfileSalt = bin2hex(random_bytes(16));
				$newProfileHash = hash_pbkdf2("sha512", $requestObject->newProfilePassword, $newProfileSalt, 262144);

				//update password
				$profile->setProfileSalt($newProfileSalt);
				$profile->setProfileHash($newProfileHash);
			}

			//run update, update reply
			$profile->update($pdo);
			$reply->message = "Profile updated ok!";

		} elseif($method === "POST") {

		}

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}

//sets up the response header.
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//finally - JSON encode the $reply object and echo it back to the front end.
echo json_encode($reply);