-- The statement below sets the collation of the database to utf8
ALTER DATABASE rlewis37 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DROP TABLE IF EXISTS `like`;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(64) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileUsername VARCHAR(64) NOT NULL,
	UNIQUE (profileActivationToken),
	UNIQUE (profileEmail),
	UNIQUE (profileUsername),
	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId BINARY(16) NOT NULL,
	postProfileId BINARY(16) NOT NULL,
	postContent VARCHAR(2000) NOT NULL,
	postDate DATETIME(6) NOT NULL,
	postTitle VARCHAR(64) NOT NULL,
	INDEX (postProfileId),
	FOREIGN KEY (postProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (postId)
);

CREATE TABLE `like` (
	likePostId BINARY(16) NOT NULL,
	likeProfileId BINARY(16) NOT NULL,
	INDEX (likePostId),
	INDEX (likeProfileId),
	FOREIGN KEY (likePostId) REFERENCES post(postId),
	FOREIGN KEY (likeProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (likePostId, likeProfileId)
)