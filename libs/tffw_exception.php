<?php

class tffw_exception extends Exception {

  public function __construct($message, $weight){
    $this->message = $message;
    $this->weight = $weight;
    $this->mysql = new mysql ();
    $this->settings = new settings ();

  }
  public function drawErrorPage(){
    echo '
			<html>
			  <head><title>' . $this->weight . '</title></head>
			  <body>
			    <h1>' . $this->weight . '</h1>
			    <p>' . $this->message . '</p>
				<p>This error has been reported. If you continue to recieve this error please contact support</p>' . $mysql_error;
  }
  public function reportError($email = null, $db = null){
    $this->file = mysql_real_escape_string ( $this->file );
    if ($db) {
      $this->mysql->query ( "
				INSERT INTO `errors`
				(`time`,`weight`,`ip`,`message`,`file`,`line`)
				VALUES
				('$this->time','$this->weight','$this->ip','$this->message','$this->file','$this->line')
		" ) or die ( 'SOMETHING WENT VERY WRONG WHEN TRYING TO REPORT AN ERROR!!!!<br />PLEASE CONTACT SUPPORT!' );
    }
    if ($email) {
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
      catch ( email_exception $e ) {
        $e->drawErrorPage ();
        $e->reportError ();
      }
    }
  }
}