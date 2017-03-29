<?php

require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PotentialBroccoli\Profile;

/**
 * API for Profile class
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

	//stores the Primary Key for GET, DELETE, PUT in $id. This comes in the URL from the front end
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

	//for PUT and DELETE requests, throw an exception if no valid $id
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new \InvalidArgumentException("Y U No have valid id?", 405));
	}

	//begin if blocks for the various HTTP requests
	if($method === "GET") {

	} elseif($method === "PUT" || $method === "POST") {

		if($method === "PUT") {

		} elseif($method === "POST") {

		}

	} elseif($method === "DELETE") {

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

//finally - JSON encodes the $reply object and sends it back to the front end.
echo json_encode($reply);