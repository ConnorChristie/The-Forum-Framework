<?php

class tffw_error extends Exception{
  /**
   * The error code.
   * @var Integer
   */
  public $code;
  /**
   * The error message.
   * @var String
   */
  public $message;
  /**
 * @return the $code
 */


function __construct($code,$message){
  	$this->code = $code;
  	$this->message = $message;
  }

}