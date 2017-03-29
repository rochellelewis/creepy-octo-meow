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
	$activationToken = filter_input(INPUT_GET, "activationToken", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
	$username = filter_input(INPUT_GET, "username", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

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

		} elseif(empty($activationToken) === false) {

			$profile = Profile::getProfileByProfileActivationToken($pdo, $activationToken);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} elseif(empty($email) === false) {

			$profile = Profile::getProfileByProfileEmail($pdo, $email);
			if($profile !== null) {
				$reply->data = $profile;
			}

		} elseif(empty($username) === false) {

			$profile = Profile::getProfileByProfileUsername($pdo, $username);
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

		if($method === "PUT") {

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