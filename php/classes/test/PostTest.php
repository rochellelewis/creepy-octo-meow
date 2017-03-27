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

		//create a valid post date - this gives us something preset to check against
		$this->VALID_DATE = new \DateTime();
	}

	/**
	 * test inserting a valid Post and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPost() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new post and insert
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->insert($this->getPDO());

		//grab the post back from mysql and check if all fields match
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoPost->getPostDate(), $this->VALID_DATE);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_TITLE);
	}

	/**
	 * test inserting a Post that already exists
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidPost() {
		//create a post with a non-null post id and watch it fail
		$post = new Post(PotentialBroccoliTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->insert($this->getPDO());
	}

	/**
	 * test inserting a Post, editing it, and then updating it
	 **/
	public function testUpdateValidPost() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new post and insert
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->insert($this->getPDO());

		//edit the post and run update method
		$post->setPostContent($this->VALID_CONTENT_2);
		$post->update($this->getPDO());

		//grab the post back from mysql and check if all fields match
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertEquals($pdoPost->getPostProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_CONTENT_2);
		$this->assertEquals($pdoPost->getPostDate(), $this->VALID_DATE);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_TITLE);
	}

	/**
	 * test updating a Post that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidPost() {
		//create a post, don't insert it, try updating it and watch it fail
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->update($this->getPDO());
	}

	/**
	 * test creating a Post and then deleting it
	 **/
	public function testDeleteValidPost() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new post and insert
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->insert($this->getPDO());

		//verify the row has been inserted, then run delete
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());

		//try and grab it back from mysql and verify that you get nothing
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}

	/**
	 * test deleting a Post that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidPost() {
		//create a post, don't insert it, try deleting it and watch it fail
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->delete($this->getPDO());
	}

	/**
	 * test grabbing Posts by Profile Id
	 **/
	public function testGetValidPostsByPostProfileId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new post and insert
		$post = new Post(null, $this->profile->getProfileId(), $this->VALID_CONTENT, $this->VALID_DATE, $this->VALID_TITLE);
		$post->insert($this->getPDO());

		//grab the posts from mysql, verify row count and namespace is correct
		$results = Post::getPostsByPostProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PotentialBroccoli\\Post", $results);

		//verify that all fields match
		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostContent(), $this->VALID_CONTENT);
		$this->assertEquals($pdoPost->getPostDate(), $this->VALID_DATE);
		$this->assertEquals($pdoPost->getPostTitle(), $this->VALID_TITLE);
	}

	/**
	 * test grabbing Posts by a Profile Id that does not exist
	 **/
	public function testGetPostByInvalidPostProfileId() {
		$posts = Post::getPostsByPostProfileId($this->getPDO(), parent::INVALID_KEY);
		$this->assertCount(0, $posts);
	}

	/**
	 * test grabbing Posts by post content
	 **/

	/**
	 * test grabbing Posts by content that does not exist
	 **/

	/**
	 * test grabbing Posts by post date range
	 **/

	/**
	 * test grabbing Posts by a date that does not exist
	 **/

	/**
	 * test grabbing Posts by title
	 **/

	/**
	 * test grabbing Posts by a title that does not exist
	 **/

	/**
	 * test grabbing all Posts
	 **/

}