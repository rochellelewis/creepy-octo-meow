<?php
namespace Edu\Cnm\CreepyOctoMeow;

require_once ("autoload.php");

/**
 * Post Class
 *
 * This represents all data contained in a Post.
 *
 * @author Rochelle Lewis <rlewis37@cnm.edu>
 * @version 1.0
 **/

class Post implements \JsonSerializable {

	use ValidateDate;

	/**
	 * id for the Post; this is the Primary Key.
	 * @var int $postId
	 **/
	private $postId;

	/**
	 * id for the Profile that authored the Post; this is the Foreign Key.
	 * @var int $postProfileId
	 **/
	private $postProfileId;

	/**
	 * Text content of the Post.
	 * @var string $postContent
	 **/
	private $postContent;

	/**
	 * Timestamp created when Post is inserted.
	 * @var \DateTime $postDate
	 **/
	private $postDate;

	/**
	 * Title of the Post.
	 * @var string $postTitle
	 **/
	private $postTitle;

	/**
	 * Constructor for this Post
	 *
	 * @param int|null $newPostId id of this Post, or null if a new Post
	 * @param int $newPostProfileId profile id of the author of this Post
	 * @param string $newPostContent text content of this Post
	 * @param \DateTime|string|null $newPostDate date and time this Post was created
	 * @param string $newPostTitle title of this Post
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if other exceptions occur
	 **/
	public function __construct(?int $newPostId, int $newPostProfileId, string $newPostContent, $newPostDate = null, string $newPostTitle) {
		try {
			$this->setPostId($newPostId);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostContent($newPostContent);
			$this->setPostDate($newPostDate);
			$this->setPostTitle($newPostTitle);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for post id
	 *
	 * @return int|null value of post id
	 **/
	public function getPostId() : ?int {
		return($this->postId);
	}

	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/
	public function setPostId(?int $newPostId) : void {
		//base case: if post id is null, this is a new Post and mysql will assign the primary key
		if($newPostId === null) {
			$this->postId = null;
			return;
		}

		//check if post id is positive
		if($newPostId <= 0) {
			throw (new \RangeException("Post id is not positive."));
		}

		//convert and store the post id
		$this->postId = $newPostId;
	}

	/**
	 * accessor method for post profile id
	 *
	 * @return int value of post profile id
	 **/
	public function getPostProfileId() : int {
		return($this->postProfileId);
	}

	/**
	 * mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of post profile id
	 * @throws \RangeException if $newPostProfileId is not positive
	 * @throws \TypeError if $newPostProfileId is not an integer
	 **/
	public function setPostProfileId(int $newPostProfileId) : void {
		//check for a valid profile id
		if($newPostProfileId <= 0) {
			throw (new \RangeException("Post profile id is not positive."));
		}

		//store the profile id
		$this->postProfileId = $newPostProfileId;
	}

	/**
	 * accessor method for post content
	 *
	 * @return string value of post content
	 **/
	public function getPostContent() : string {
		return($this->postContent);
	}

	/**
	 * mutator method for post content
	 *
	 * @param string $newPostContent text content of post
	 * @throws \InvalidArgumentException if $newPostContent is invalid or insecure
	 * @throws \RangeException if $newPostContent is > 2000 characters
	 * @throws \TypeError if $newPostContent is not a string
	 **/
	public function setPostContent(string $newPostContent) : void {
		//trim, sanitize post content
		$newPostContent = trim($newPostContent);
		$newPostContent = filter_var($newPostContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostContent) === true) {
			throw (new \InvalidArgumentException("Post content is invalid or insecure."));
		}

		//check post content length
		if(strlen($newPostContent) > 2000) {
			throw (new \RangeException("Post content is too long."));
		}

		//store post content
		$this->postContent = $newPostContent;
	}

	/**
	 * accessor method for post date
	 *
	 * @return \DateTime value of post date
	 **/
	public function getPostDate() : \DateTime {
		return($this->postDate);
	}

	/**
	 * mutator method for post date
	 *
	 * @param \DateTime|string|null $newPostDate post date as a DateTime object, string, or null value
	 * @throws \InvalidArgumentException if $newPostDate is not a valid object or string
	 * @throws \RangeException if $newPostDate is a date that does not exist
	 **/
	public function setPostDate($newPostDate = null) : void {
		//base case: if post date is null, use current date and time
		if($newPostDate === null) {
			$this->postDate = new \DateTime();
			return;
		}

		//store post date
		try {
			$newPostDate = self::validateDateTime($newPostDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->postDate = $newPostDate;
	}

	/**
	 * accessor method for post title
	 *
	 * @return string value of post title
	 **/
	public function getPostTitle() : string {
		return($this->postTitle);
	}

	/**
	 * mutator method for post title
	 *
	 * @param string $newPostTitle title of post
	 * @throws \InvalidArgumentException if $newPostTitle is invalid or insecure
	 * @throws \RangeException if $newPostTitle is greater than 64 characters
	 * @throws \TypeError if $newPostTitle is not a string
	 **/
	public function setPostTitle(string $newPostTitle) : void {
		//trim, filter post title
		$newPostTitle = trim($newPostTitle);
		$newPostTitle = filter_var($newPostTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostTitle) === true) {
			throw (new \InvalidArgumentException("Post title is invalid or insecure."));
		}

		//check post title length
		if(strlen($newPostTitle) > 64) {
			throw (new \RangeException("Post title is too long."));
		}

		//store post title
		$this->postTitle = $newPostTitle;
	}

	/**
	 * inserts this Post into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//verify the post id is null / don't insert a post that already exists!
		if($this->postId !== null) {
			throw(new \PDOException("Not a new post."));
		}

		//create query template
		$query = "INSERT INTO post(postProfileId, postContent, postDate, postTitle) VALUES(:postProfileId, :postContent, :postDate, :postTitle)";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$formattedDate = $this->postDate->format("Y-m-d H:i:s");
		$parameters = [
			"postProfileId" => $this->postProfileId,
			"postContent" => $this->postContent,
			"postDate" => $formattedDate,
			"postTitle" => $this->postTitle
		];
		$statement->execute($parameters);

		//update null postId with what mysql gave us
		$this->postId = intval($pdo->lastInsertId());
	}

	/**
	 * updates this Post in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		//verify the post id is not null / don't update a post that doesn't exist!
		if($this->postId === null) {
			throw(new \PDOException("Post does not exist."));
		}

		//create query template
		$query = "UPDATE post SET postProfileId = :postProfileId, postContent = :postContent, postDate = :postDate, postTitle = :postTitle WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$formattedDate = $this->postDate->format("Y-m-d H:i:s");
		$parameters = [
			"postProfileId" => $this->postProfileId,
			"postContent" => $this->postContent,
			"postDate" => $formattedDate,
			"postTitle" => $this->postTitle,
			"postId" => $this->postId
		];
		$statement->execute($parameters);
	}

	/**
	 * deletes this Post from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//verify the post id is not null / don't delete a post that doesn't exist!
		if($this->postId === null) {
			throw(new \PDOException("Post does not exist."));
		}

		//create query template
		$query = "DELETE FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$parameters = ["postId" => $this->postId];
		$statement->execute($parameters);
	}

	/**
	 * gets a Post by postId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $postId post id to search for
	 * @return Post|null Post found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostByPostId(\PDO $pdo, $postId) {
		//verify the post id
		if($postId <= 0) {
			throw (new \PDOException("Post id is not positive."));
		}

		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post WHERE postId = :postId";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$parameters = ["postId" => $postId];
		$statement->execute($parameters);

		//grab post from mysql
		try {
			$post = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
			}
		} catch(\Exception $exception) {
			throw (new \PDOException($exception->getMessage(), 0 , $exception));
		}

		return($post);
	}

	/**
	 * gets Posts by postProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $postProfileId profile id of author to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostsByPostProfileId(\PDO $pdo, $postProfileId) {
		//verify post profile id
		if($postProfileId <= 0) {
			throw (new \PDOException("Post profile id is not positive."));
		}

		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post WHERE postProfileId = :postProfileId";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$parameters = ["postProfileId" => $postProfileId];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($posts);
	}

	/**
	 * gets Posts by postContent
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postContent post text content to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostsByPostContent(\PDO $pdo, $postContent) {
		//trim, filter post content before searching
		$postContent = trim($postContent);
		$postContent = filter_var($postContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($postContent) === true) {
			throw (new \PDOException("Post content is invalid or insecure."));
		}

		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post WHERE postContent LIKE :postContent";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$parameters = ["postContent" => $postContent];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($posts);
	}

	/**
	 * gets Posts by postDate, within a user-given range of dates
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \DateTime $postSunriseDate start of date range to search within
	 * @param \DateTime $postSunsetDate end of date range to search within
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \InvalidArgumentException if search dates are invalid or insecure
	 * @throws \RangeException if search date range is invalid
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostsByPostDateRange (\PDO $pdo, $postSunriseDate, $postSunsetDate) {
		//check, validate search dates
		if((empty($postSunriseDate) === true) || (empty($postSunsetDate) === true)) {
			throw (new \PDOException("Post date range is empty or invalid"));
		}

		try{
			$postSunriseDate = self::validateDateTime($postSunriseDate);
			$postSunsetDate = self::validateDateTime($postSunsetDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw (new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw (new \RangeException($range->getMessage(), 0, $range));
		}

		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post WHERE postDate >= :postSunriseDate AND postDate <= :postSunsetDate";
		$statement = $pdo->prepare($query);

		//format and bind dates to the placeholders in the query template
		$formattedSunriseDate = $postSunriseDate->format("Y-m-d H:i:s");
		$formattedSunsetDate = $postSunsetDate->format("Y-m-d H:i:s");
		$parameters = [
			"postSunriseDate" => $formattedSunriseDate,
			"postSunsetDate" => $formattedSunsetDate
		];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($posts);
	}

	/**
	 * gets Posts by postTitle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $postTitle post title to search for
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getPostsByPostTitle(\PDO $pdo, $postTitle) {
		//trim, filter post title before searching
		$postTitle = trim($postTitle);
		$postTitle = filter_var($postTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($postTitle) === true) {
			throw (new \PDOException("Post title is invalid or insecure."));
		}

		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post WHERE postTitle LIKE :postTitle";
		$statement = $pdo->prepare($query);

		//bind member variables to the placeholders in the query template
		$parameters = ["postTitle" => $postTitle];
		$statement->execute($parameters);

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($posts);
	}

	/**
	 * gets all Posts
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Posts found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllPosts(\PDO $pdo) {
		//create query template
		$query = "SELECT postId, postProfileId, postContent, postDate, postTitle FROM post";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of posts
		$posts = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$post = new Post($row["postId"], $row["postProfileId"], $row["postContent"], $row["postDate"], $row["postTitle"]);
				$posts[$posts->key()] = $post;
				$posts->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}

		return($posts);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["postDate"] = $this->postDate->getTimestamp() * 1000;
		return($fields);
	}

}