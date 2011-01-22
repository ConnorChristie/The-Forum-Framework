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

}