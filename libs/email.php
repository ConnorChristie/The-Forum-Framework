<?php
class email extends message{
	public 	$message_to,
			$message_from,
			$message_headers,
			$settings;

	function __construct(){
		parent::__construct();
	}
	public function send(){
		mail($this->message_to, $this->message_subject, $this->message_body);
		if(empty($this->settings->smtp_server)) throw new email_exception('smtp_server not set. Please set it in config.ini','Config Error');
		if(empty($this->settings->ssl)) throw new email_exception('smtp_ssl not set. Please set it in config.ini','Config Error');
		if($this->settings->smtp_ssl){
			$server = "ssl://".$this->settings->smtp_server;
		}
		else $server = $this->settings->smtp_server;
		$port = $this->settings->smtp_port;
		$timeout = $this->settings->smtp_timeout;
		$username = $this->settings->smtp_username;
		$password = $this->settings->smtp_password;
		$localhost = "127.0.0.1";
		if(empty($port)) throw new email_exception('smtp_port not set. Please set it in config.ini','Config Error');
		if(empty($timeout)) throw new email_exception('smtp_timeout not set. Please set it in config.ini','Config Error');
		if(empty($username)) throw new email_exception('smtp_username not set. Please set it in config.ini','Config Error');
		if(empty($password)) throw new email_exception('smtp_password not set. Please set it in config.ini','Config Error');

		$newLine = "\r\n";
		$secure = 0;
		//connect to the host and port
		$connect = fsockopen($server, $port, $errno, $errstr, $timeout);
		if(!$connect) throw new email_exception("Could not connect to SMTP server ".$server.":".$port, $errstr, 'Warning');
		$response = fgets($connect, 4096);
		if(!$response)throw new email_exception("Could not connect to SMTP server ".$server.":".$port, $errstr, 'Warning');
		if(empty($connect)) {
		   throw new email_exception("Could not connect to SMTP server ".$server.":".$port, $errstr, 'Warning');
		}
		fputs($connect, "HELO $localhost". $newLine);
		$response = fgets($connect, 4096);
		$log['heloresponse2'] = "$response";
		fputs($connect,"AUTH LOGIN" . $newLine);
		$response = fgets($connect, 4096);
		$logArray['authrequest'] = "$response";
		fputs($connect, base64_encode($username) . $newLine);
		$response = fgets($connect, 4096);
		$logArray['authusername'] = "$response";
		fputs($connect, base64_encode($password) . $newLine);
		$response = fgets($connect, 4096);
		$logArray['authpassword'] = "$response";
		fputs($connect, "MAIL FROM: <$this->message_from>" . $newLine);
		$response = fgets($connect, 4096);
		$logArray['mailfromresponse'] = "$response";
		fputs($connect, "RCPT TO: <$this->message_to>" . $newLine);
		$response = fgets($connect, 4096);
		$logArray['mailtoresponse'] = "$response";
		fputs($connect, "DATA" . $newLine);
		$response = fgets($connect, 4096);
		$log['data1response'] = "$response";
		$headers = "MIME-Version: 1.0" . $newLine;
		$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
		$headers .= "To: $this->message_to" . $newLine;
		$headers .= "From: $this->message_from" . $newLine;

		fputs($connect, "To: $this->message_to\r\nFrom: $this->message_from\r\nSubject: $this->message_subject\r\n$headers\r\n\r\n$this->message_body\r\n.\r\n");
		$response = fgets($connect, 4096);
		$log['data2response'] = "$response";

		fputs($connect,"QUIT" . $newLine);
		$response = fgets($connect, 4096);
		$log['quitresponse'] = "$response";
		$log['quitcode'] = substr($response,0,3);
		fclose($connect);
		//a return value of 221 in $retVal["quitcode"] is a success
		if($log['quitcode']==221) return true;
		else return false;

	}
	/**
	 * @return the $message_to
	 */
	public function getMessage_to() {
		return $this->message_to;
	}

	/**
	 * @return the $message_headers
	 */
	public function getMessage_headers() {
		return $this->message_headers;
	}

	/**
	 * @param field_type $message_headers
	 */
	public function setMessage_header($header,$value) {
		$this->message_headers .= "\r\n".$header.":".$value;
	}


	/**
	 * @return the $message_from
	 */
	public function getMessage_from() {
		return $this->message_from;
	}

	/**
	 * @param field_type $message_to
	 */
	public function setMessage_to($message_to) {
		$this->message_to = $message_to;
	}

	/**
	 * @param field_type $message_from
	 */
	public function setMessage_from($message_from) {
		$this->message_from = $message_from;
		$this->message_headers .= "from:".$message_from;
	}



}