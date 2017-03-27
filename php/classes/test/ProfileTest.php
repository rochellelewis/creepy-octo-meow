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
	protected $VALID_ACTIVATION = "aae04b1d8089795764c5f759ab387872";

	/**
	 * Profile email address
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "drumpf@tinyhands.ru";

	/**
	 * Profile password hash
	 * @var string $VALID_HASH
	 **/
	protected $VALID_HASH = null;

	/**
	 * Profile password to use in test
	 * @var string $PASSWORD
	 **/
	protected $PASSWORD = "password123";

	/**
	 * Profile password salt
	 * @var string $VALID_SALT
	 **/
	protected $VALID_SALT = null;

	/**
	 * Profile password username
	 * @var string $VALID_USERNAME
	 **/
	protected $VALID_USERNAME = "bernie";

	/**
	 * create dependent objects before running each test
	 **/
	public final function setUp() {
		//run the default setUp() method first
		parent::setUp();

		//create valid salt
		$this->VALID_SALT = bin2hex(random_bytes(16));

		//create valid password hash
		$this->VALID_HASH = hash_pbkdf2("sha512", $this->PASSWORD, $this->VALID_SALT, 262144);
	}

	/**
	 * test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//grab profile back from mysql and verify all fields match
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
	}

	/**
	 * test inserting a Profile that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile() {
		//create profile with non-null profile id and watch it fail
		$profile = new Profile(PotentialBroccoliTest::INVALID_KEY, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());
	}

	/**
	 * test inserting a Profile, editing it, and then updating it
	 **/

	/**
	 * test updating a Profile that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	/**
	 * test creating a Profile and then deleting it
	 **/

	/**
	 * test deleting a Profile that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	/**
	 * test grabbing a Profile by profile activation token
	 **/

	/**
	 * test grabbing a Profile by an activation token that does not exist
	 **/

	/**
	 * test grabbing a Profile by email
	 **/

	/**
	 * test grabbing a Profile by an email that does not exist
	 **/

	/**
	 * test grabbing a Profile by profile username
	 **/

	/**
	 * test grabbing a Profile by a username that does not exist
	 **/

	/**
	 * test grabbing all Profiles
	 **/
}