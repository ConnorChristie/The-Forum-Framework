<?php
class time extends DateTime {
  function __construct(){
    parent::__construct ();
  }
  function getLogTime(){
    return date ( 'd-m-Y H:i:s' );

  }
}