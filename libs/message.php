<?php

/**
 * Parent class for private messages, posts, emails, comments etc
 * @author Jack Scott
 * @copyright Copyright 2010
 * @version 1.0
 */
class message{
	public 	$message_title, $message_subject,
			$message_timestamp,
			$message_body;
	function __construct(){
		$this->settings = new settings();
	}
	/**
	 * @return String
	 */
	public function getMessage_title() {
		return $this->message_title;
	}

	/**
	 * @return String
	 */
	public function getMessage_subject() {
		return $this->message_subject;
	}

	/**
	 * @return String
	 */
	public function getMessage_timestamp() {
		return $this->message_timestamp;
	}

	/**
	 * @return String
	 */
	public function getMessage_body() {
		return $this->message_body;
	}

	/**
	 * @param field_type Message Title
	 */
	public function setMessage_title($message_title) {
		$this->message_title = $message_title;
	}

	/**
	 * @param field_type Message Subject
	 */
	public function setMessage_subject($message_subject) {
		$this->message_subject = $message_subject;
	}

	/**
	 * @param field_type Message Timestamp
	 */
	public function setMessage_timestamp($message_timestamp) {
		$this->message_timestamp = $message_timestamp;
	}

	/**
	 * @param field_type Message Body
	 */
	public function setMessage_body($message_body) {
		$this->message_body = $message_body;
	}


}