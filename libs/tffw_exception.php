<?php

class tffw_exception extends Exception {

  public function __construct($message,$weight){
    $this->message = $message;
    $this->weight = $weight;

  }
  public function drawErrorPage(){
    echo '
			<html>
			  <head><title>' . $this->weight . '</title></head>
			  <body>
			    <h1>' . $this->weight . '</h1>
			    <p>' . $this->message . '</p>
				<p>This error has been reported. If you continue to recieve this error please contact support</p>'.
				$mysql_error
			;
  }
}