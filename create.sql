DROP DATABASE IF EXISTS cake3movie;
CREATE DATABASE cake3movie DEFAULT CHARACTER SET utf8;

USE cake3movie;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	id int(11) NOT NULL AUTO_INCREMENT,
	email varchar(255) NOT NULL,
	nickname varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
	modified datetime DEFAULT NULL,
	created datetime DEFAULT NULL,
	PRIMARY KEY (id),
	UNIQUE KEY email (email)
);


DROP TABLE IF EXISTS playlists;
CREATE TABLE playlists(
	id int(11) NOT NULL AUTO_INCREMENT,
	name varchar(255) NOT NULL,
	user_id int(11) NOT NULL,
	modified datetime DEFAULT NULL,
	created datetime DEFAULT NULL,
	PRIMARY KEY (id)
);


DROP TABLE IF EXISTS playlist_movies;
CREATE TABLE playlist_movies(
	id int(11) NOT NULL AUTO_INCREMENT,
	movie_id varchar(255) NOT NULL,
	playlist_id int(11) NOT NULL,
	modified datetime DEFAULT NULL,
	created datetime DEFAULT NULL,
	PRIMARY KEY (id)
);


DROP TABLE ID EXISTS comments;
CREATE TABLE comments(
	id int(11) NOT NULL AUTO_INCREMENT,
	body varchar(255) NOT NULL,
	user_id int(11) NOT NULL,
	movie_id varchar(255) NOT NULL,
	modified datetime DEFAULT NULL,
	created datetime DEFAULT NULL,
	PRIMARY KEY (id)
);