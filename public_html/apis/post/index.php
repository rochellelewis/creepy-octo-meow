<?php

require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\PotentialBroccoli\{Profile, Post};

/**
 * API for Post class
 *
 * GET, PUT, POST, DELETE requests are supported.
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

	//throw exception if not logged in
	if(empty($_SESSION["profile"] === true)) {
		throw (new \InvalidArgumentException("U are not logged in.", 401));
	}

	//sanitize and store input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_VALIDATE_INT);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postDate = filter_input(INPUT_GET, "postDate", FILTER_VALIDATE_INT);
	$postSunriseDate = filter_input(INPUT_GET, "postSunriseDate", FILTER_VALIDATE_INT);
	$postSunsetDate = filter_input(INPUT_GET, "postSunsetDate", FILTER_VALIDATE_INT);
	$postTitle = filter_input(INPUT_GET, "postTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//if sunrise and sunset are available for date range search, format them
	/*if(empty($postSunriseDate) === false && empty($postSunsetDate) === false) {
		$postSunriseDate = \DateTime::createFromFormat("U", $postSunriseDate / 1000);
		$postSunsetDate = \DateTime::createFromFormat("U", $postSunsetDate / 1000);
	}*/

	//check for valid post id for PUT and DELETE requests
	if(($method === "PUT" || $method === "DELETE") && (empty($id) === true || $id <= 0)) {
		throw (new \InvalidArgumentException("Post id is not valid.", 405));
	}

	//begin if blocks for the allowed HTTP requests
	if($method = "GET") {

		setXsrfCookie();

		if(empty($id) === false) {

			$post = Post::getPostByPostId($pdo, $id);
			if($post !== null) {
				$reply->data = $post;
			}

		} elseif(empty($postProfileId) === false) {

			$posts = Post::getPostsByPostProfileId($pdo, $postProfileId)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} elseif(empty($postContent) === false) {

			$posts = Post::getPostsByPostContent($pdo, $postContent)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} elseif(empty($postSunriseDate) === false && empty($postSunsetDate) === false) {

			$posts = Post::getPostsByPostDateRange($pdo, $postSunriseDate, $postSunsetDate)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} elseif(empty($postTitle) === false) {

			$posts = Post::getPostsByPostTitle($pdo, $postTitle)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		} else {

			$posts = Post::getAllPosts($pdo)->toArray();
			if($posts !== null) {
				$reply->data = $posts;
			}

		}

	} elseif($method === "PUT" || $method === "POST") {

		if($method === "PUT") {

		} elseif($method === "POST") {

		}

	} elseif($method === "DELETE") {

	} else {
		throw (new \InvalidArgumentException("Invalid HTTP request!", 405));
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