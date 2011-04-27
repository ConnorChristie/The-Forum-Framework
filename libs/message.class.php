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
 * Parent class for private messages, posts, emails, comments etc
 * @author Jack Scott
 * @copyright Copyright 2010
 * @version 1.0
 */
class message {
	/**
	 * Title of the message
	 * @var String
	 */
	public $title;
	/**
	 * Subject of the message
	 * @var String
	 */
	public $subject;
	/**
	 * Timestamp of the message
	 * @var unknown_type
	 */
	public $timestamp;
	/**
	 * The messages actual text
	 * @var unknown_type
	 */
	public $body;

	function __construct() {
		$this->settings = new settings ();
		$this->mysql = new mysql();
	}
	/**
	 * @return the $title
	 */
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
	 * @return the $timestamp
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}

	/**
	 * @param field_type $timestamp
	 */
	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
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


}