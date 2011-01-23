<?php

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
    $this->mysql = new mysql ();
    $this->settings = new settings ();

  }
  /**
   * Draws a basic error page for the end users. Only shows the message and weight.
   */
  public function drawErrorPage(){
    include( ROOT . DS . "templates/error_page.html");
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
}