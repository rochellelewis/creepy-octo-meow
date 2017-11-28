<?php

require_once dirname(__DIR__, 2) . "/vendor/autoload.php";
require_once dirname(__DIR__) . "/lib/uuid.php";

use Lcobucci\JWT\{
	Builder,
	Signer\Hmac\Sha512,
	Parser,
	ValidationData
};

/**
 * Creates a JSON Web Token to be used on the front end to authenticate
 * users, activate protected routes, and verification of the user logged in.
 *
 * This token is visible on the front end and should NEVER contain sensitive info.
 *
 * @see https://github.com/lcobucci/jwt/blob/3.2/README.md
 *
 * @param string $value name of the custom object that will be used for validation.
 * @param stdClass $content the actual object that will be used for authentication
 * on the front end
 * @throws RuntimeException if session is not active.
 **/
function setJwtAndAuthHeader(string $value, stdClass $content): void {

	//enforce that the session is active
	if(session_status() !== PHP_SESSION_ACTIVE) {
		throw(new RuntimeException("Session not active."));
	}

	//create the signer object
	$signer = new Sha512();

	//create a UUID to sign the JWT and then store it in the session
	$signature = generateUuidV4();

	//store the signature in string format
	$_SESSION["signature"] = $signature->toString();

	$token = (new Builder())
		->set($value, $content)
		->setIssuer("https://bootcamp-coders.cnm.edu")
		->setAudience("https://bootcamp-coders.cnm.edu")
		->setId(session_id())
		->setIssuedAt(time())
		->setExpiration(time() + 3600)
		->sign($signer, $signature->toString())
		->getToken();

	$_SESSION["JWT-TOKEN"] = (string)$token;

	// add the JWT to the header
	header("X-JWT-TOKEN: $token");
}

/**
 * Verifies the X-JWT-TOKEN sent by Angular matches the JWT-TOKEN saved in
 * this session.
 *
 * This function uses two custom methods to insure that the JWT-TOKENs match.
 *
 * This function returns nothing, but will throw an exception when something
 * does not match.
 **/
function jwtValidator() {
	// retrieve the jwt from the header
	$headerJwt = validateJwtHeader();

	//enforce that the JWT is Valid and verified.
	verifiedAndValidatedSignature($headerJwt);
}

/**
 * Enforces the session contains all necessary information and the JWT in the
 * session matches the JWT sent by angular.
 *
 * @return \Lcobucci\JWT\Token the JWT token supplied by angular in the header
 * @throws InvalidArgumentException if JWT does not exist
 * @throws InvalidArgumentException if session does not contain a signature
 * @throws InvalidArgumentException if tokens from session and header do not match
 **/
function validateJwtHeader () : \Lcobucci\JWT\Token {

	//if the JWT does not exist in the cookie jar throw an exception
	$headers = array_change_key_case(apache_request_headers(), CASE_UPPER);
	if(array_key_exists("X-JWT-TOKEN", $headers) === false) {
		throw new InvalidArgumentException("Invalid Token.", 401);
	}

	//enforce the session has needed content
	if(empty($_SESSION["signature"]) === true ) {
		throw new InvalidArgumentException("Not logged in.", 401);
	}

	//grab the string representation of the Token from the header then parse it into an object
	$headerJwt = $headers["X-JWT-TOKEN"];
	$headerJwt = (new Parser())->parse($headerJwt);

	//enforce that the JWT payload in the session matches the payload from header
	if ($_SESSION["JWT-TOKEN"] !== (string)$headerJwt) {
		$_COOKIE = [];
		$_SESSION = [];
		throw (new InvalidArgumentException("Tokens do not match. Please log in again.", 401));
	}

	return $headerJwt;
}

/**
 * Enforce that the JWT has not been tampered with and is not expired.
 *
 * @param \Lcobucci\JWT\Token $headerJwt X-JWT-TOKEN sent by Angular
 * @throws InvalidArgumentException if JWT is invalid
 * @throws InvalidArgumentException if JWT is not signed by server
 **/
function verifiedAndValidatedSignature (\Lcobucci\JWT\Token $headerJwt) : void {

	//enforce the JWT is valid
	$validator = new ValidationData();
	$validator->setId(session_id());
	if($headerJwt->validate($validator) !== true) {
		throw (new InvalidArgumentException("Invalid JWT. Not authorized.", 401));
	}

	//verify that the JWT was signed by the server
	$signer = new Sha512();
	if($headerJwt->verify($signer, $_SESSION["signature"]) !== true) {
		throw (new InvalidArgumentException("Invalid JWT signature. Not authorized.", 401));
	}
}
