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
 * This class is used for creating, and sending emails.
 * @author Jack Scott <jack@ttocskcaj.com>
 * @copyright Copyright 2011 Jack Scott
 * @license GPLv3
 * @version alpha
 */
class email extends message {
	/**
	 * The email address of the recipient.
	 * @var String
	 */
	public $to;
	/**
	 * Your email, or the email you want to send from
	 * @var String
	 */
	public $from;

	/**
	 * Uses parents constructor (message)
	 */
	function __construct() {
		parent::__construct ();
	}

	/**
	 * Checks everything is ok, then sends the email.
	 * @throws tffw_exception
	 */
	public function send() {
		mail ( $this->to, $this->message_subject, $this->message_body );
		if (empty ( $this->settings->smtp_server ))
			throw new tffw_exception ( 'smtp_server not set. Please set it in config.ini', 'Config Error' );
		if (empty ( $this->settings->ssl ))
			throw new tffw_exception ( 'smtp_ssl not set. Please set it in config.ini', 'Config Error' );
		if ($this->settings->smtp_ssl) {
			$server = "ssl://" . $this->settings->smtp_server;
		} else
			$server = $this->settings->smtp_server;
		$port = $this->settings->smtp_port;
		$timeout = $this->settings->smtp_timeout;
		$username = $this->settings->smtp_username;
		$password = $this->settings->smtp_password;
		$localhost = "127.0.0.1";
		if (empty ( $port ))
			throw new tffw_exception ( 'smtp_port not set. Please set it in config.ini', 'Config Error' );
		if (empty ( $timeout ))
			throw new tffw_exception ( 'smtp_timeout not set. Please set it in config.ini', 'Config Error' );
		if (empty ( $username ))
			throw new tffw_exception ( 'smtp_username not set. Please set it in config.ini', 'Config Error' );
		if (empty ( $password ))
			throw new tffw_exception ( 'smtp_password not set. Please set it in config.ini', 'Config Error' );

		$newLine = "\r\n";
		$secure = 0;
		//connect to the host and port
		$connect = fsockopen ( $server, $port, $errno, $errstr, $timeout );
		if (! $connect)
			throw new tffw_exception ( "Could not connect to SMTP server " . $server . ":" . $port, $errstr, 'Warning' );
		$response = fgets ( $connect, 4096 );
		if (! $response)
			throw new tffw_exception ( "Could not connect to SMTP server " . $server . ":" . $port, $errstr, 'Warning' );
		if (empty ( $connect )) {
			throw new tffw_exception ( "Could not connect to SMTP server " . $server . ":" . $port, $errstr, 'Warning' );
		}
		fputs ( $connect, "HELO $localhost" . $newLine );
		$response = fgets ( $connect, 4096 );
		$log ['heloresponse2'] = "$response";
		fputs ( $connect, "AUTH LOGIN" . $newLine );
		$response = fgets ( $connect, 4096 );
		$logArray ['authrequest'] = "$response";
		fputs ( $connect, base64_encode ( $username ) . $newLine );
		$response = fgets ( $connect, 4096 );
		$logArray ['authusername'] = "$response";
		fputs ( $connect, base64_encode ( $password ) . $newLine );
		$response = fgets ( $connect, 4096 );
		$logArray ['authpassword'] = "$response";
		fputs ( $connect, "MAIL FROM: <$this->from>" . $newLine );
		$response = fgets ( $connect, 4096 );
		$logArray ['mailfromresponse'] = "$response";
		fputs ( $connect, "RCPT TO: <$this->to>" . $newLine );
		$response = fgets ( $connect, 4096 );
		$logArray ['mailtoresponse'] = "$response";
		fputs ( $connect, "DATA" . $newLine );
		$response = fgets ( $connect, 4096 );
		$log ['data1response'] = "$response";
		$headers = "MIME-Version: 1.0" . $newLine;
		$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
		$headers .= "To: $this->to" . $newLine;
		$headers .= "From: $this->from" . $newLine;

		fputs ( $connect, "To: $this->to\r\nFrom: $this->from\r\nSubject: $this->message_subject\r\n$headers\r\n\r\n$this->message_body\r\n.\r\n" );
		$response = fgets ( $connect, 4096 );
		$log ['data2response'] = "$response";

		fputs ( $connect, "QUIT" . $newLine );
		$response = fgets ( $connect, 4096 );
		$log ['quitresponse'] = "$response";
		$log ['quitcode'] = substr ( $response, 0, 3 );
		fclose ( $connect );
		//a return value of 221 in $retVal["quitcode"] is a success
		if ($log ['quitcode'] == 221)
			return true;
		else
			return false;

	}
	/**
	 * @return the $to
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @param String $to
	 */
	public function setTo($to) {
		$this->to = $to;
	}

	/**
	 * @return the $from
	 */
	public function getFrom() {
		return $this->from;
	}

	/**
	 * @param String $from
	 */
	public function setFrom($from) {
		$this->from = $from;
	}


}