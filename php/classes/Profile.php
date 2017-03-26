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

	/**
	 * accessor method for profile email
	 *
	 * @return string value of profile email
	 **/
	public function getProfileEmail() {
		return($this->profileEmail);
	}

	/**
	 * mutator method for profile email
	 *
	 * @param string $newProfileEmail new value of profile email
	 * @throws \InvalidArgumentException if $newProfileEmail is invalid or insecure
	 * @throws \RangeException if $newProfileEmail is > 64 characters
	 * @throws \TypeError if $newProfileEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) {
		//sanitize profile email content, check if secure
		$newProfileEmail= trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_SANITIZE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw (new \InvalidArgumentException("Profile email is invalid or insecure"));
		}

		//check profile email length
		if(strlen($newProfileEmail) > 64) {
			throw (new \RangeException("Profile email is too long."));
		}

		//store profile email
		$this->profileEmail = $newProfileEmail;
	}

	/**
	 * accessor method for profile password hash
	 *
	 * @return string value of profile password hash
	 **/
	public function getProfileHash() {
		return($this->profileHash);
	}

	/**
	 * mutator method for profile password hash
	 *
	 * @param string $newProfileHash new value of profile password hash
	 * @throws \InvalidArgumentException if $newProfileHash is empty, or not a valid hash value
	 * @throws \RangeException if $newProfileHash is not 128 characters
	 * @throws \TypeError if $newProfileHash is not a string
	 **/
	public function setProfileHash(string $newProfileHash) {
		//trim, filter pass hash input
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = filter_var($newProfileHash, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileHash) === true) {
			throw (new \InvalidArgumentException("Profile password hash empty or insecure."));
		}

		//check if valid hash value
		if(!ctype_xdigit($newProfileHash)) {
			throw (new \InvalidArgumentException("Profile password hash is invalid"));
		}

		//check if valid length
		if(strlen($newProfileHash) !== 128) {
			throw (new \RangeException("profile password hash invalid length"));
		}

		//store password hash value
		$this->profileHash = $newProfileHash;

	}


}