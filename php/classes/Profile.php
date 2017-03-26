<?php

namespace Edu\Cnm\PotentialBroccoli;

require_once ("autoload.php");

/**
 * Profile Class
 *
 * This represents all data contained in a user's Profile.
 *
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 * @version 1.0
 **/

class Profile implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for the Profile; this is the Primary Key.
	 * @var int $profileId
	 **/
	private $profileId;

	/**
	 * Email address for the Profile. This is unique.
	 * @var string $profileEmail
	 **/
	private $profileEmail;

	/**
	 * Hash value for the Profile password.
	 * @var string $profileHash
	 **/
	private $profileHash;

	/**
	 * Salt for the Profile password hash value.
	 * @var string $profileSalt
	 **/
	private $profileSalt;

	/**
	 * User name for the Profile. This is unique.
	 * @var string $profileUsername
	 **/
	private $profileUsername;

	/**
	 * Constructor for this Profile
	 *
	 * @param int|null $newProfileId id of this Profile, or null if a new Profile
	 * @param string $newProfileEmail email address for this Profile
	 * @param string $newProfileHash hash value for the Profile password
	 * @param string $newProfileSalt salt for the hash value for the Profile password
	 * @param string $newProfileUsername Username for the Profile
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if other exceptions occur
	 **/
	public function __construct(int $newProfileId = null, string $newProfileEmail, string $newProfileHash, string $newProfileSalt, string $newProfileUsername) {
		try {

		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw (new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			throw (new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			throw (new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for profile id
	 *
	 * @return int|null value of profile id
	 **/
	public function getProfileId() {
		return($this->profileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param int|null $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(int $newProfileId = null) {
		//base case: if profile id is null, this is a new profile and mysql will assign the primary key
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		//check if profile id is positive
		if($newProfileId <= 0) {
			throw (new \RangeException("Profile Id is not positive."));
		}

		//convert and store the profile id
		$this->profileId = $newProfileId;
	}


}