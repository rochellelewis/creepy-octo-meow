<?php
 namespace Edu\Cnm\CreepyOctoMeow\Test;

 use Edu\Cnm\CreepyOctoMeow\Profile;

 //grab the project test parameters
 require_once("CreepyOctoMeowTest.php");

 //grab the class under scrutiny
 require_once (dirname(__DIR__) . "/autoload.php");

 //grab the uuid generator
 require_once (dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Profile class
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 **/
class ProfileTest extends CreepyOctoMeowTest {
	/**
	 * Profile activation token
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATION = "aae04b1d8089795764c5f759ab387872";

	/**
	 * Profile activation token - to test invalid case. this will not be inserted
	 * @var string $VALID_ACTIVATION_2
	 **/
	protected $VALID_ACTIVATION_2 = "c3036bf1d0a1eb478dcc03c93fda5383";

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
	 * Profile password username to test update
	 * @var string $VALID_USERNAME_2
	 **/
	protected $VALID_USERNAME_2 = "elizabeth";

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
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
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
	 * test inserting a Profile, editing it, and then updating it
	 **/
	public function testUpdateValidProfile() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//edit the profile and run update method
		$profile->setProfileUsername($this->VALID_USERNAME_2);
		$profile->update($this->getPDO());

		//grab the profile back from mysql and check that all fields match
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME_2);
	}

	/**
	 * test creating a Profile and then deleting it
	 **/
	public function testDeleteValidProfile() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//delete the profile we just made
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		//try and grab the profile back from mysql and verify we get nothing
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertNull($pdoProfile);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * test grabbing a Profile by profile activation token
	 **/
	public function testGetValidProfileByProfileActivationToken() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//grab profile back from mysql and check that all fields match
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by an activation token that does not exist
	 **/
	public function testGetInvalidProfileByProfileActivationToken() {
		//try and grab a profile by an activation token that doesn't exist
		$profile = Profile::getProfileByProfileActivationToken($this->getPDO(), $this->VALID_ACTIVATION_2);
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a Profile by email
	 **/
	public function testGetValidProfileByProfileEmail() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//grab profile back from mysql and check that all fields match
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
	}

	/**
	 * test grabbing a Profile by an email that does not exist
	 **/
	public function testGetInvalidProfileByProfileEmail() {
		//try and grab a profile by an email that doesn't exist
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "nothing@nada.com");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing a Profile by profile username
	 **/
	public function testGetValidProfileByProfileUsername() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//grab profile back from mysql and check that all fields match
		$pdoProfile = Profile::getProfileByProfileUsername($this->getPDO(), $profile->getProfileUsername());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
	}

	/**
	 * test grabbing a Profile by a username that does not exist
	 **/
	public function testGetInvalidProfileByProfileUsername() {
		//try and grab a profile by a username that doesn't exist
		$profile = Profile::getProfileByProfileUsername($this->getPDO(), "you will find nothing");
		$this->assertNull($profile);
	}

	/**
	 * test grabbing all Profiles
	 **/
	public function testGetAllProfiles() {
		//count number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("profile");

		//create new profile and insert
		$profileId = generateUuidV4();
		$profile = new Profile($profileId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_USERNAME);
		$profile->insert($this->getPDO());

		//grab all profiles back from mysql and check that the count matches
		$results = Profile::getAllProfiles($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CreepyOctoMeow\\Profile", $results);

		//grab the first index out of the results array and check that all fields match what was inserted
		$pdoProfile = $results[0];
		$this->assertEquals($pdoProfile->getProfileId(), $profile->getProfileId());
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileUsername(), $this->VALID_USERNAME);
	}
}