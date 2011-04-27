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
 * Default exception handler for TFFW.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GPLv3
 * @version alpha
 */
class tffw_exception extends Exception {
  /**
   * A short description of how severe the error is. Eg. "Fatal Error"
   * @var String
   */
  public $weight;
  /**
   * If it's a mysql error beeing reported, send the error from the mysql_error() function here.
   * @var String
   */
  public $mysql_error;
  public function __construct($message, $weight, $mysql_error = null){
    $this->message = $message;
    $this->weight = $weight;
    $this->mysql_error = $mysql_error;
    $this->mysql = new mysql ();
    $this->settings = new settings ();

  }
  /**
   * Draws a basic error page for the end users. Only shows the message and weight.
   */
  public function drawErrorPage(){
    include( "../templates/error_page.html");
    echo "$this->file, line $this->line";
  }
  public function reportError($email = null, $db = null){
    $this->file = mysql_real_escape_string ( $this->file );
    $this->mysql->query ( "
				INSERT INTO `errors`
				(`time`,`weight`,`ip`,`message`,`file`,`line`)
				VALUES
				('$this->time','$this->weight','$this->ip','$this->message','$this->file','$this->line')
		" ) or die ( 'SOMETHING WENT VERY WRONG WHEN TRYING TO REPORT AN ERROR!!!!<br />PLEASE CONTACT SUPPORT!' );

    $email = new email ();
    $email->setMessage_subject ( "The Forum Framework Error Report" );
    $email->setMessage_to ( $this->settings->admin_email );
    $email_body = "
		An error was thrown on your TFFW site!\r\n
		To see more details, click the following link\r\n
		\r\n
		" . $_SERVER ['DOCUMENT_ROOT'] . "
		";
    $email->setMessage_body ( $email_body );
    try {
      $email->send ();
    }
    catch ( tffw_exception $e ) {
      $e->drawErrorPage ();
      $e->reportError ();
    }
  }
/**
	 * @return the $weight
	 */
	public function getWeight() {
		return $this->weight;
	}

/**
	 * @param String $weight
	 */
	public function setWeight($weight) {
		$this->weight = $weight;
	}

/**
	 * @return the $mysql_error
	 */
	public function getMysql_error() {
		return $this->mysql_error;
	}

/**
	 * @param String $mysql_error
	 */
	public function setMysql_error($mysql_error) {
		$this->mysql_error = $mysql_error;
	}

}