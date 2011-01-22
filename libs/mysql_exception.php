<?php
class mysql_exception extends tffw_exception {
  public $title, $weight, $mysql_error;
  public function __construct($message, $mysql_error, $weight, $code = null){
    $this->message = $message;
    $this->code = $code;
    $this->mysql_error = $mysql_error;
    $this->weight = $weight;
    $this->settings = new settings ();
  }
  public function reportError(){
    $this->file = mysql_real_escape_string ( $this->file );
    mysql_connect ( $this->settings->mysql_server, $this->settings->mysql_username, $this->settings->mysql_password );
    mysql_select_db ( $this->settings->mysql_database );
    mysql_query ( "
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
    catch ( email_exception $e ) {
      $e->drawErrorPage ();
      $e->reportError ();
    }
  }
}