<?php
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once (dirname(__DIR__, 3) . "/php/lib/mailgun.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PotentialBroccoli\Profile;

/**
 * API for new user sign up, Profile class
 *
 * POST requests are supported.
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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	if($method === "POST") {

		//this is where the magic happens (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧

		//grab request content, decode json into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//check for all required fields
		if(empty($requestObject->profileEmail) === true) {
			throw (new \InvalidArgumentException("Y u no email?"));
		}

		if(empty($requestObject->profileUsername) === true) {
			throw (new \InvalidArgumentException("Please choose a username."));
		}

		if(empty($requestObject->profilePassword) === true) {
			throw (new \InvalidArgumentException("You must provide a password."));
		} else {
			$profilePassword = $requestObject->profilePassword;
		}

		if(empty($requestObject->profileConfirmPassword) === true) {
			throw (new \InvalidArgumentException("Please confirm your password."));
		}

		if($requestObject->profilePassword !== $requestObject->profileConfirmPassword) {
			throw (new \InvalidArgumentException("Passwords do not match."));
		}

		//create profile activation token
		$profileActivationToken = bin2hex(random_bytes(16));

		//create password salt and hash
		$salt = bin2hex(random_bytes(16));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);

		//create a new Profile and insert into mysql
		$profile = new Profile(null, $profileActivationToken, $requestObject->profileEmail, $hash, $salt, $requestObject->profileUsername);
		$profile->insert($pdo);

		//build the account activation email link - this url points to the activation api
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 2);
		$urlGlue = $basePath . "/activation/?token=" . $profileActivationToken;
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlGlue;

		//build account activation email, and mailgun it!
		$senderName = "Potential Broccoli Demo App";
		$senderEmail = "rlewis37@cnm.edu";
		$subject = "Potential Broccoli Account Activation";
		$message = <<< EOF
<h2>One more step to activate your account.</h2>
<p>Visit the following link to complete the sign-up process: <a href="$confirmLink">$confirmLink<a></p>
EOF;
		$response = mailgunHandler($senderName, $senderEmail, $requestObject->profileUsername, $requestObject->profileEmail, $subject, $message);

		//update reply after sending activation email
		$reply->message = "Almost done! Check your email to activate your account.";

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!"));
	}

} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
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