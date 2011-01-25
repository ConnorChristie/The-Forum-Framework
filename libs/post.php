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
require_once ('libs/message.php');

/**
 * Class for forum posts. Subclass of message.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GNU General Public License Version 3
 * @version alpha
 */

class post extends message {
  public $message_poster, $message_forum, $message_thread;
  function __construct(){
    parent::__construct ();
  }
  function post(){
    mysql_connect ( $this->settings->mysql_server, $this->settings->mysql_username, $this->settings->mysql_password );
    mysql_select_db ( $this->settings->mysql_database );
    mysql_query ( "
				INSERT INTO `posts`
				(`forum`,`thread`,`poster`,`subject`,`body`)
				VALUES
				('$this->message_forum','$this->message_thread','$this->message_poster','$this->message_subject','$this->message_body')
		" ) or die ( mysql_error () );
  }
  /**
   * @return the $message_poster
   */
  public function getMessage_poster(){
    return $this->message_poster;
  }

  /**
   * @param field_type $message_poster
   */
  public function setMessage_poster($message_poster){
    $this->message_poster = $message_poster;
  }

  /**
   * @return the $message_forum
   */
  public function getMessage_forum(){
    return $this->message_forum;
  }

  /**
   * @return the $message_thread
   */
  public function getMessage_thread(){
    return $this->message_thread;
  }

  /**
   * @param field_type $message_forum
   */
  public function setMessage_forum($message_forum){
    $this->message_forum = $message_forum;
  }

  /**
   * @param field_type $message_thread
   */
  public function setMessage_thread($message_thread){
    $this->message_thread = $message_thread;
  }

}