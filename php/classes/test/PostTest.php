<?php

namespace Edu\Cnm\PotentialBroccoli\Test;

use Edu\Cnm\PotentialBroccoli\{Profile, Post};

//grab the project test parameters
require_once ("PotentialBroccoliTest.php");

//grab the classes under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Post class
 *
 * This is a complete PHPUnit test of the Post class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Post
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 **/
class PostTest extends PotentialBroccoliTest {
	/**
	 * content of the Post
	 * @var string $VALID_CONTENT
	 **/
	protected $VALID_CONTENT = "This is a valid post!";

	/**
	 * content of the Post to test update method
	 * @var string $VALID_CONTENT_2
	 **/
	protected $VALID_CONTENT_2 = "This is an updated post! Yay!";

	/**
	 * date of the Post
	 * @var \DateTime $VALID_DATE
	 **/
	protected $VALID_DATE = null;

	/**
	 * title of the Post
	 * @var string $VALID_TITLE
	 **/
	protected $VALID_TITLE = "I'm a valid post title!";

	/**
	 * Profile that created the Post; this is to test foreign key relations
	 * @var Profile profile
	 **/
	protected $profile = null;

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create and insert a profile to be the author of the test post
		$activation = bin2hex(random_bytes(16));
		$salt = bin2hex(random_bytes(16));
		$hash = hash_pbkdf2("sha512", "password123", $salt, 262144);
		$this->profile = new Profile(null, $activation, "drumpf@tinyhands.ru", $hash, $salt, "bernie");
		$this->profile->insert($this->getPDO());

		//create a valid post date
		$this->VALID_DATE = new \DateTime();
	}

	/**
	 * test inserting a valid Post and verify that the actual mySQL data matches
	 **/

}