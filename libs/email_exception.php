<?php
class email_exception extends tffw_exception {
  public function __construct($message, $weight, $code = null){
    $this->message = $message;
    $this->code = $code;
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
  }
}