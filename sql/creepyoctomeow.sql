DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(64) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(32) NOT NULL,
	profileUsername VARCHAR(64) NOT NULL,
	UNIQUE (profileActivationToken),
	UNIQUE (profileEmail),
	UNIQUE (profileUsername),
	PRIMARY KEY (profileId)
);

CREATE TABLE post (
	postId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	postProfileId INT UNSIGNED NOT NULL,
	postContent VARCHAR(2000) NOT NULL,
	postDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	postTitle VARCHAR(64) NOT NULL,
	INDEX (postProfileId),
	FOREIGN KEY (postProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (postId)
);