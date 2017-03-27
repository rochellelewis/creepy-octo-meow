<?php
 namespace Edu\Cnm\PotentialBroccoli\Test;

 use Edu\Cnm\PotentialBroccoli\{Profile, ValidateDate};

 //grab the project test parameters
 require_once ("PotentialBroccoliTest.php");

 //grab the class under scrutiny
 require_once (dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 **/
class ProfileTest extends PotentialBroccoliTest {
	/**
	 * Profile activation token
	 * @var string $VALID_ACTIVATION
	 **/

	/**
	 * Profile email address
	 * @var string $VALID_EMAIL
	 **/

	/**
	 * Profile password hash
	 * @var string $VALID_HASH
	 **/

	/**
	 * Profile password salt
	 * @var string $VALID_SALT
	 **/

	/**
	 * Profile password username
	 * @var string $VALID_USERNAME
	 **/

}