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
 * Class for forum posts. Subclass of message.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */

class post {
	public $id, $poster, $thread, $subject, $body, $type;
	function __construct() {
		$this->settings = new settings ();
		$this->mysql = new mysql ();
	}
	function load($post_id, $get_username = false) {
		$this->id = $post_id;
		$sql = $this->mysql->query ( "
			SELECT *
			FROM `posts`
			WHERE `id` = '$this->id'
			" );
		if (! $sql)
			throw new tffw_exception ( "Post could not be loaded!", "Fatal Error", mysql_error () );
		$row = mysql_fetch_array ( $sql );
		$this->poster ['id'] = $row ['poster'];
		$this->thread = $row ['thread'];
		$this->subject = $row ['subject'];
		$this->body = $row ['body'];
		$this->type = $row ['type'];
		$id = $this->poster ['id'];

		//If requested, get the username of the poster. (normally only an ID is fetched).
		if ($get_username) {
			$sql = $this->mysql->query ( "
			SELECT *
			FROM `users`
			WHERE `id` = '$id'
			" ) or die ( mysql_error () );
			$row = mysql_fetch_array ( $sql );
			$this->poster ['username'] = $row ['username'];
		}
	}
	function save() {
		$sql = $this->mysql->query ( "
						SELECT *
						FROM `posts`
						WEHERE `thread` = '$this->thread'
						AND `poster` = '$this->poster'
						AND `subject` = '$this->subject'
						AND `body` = '$this->body'
						AND `type` = '$this->type'
						");
		if (mysql_num_rows ( $sql ) < 1) {
			$sql = $this->mysql->query ( "
				INSERT INTO `posts`
				(`thread`,`poster`,`subject`,`body`,`type`)
				VALUES
				('$this->thread','$this->poster','$this->subject','$this->body','$this->type')
				" );
			$row = mysql_fetch_array($this->mysql->query("select last_insert_id()"));
			$this->id = $row[0];
		} else{
			$sql = $this->mysql->query ( "
				UPDATE `posts`
				SET
				`thread` = '$this->thread',
				`poster` = '$this->poster',
				`subject` = '$this->subject',
				`body` = '$this->body',
				`type` = '$this->type'
				WHERE `id` = '$this->id'
				" );
			$row = mysql_fetch_array($this->mysql->query("select last_insert_id()"));
			$this->id = $row[0];
		}
		if (! $sql)
			throw new tffw_exception ( "Could not save thread", "Fatal Error", mysql_error () );
	}
	/**
	 * @return the $id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param field_type $id
	 */
	public function setId($id) {
		$this->id = $id;
	}

	/**
	 * @return the $poster
	 */
	public function getPoster() {
		return $this->poster;
	}

	/**
	 * @param field_type $poster
	 */
	public function setPoster($poster) {
		$this->poster = $poster;
	}

	/**
	 * @return the $thread
	 */
	public function getThread() {
		return $this->thread;
	}

	/**
	 * @param field_type $thread
	 */
	public function setThread($thread) {
		$this->thread = $thread;
	}

	/**
	 * @return the $subject
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param field_type $subject
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * @return the $body
	 */
	public function getBody() {
		return $this->body;
	}

	/**
	 * @param field_type $body
	 */
	public function setBody($body) {
		$this->body = $body;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}

}