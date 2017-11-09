<?php
require_once (dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once (dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once (dirname(__DIR__, 3) . "/php/lib/uuid.php");
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\CreepyOctoMeow\Post;

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

	//user must be logged in - if not, throw an exception
	if(empty($_SESSION["profile"]) === true) {
		throw (new \InvalidArgumentException("Sorry. U are not logged in.", 401));
	}

	//sanitize and store input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postProfileId = filter_input(INPUT_GET, "postProfileId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$postContent = filter_input(INPUT_GET, "postContent", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//$postDate = filter_input(INPUT_GET, "postDate", FILTER_VALIDATE_INT);
	$postSunriseDate = filter_input(INPUT_GET, "postSunriseDate", FILTER_VALIDATE_INT);
	$postSunsetDate = filter_input(INPUT_GET, "postSunsetDate", FILTER_VALIDATE_INT);
	$postTitle = filter_input(INPUT_GET, "postTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//if sunrise and sunset are available for date range search, format them
	/*if(empty($postSunriseDate) === false && empty($postSunsetDate) === false) {
		$postSunriseDate = \DateTime::createFromFormat("U", $postSunriseDate / 1000);
		$postSunsetDate = \DateTime::createFromFormat("U", $postSunsetDate / 1000);
	}*/

	//check for valid post id for PUT and DELETE requests
	if(($method === "PUT" || $method === "DELETE") && (empty($id) === true)) {
		throw (new \InvalidArgumentException("Post id is not valid.", 405));
	}

	//begin if blocks for the allowed HTTP requests
	if($method === "GET") {

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

		//check xsrf token
		verifyXsrf();

		//grab request content, decode json into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//restrict access if user is not logged into the account that authored created the post!
		if($_SESSION["profile"]->getProfileId() !== $requestObject->postProfileId) {
			throw (new \Exception("Profile id does not match post profile id.", 401));
		}

		//user MUST have an activated account before they can create or edit posts.
		if($_SESSION["profile"]->getProfileActivationToken() !== null) {
			throw (new \InvalidArgumentException("You must have an activated account before you can create posts. Please check your email for the activation link.", 401));
		}

		//make sure a post profile id is available
		if(empty($requestObject->postProfileId) === true) {
			throw (new \InvalidArgumentException("No post profile id.", 405));
		}

		//make sure there is post content (required field)
		if(empty($requestObject->postContent) === true) {
			throw (new \InvalidArgumentException("No post content.", 405));
		}

		//make sure there is a post title (required field)
		if(empty($requestObject->postTitle) === true) {
			throw (new \InvalidArgumentException("No post title.", 405));
		}

		if($method === "PUT") {

			//grab the post
			$post = Post::getPostByPostId($pdo, $id);
			if($post === null) {
				throw (new \RuntimeException("Post does not exist.", 404));
			}

			//set updated post data
			$post->setPostContent($requestObject->postContent);
			$post->setPostTitle($requestObject->postTitle);

			//update the post date on post update
			$updateDate = new \DateTime();
			$post->setPostDate($updateDate);

			//update the post
			$post->update($pdo);

			//update reply
			$reply->message = "Your post was successfully updated!";

		} elseif($method === "POST") {

			//create a new post and insert into mysql
			$post = new Post(null, $requestObject->postProfileId, $requestObject->postContent, null, $requestObject->postTitle);
			$post->insert($pdo);

			//update reply
			$reply->message = "Post created!";
		}

	} elseif($method === "DELETE") {

		verifyXsrf();

		//grab the post
		$post = Post::getPostByPostId($pdo, $id);
		if($post === null) {
			throw (new \RuntimeException("Post no exist!", 404));
		}

		//make sure user is logged in to the account that created the post
		if($_SESSION["profile"]->getProfileId() !== $post->getPostProfileId()) {
			throw (new \InvalidArgumentException("U are not allowed to delete this post!", 401));
		}

		//delete the post (╯°▽°)╯︵ ┻━┻
		$post->delete($pdo);

		//update reply
		$reply->message = "Post deleted.";

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