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
   * When the load() method is used, thread_posts is returned as an array of post id's in that thread
   * @var Array
   */
  public $thread_posts = array ();
  /**
   * The id of the thread
   * @var Integer
   */
  public $thread_id;
  /**
   * The forum id that the thread belongs to
   * @var Integer
   */
  public $thread_forum;
  /**
   * The user id that started the thread
   * @var Integer
   */
  public $thread_poster;
  /**
   * The threads subject
   * @var String
   */
  public $thread_subject;
  /**
   * The timestamp of when the thread was created.
   * @var String
   */
  public $thread_timestamp;

  /**
   * Loads the settings and mysql class
   */
  function __construct(){
    $this->settings = new settings ();
    $this->mysql = new mysql ();
  }
  function canModify(){
  	if ($_SESSION['user']->getUser_id == $this->thread_poster){
  		return true;
  	}
  	return false;
  	//**TODO: Write a canModify method */
  }
  function setStatus($status){
    if ($this->canModify ()) {
      if (! $this->mysql->query ( "
		UPDATE threads
		SET `status` = '$status'
		WHERE `id` = '$this->thread_id'
		" )) throw new mysql_exception ( "Could not close thread", mysql_error (), "Fatal Error" );
      return true;
    }
    return false;
  }
  /**
   * @return the $thread_posts
   */
  public function getThread_posts(){
    return $this->thread_posts;
  }

  /**
   * @return the $thread_id
   */
  public function getThread_id(){
    return $this->thread_id;
  }

  /**
   * @return the $thread_forum
   */
  public function getThread_forum(){
    return $this->thread_forum;
  }

  /**
   * @return the $thread_poster
   */
  public function getThread_poster(){
    return $this->thread_poster;
  }

  /**
   * @return the $thread_subject
   */
  public function getThread_subject(){
    return $this->thread_subject;
  }

  /**
   * @return the $thread_timestamp
   */
  public function getThread_timestamp(){
    return $this->thread_timestamp;
  }

  /**
   * @param Array $thread_posts
   */
  public function setThread_posts($thread_posts){
    $this->thread_posts = $thread_posts;
  }

  /**
   * @param Integer $thread_id
   */
  public function setThread_id($thread_id){
    $this->thread_id = $thread_id;
  }

  /**
   * @param Integer $thread_forum
   */
  public function setThread_forum($thread_forum){
    $this->thread_forum = $thread_forum;
  }

  /**
   * @param Integer $thread_poster
   */
  public function setThread_poster($thread_poster){
    $this->thread_poster = $thread_poster;
  }

  /**
   * @param String $thread_subject
   */
  public function setThread_subject($thread_subject){
    $this->thread_subject = $thread_subject;
  }

  /**
   * @param String $thread_timestamp
   */
  public function setThread_timestamp($thread_timestamp){
    $this->thread_timestamp = $thread_timestamp;
  }

  /**
   * Loads thread variables from the corresponding row in the database
   * @param Integer $thread_id
   * @throws mysql_exception
   */
  function load($thread_id){
    $this->thread_id = $thread_id;
    $sql = $this->mysql->query ( "
  		SELECT *
  		FROM posts
  		WHERE `thread` = '$this->thread_id'
  	" );
    if (! $sql) throw new mysql_exception ( "Could not load thread posts", mysql_error (), "Fatal Error" );
    while ( $row = mysql_fetch_array ( $sql ) ) {
      $this->thread_posts [$row ['id']] = $row ['id'];
    }
    $sql = $this->mysql->query ( "
  		SELECT *
  		FROM threads
  		WHERE `id` = '$this->thread_id'
  	" );
    if (! $sql) throw new mysql_exception ( "Could not load thread posts", mysql_error (), "Fatal Error" );
    $row = mysql_fetch_array ( $sql );
    $this->thread_forum = $row ['forum'];
    $this->thread_poster = $row ['poster'];
    $this->thread_subject = $row ['subject'];
    $this->thread_timestamp = $row ['timestamp'];
  }
}

?>