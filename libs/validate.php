<?php

class validate {
  function validateUsername($username){
		if (isset($username) && !preg_match("/^[^a-z]{1}|[^a-z0-9_.-]+/i", $username) ){
			return true;
		}
		else return false;
  }
  function validateUser_password($user_password){

  }
}

?>