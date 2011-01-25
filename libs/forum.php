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
	public $forum_title;
	public $forum_explanation;
	public $forum_parent;
	public $forum_id;
	public $forum_threads = array();
  /**
 * @return the $forum_title
 */
  public function getForum_title(){
    return $this->forum_title;
  }

	/**
 * @return the $forum_explanation
 */
  public function getForum_explanation(){
    return $this->forum_explanation;
  }

	/**
 * @return the $forum_parent
 */
  public function getForum_parent(){
    return $this->forum_parent;
  }

	/**
 * @return the $forum_id
 */
  public function getForum_id(){
    return $this->forum_id;
  }

	/**
 * @param field_type $forum_title
 */
  public function setForum_title($forum_title){
    $this->forum_title = $forum_title;
  }

	/**
 * @param field_type $forum_explanation
 */
  public function setForum_explanation($forum_explanation){
    $this->forum_explanation = $forum_explanation;
  }

	/**
 * @param field_type $forum_parent
 */
  public function setForum_parent($forum_parent){
    $this->forum_parent = $forum_parent;
  }

	/**
 * @param field_type $forum_id
 */
  public function setForum_id($forum_id){
    $this->forum_id = $forum_id;
  }

/**
 * @return the $forum_threads
 */
  public function getForum_threads(){
    return $this->forum_threads;
  }

	/**
 * @param field_type $forum_threads
 */
  public function setForum_threads($forum_threads){
    $this->forum_threads = $forum_threads;
  }

function __construct(){
    $this->settings = new settings ();
    $this->mysql = new mysql();
  }
  function load($forum_id){
  	$this->forum_id = $forum_id;
	$sql = $this->mysql->query("
			SELECT *
			FROM threads
			WHERE `forum` = '$this->forum_id'
	");
	if(!$sql) throw new mysql_exception("Threads could not be loaded for forum!", mysql_error(), "Fatal Error");
	while ($row = mysql_fetch_array($sql)){
      $this->forum_threads[$row['id']] = $row['id'];
	}
	$sql = $this->mysql->query("
			SELECT *
			FROM forums
			WHERE `id` = '$this->forum_id'
	");
	if(!$sql) throw new mysql_exception("Threads could not be loaded for forum!", mysql_error(), "Fatal Error");
	$row = mysql_fetch_array($sql);
	$this->forum_title  = $row['title'];
	$this->forum_parent = $row['parent'];
	$this->forum_explanation = $row['explanation'];
  }
}

?>