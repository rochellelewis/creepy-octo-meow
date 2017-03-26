<?php
namespace Edu\Cnm\PotentialBroccoli;

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
	public function __construct(int $newPostId = null, int $newPostProfileId, string $newPostContent, $newPostDate = null, string $newPostTitle) {
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
	 * accessor method for post id
	 *
	 * @return int|null value of post id
	 **/
	public function getPostId() {
		return($this->postId);
	}

	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/
	public function setPostId(int $newPostId = null) {
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
	public function getPostProfileId() {
		return($this->postProfileId);
	}

	/**
	 * mutator method for post profile id
	 *
	 * @param int $newPostProfileId new value of post profile id
	 * @throws \RangeException if $newPostProfileId is not positive
	 * @throws \TypeError if $newPostProfileId is not an integer
	 **/
	public function setPostProfileId(int $newPostProfileId) {
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
	public function getPostContent(){
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
	public function setPostContent(string $newPostContent) {
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
	 * accessor method for post id
	 *
	 * @return int|null value of post id
	 **/

	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/

	/**
	 * accessor method for post id
	 *
	 * @return int|null value of post id
	 **/

	/**
	 * mutator method for post id
	 *
	 * @param int|null $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/

}