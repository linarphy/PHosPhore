<?php

global $Router;

$GLOBALS['lang']['user']['register']=array(
	'title'           => 'Register',
	'legend'          => 'Registration',
	'nickname'        => 'Nickname',
	'small_nickname'  => 'needed',
	'password'        => 'Password',
	'small_password'  => 'needed',
	'password2'       => 'Verification of the password',
	'small_password2' => 'needed',
	'email'           => 'Email',
	'small_email'     => 'NOT NEEDED',
	'submit'          => 'REGISTER',
	'login'           => 'Already registered? <a href="'.$Router->createLink(array('application' => 'user', 'action' => 'login')).'" title="login">Click here to login</a>',
);

?>