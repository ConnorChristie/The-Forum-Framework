<?php

require_once ('libs/message.php');

/**
 * Class for forum posts. Subclass of message.
 * @author Jack
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