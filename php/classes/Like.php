<?php
namespace Edu\Cnm\CreepyOctoMeow;

require_once ("autoload.php");
require_once (dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Like Class
 *
 * This class allows a Profile to "like" a Post.
 *
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 * @version 1.0
 **/

class Like implements \JsonSerializable {

	use ValidateDate;
	use ValidateUuid;

	/**
	 * id for the Post that is liked; this is a foreign key referencing Post.
	 * @var Uuid $likePostId
	 **/
	private $likePostId;

	/**
	 * id for the Profile that "likes" a Post; this is a foreign key referencing Profile.
	 * @var Uuid $likeProfileId
	 **/
	private $likeProfileId;

	/**
	 * constructor for this Like
	 *
	 * @param string|Uuid $newLikePostId id of the Post that is liked
	 * @param string|Uuid $newLikeProfileId id of the Profile liking a Post
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of range
	 * @throws \TypeError if data types violate type hinting
	 * @throws \Exception if other errors occur
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newLikePostId, $newLikeProfileId) {
		try {

		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for post id
	 *
	 * @return Uuid value of post id
	 **/
	public function getLikePostId() : Uuid {
		return($this->likePostId);
	}

	/**
	 * mutator method for post id
	 *
	 * @param Uuid|string $newLikePostId new value of post id
	 * @throws \RangeException if $newLikePostId is not positive
	 * @throws \TypeError if $newLikePostId is not a uuid or string
	 **/
	public function setLikePostId($newLikePostId) : void {
		try{
			$uuid = self::validateUuid($newLikePostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->likePostId->$uuid;
	}

	/**
	 * accessor method for profile id
	 *
	 * @return Uuid value of profile id
	 **/
	public function getLikeProfileId() : Uuid {
		return($this->likeProfileId);
	}

	/**
	 * mutator method for profile id
	 *
	 * @param Uuid|string $newLikeProfileId new value of profile id
	 * @throws \RangeException if $newLikeProfileId is not positive
	 * @throws \TypeError if $newLikeProfileId is not a uuid or string
	 **/
	public function setLikeProfileId($newLikeProfileId) : void {
		try{
			$uuid = self::validateUuid($newLikeProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->likeProfileId->$uuid;
	}

	/**
	 * inserts this Like into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO `like`(likePostId, likeProfileId) VALUES (:likePostId, :likeProfileId)";
		$statement = $pdo->prepare($query);

		//bind the member variables in place
		$parameters = [
			"likePostId" => $this->likePostId->getBytes(),
			"likeProfileId" => $this->likeProfileId->getBytes()
		];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Like from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		$query = "DELETE FROM `like` WHERE likePostId = :likePostId AND likeProfileId = :likeProfileId";
		$statement = $pdo->prepare($query);

		$parameters = [
			"likePostId" => $this->likePostId->getBytes(),
			"likeProfileId" => $this->likeProfileId->getBytes()
		];
		$statement->execute($parameters);
	}

	/**
	 * gets Likes by post id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $likePostId post id to search for
	 * @return \SplFixedArray array of likes per post id
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getLikesByLikePostId(\PDO $pdo, $likePostId) : \SplFixedArray {
		// sanitize the post id before searching
		try {
			$likePostId = self::validateUuid($likePostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likePostId, likeProfileId FROM `like` WHERE likePostId = :likePostId";
		$statement = $pdo->prepare($query);
		$parameters = ["likePostId" => $likePostId->getBytes()];
		$statement->execute($parameters);

		$likes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try{
				$like = new Like($row["likePostId"], $row["likeProfileId"]);
				$likes[$likes->key()] = $like;
				$likes->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return $likes;
	}

	/**
	 * gets Likes by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $likeProfileId profile id to search for
	 * @return \SplFixedArray array of likes per profile id
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getLikesByLikeProfileId(\PDO $pdo, $likeProfileId) : \SplFixedArray {
		//sanitize the profile id before searching
		try {
			$likeProfileId = self::validateUuid($likeProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likePostId, likeProfileId FROM `like` WHERE likeProfileId = :likeProfileId";
		$statement = $pdo->prepare($query);
		$parameters = ["likeProfileId" => $likeProfileId->getBytes()];
		$statement->execute($parameters);

		$likes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try{
				$like = new Like($row["likePostId"], $row["likeProfileId"]);
				$likes[$likes->key()] = $like;
				$likes->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return $likes;
	}

	/**
	 * gets Like by post id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $likePostId post id to search for
	 * @param Uuid|string $likeProfileId profile id to search for
	 * @return Like|null like found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getLikeByLikePostIdAndLikeProfileId(\PDO $pdo, $likePostId, $likeProfileId) : \SplFixedArray {
		//sanitize the post and profile ids before searching
		try {
			$likePostId = self::validateUuid($likePostId);
			$likeProfileId = self::validateUuid($likeProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT likePostId, likeProfileId FROM `like` WHERE likePostId = :likePostId AND likeProfileId = :likeProfileId";
		$statement = $pdo->prepare($query);
		$parameters = [
			"likePostId" => $likePostId->getBytes(),
			"likeProfileId" => $likeProfileId->getBytes()
		];
		$statement->execute($parameters);

		try {
			$like = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$like = new Like($row["likePostId"], $row["likeProfileId"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($like);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["likePostId"] = $this->likePostId->toString();
		$fields["likeProfileId"] = $this->likeProfileId->toString();
		return($fields);
	}

}