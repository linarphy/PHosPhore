<?php

global $Router;

$GLOBALS['lang']['user']['login']=array(
	'title'    => 'Login',
	'legend'   => 'Log in',
	'nickname' => 'Nickname',
	'password' => 'Password',
	'submit'   => 'LOG IN',
	'register' => 'Not registered? <a href="'.$Router->createLink(array('application' => 'user', 'action' => 'register')).'" title="registration">Click here to register</a>',
);

?>