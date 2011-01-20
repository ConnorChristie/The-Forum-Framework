<?php

class log {
	var $message,$priority;
	function __construct($message,$priority) {
		$this->message=$message;
		$this->priority=$priority;
	}
}