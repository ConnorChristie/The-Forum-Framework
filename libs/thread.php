<?php
/*
Copyright (C) 2011  Jack Scott

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
/**
 * The class that handles all forum "threads". Threads are made up of posts.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */
class thread {
	/**
	 * When the load() method is used, posts is returned as an array of post id's in that thread
	 * @var Array
	 */
	public $posts = array ();
	/**
	 * The id of the thread
	 * @var Integer
	 */
	public $id;
	/**
	 * The forum id that the thread belongs to
	 * @var Integer
	 */
	public $forum;
	/**
	 * The user id that started the thread
	 * @var Integer
	 */
	public $poster;
	/**
	 * The threads subject
	 * @var String
	 */
	public $subject;
	/**
	 * The timestamp of when the thread was created.
	 * @var String
	 */
	public $timestamp;
	public $type;

	/**
	 * Loads the settings and mysql class
	 */
	function __construct() {
		$this->settings = new settings ();
		$this->mysql = new mysql ();
	}
	function canModify() {
		if ($_SESSION ['user']->getUser_id == $this->poster) {
			return true;
		}
		return false;

		//**TODO: Write a canModify method */
	}
	function setStatus($status) {
		if ($this->canModify ()) {
			if (! $this->mysql->query ( "
		UPDATE threads
		SET `status` = '$status'
		WHERE `id` = '$this->id'
		" ))
				throw new tffw_exception ( "Could not close thread", "Fatal Error", mysql_error () );
			return true;
		}
		return false;
	}

	/**
	 * Loads thread properties from the corresponding row in the database
	 * @param Integer $thread_id
	 * @throws mysql_exception
	 */
	function load($thread_id) {
		$this->id = $thread_id;
		mysql::connect();
		$sql = mysql_query ( "
  		SELECT *
  		FROM posts
  		WHERE `thread` = '$this->id'
  	" );
		if (! $sql)
			throw new tffw_exception ( "Could not load thread posts!", "Fatal Error", mysql_error () );
		while ( $row = mysql_fetch_array ( $sql ) ) {
			$this->posts [$row ['id']] = $row ['id'];
		}
		$sql = mysql_query ( "
  		SELECT *
  		FROM threads
  		WHERE `id` = '$this->id'
  	" );
		if (! $sql)
			throw new tffw_exception ( "Could not load thread posts!", "Fatal Error", mysql_error () );
		$row = mysql_fetch_array ( $sql );
		$this->forum = $row ['forum'];
		$this->poster = $row ['poster'];
		$this->subject = $row ['subject'];
		$this->timestamp = $row ['timestamp'];
		mysql::disconnect();
	}
	function save() {
		mysql::connect();
		$sql = mysql_query ( "
						SELECT *
						FROM `threads`
						WHERE
						`forum` = '$this->forum'
						AND `poster` = '$this->poster'
						AND `subject` = '$this->subject'
						AND `type` = '$this->type'
						" );
		mysql::disconnect();
		if (mysql_num_rows ( $sql ) < 1) {
			mysql::connect();
			$sql = mysql_query ( "
				INSERT INTO `threads`
				(`forum`,`poster`,`subject`,`type`)
				VALUES
				('$this->forum','$this->poster','$this->subject','$this->type')
				" );
			$row = mysql_fetch_array(mysql_query("select last_insert_id()"));
			$this->id = $row;
			mysql::disconnect();
		} else {
			mysql::connect();
			$sql = mysql_query ( "
				UPDATE `threads`
				SET
				`forum` = '$this->forum',
				`poster` = '$this->poster',
				`subject` = '$this->subject',
				`type` = '$this->type'
				WHERE `id` = '$this->id'
				" );
			$row = mysql_fetch_array(mysql_query("select last_insert_id()"));
			$this->id = $row;
			mysql::disconnect();
		}
		if (! $sql)
			throw new tffw_exception ( "Could not save thread", "Fatal Error", mysql_error () );
	}
	/**
	 * @return the $posts
	 */
	public function getPosts() {
		return $this->posts;
	}

	/**
	 * @param Array $posts
	 */
	public function setPosts($posts) {
		$this->posts = $posts;
	}

	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param Integer $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $forum
	 */
	public function getForum() {
		return $this->forum;
	}

	/**
	 * @param Integer $forum
	 */
	public function setForum($forum) {
		$this->forum = $forum;
	}

	/**
	 * @return the $poster
	 */
	public function getPoster() {
		return $this->poster;
	}

	/**
	 * @param Integer $poster
	 */
	public function setPoster($poster) {
		$this->poster = $poster;
	}

	/**
	 * @return the $subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param String $subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * @return the $timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * @param String $timestamp
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
	}

}

?>