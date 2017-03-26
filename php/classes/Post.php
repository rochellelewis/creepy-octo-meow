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


}