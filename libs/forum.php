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
class forum {
	public $title;
	public $explanation;
	public $parent;
	public $id;
	public $type;
	public $threads = array ();

	function __construct() {
		$this->settings = new settings ();
		$this->mysql = new mysql ();
	}
	/**
	 * Loads an existing forum from the database using the forum's ID
	 * Creates an array of threads inside the forum.
	 * @param Integer $id
	 */
	function load($forum_id) {
		$this->id = $forum_id;
		mysql::connect();
		$sql = mysql_query ( "
			SELECT *
			FROM threads
			WHERE `forum` = '$this->id'
	" );
		if (! $sql)
			throw new tffw_exception ( "Threads could not be loaded for forum!", "Fatal Error", mysql_error () );
		while ( $row = mysql_fetch_array ( $sql ) ) {
			$this->threads [$row ['id']] = $row ['id'];
		}
		$sql = mysql_query ( "
			SELECT *
			FROM forums
			WHERE `id` = '$this->id'
	" );
		if (! $sql)
			throw new tffw_exception ( "Threads could not be loaded for forum!", "Fatal Error", mysql_error () );
		$row = mysql_fetch_array ( $sql );
		$this->title = $row ['title'];
		$this->parent = $row ['parent'];
		$this->explanation = $row ['explanation'];
		mysql::disconnect();
	}
	/**
	 * @return the $title
	 */
	function save() {
		mysql::connect();
		$sql = mysql_query ( "
						SELECT *
						FROM `forums`
						WHERE `title` = '$this->title'
						AND `explanation` = '$this->explanation'
						AND `type` = '$this->type'
						AND `parent` = '$this->parent'
						" );
		if (mysql_num_rows ( $sql ) < 1) {
			$sql = mysql_query ( "
				INSERT INTO `forums`
				(`title`,`explanation`,`parent`,`type`)
				VALUES
				('$this->title','$this->explanation','$this->parent','$this->type')
				" );
			$row = mysql_fetch_array($this->mysql->query("select last_insert_id()"));
			$this->id = $row[0];
			mysql::disconnect();
		} else {
			$sql = mysql_query("
				UPDATE `forums`
				SET
				`title` = '$this->title',
				`explanation` = '$this->explanation',
				`parent` = '$this->parent',
				`type` = '$this->type'
				WHERE `id` = '$this->id'
			");
			$row = mysql_fetch_array($this->mysql->query("select last_insert_id()"));
			$this->id = $row[0];
			mysql::disconnect();
		}
		if (! $sql) throw new tffw_exception( "Could not save forum", "Fatal Error", mysql_error () );
	}
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return the $explanation
	 */
	public function getExplanation() {
		return $this->explanation;
	}

	/**
	 * @param field_type $explanation
	 */
	public function setExplanation($explanation) {
		$this->explanation = $explanation;
	}

	/**
	 * @return the $parent
	 */
	public function getParent() {
		return $this->parent;
	}

	/**
	 * @param field_type $parent
	 */
	public function setParent($parent) {
		$this->parent = $parent;
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
	 * @return the $threads
	 */
	public function getThreads() {
		return $this->threads;
	}

	/**
	 * @param field_type $threads
	 */
	public function setThreads($threads) {
		$this->threads = $threads;
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

?>