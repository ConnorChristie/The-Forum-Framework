<?php
$user = new user();
$user->setUsername($_GET['username']);
$user->setUser_password($_GET['user_password']);
$user->setUser_email($_GET['user_email']);
try {
	$user->register();
}
catch (mysql_exception $e) {
	$e->drawErrorPage();
}
catch (email_exception $e) {
	$e->drawErrorPage();
}