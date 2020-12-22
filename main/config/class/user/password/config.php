<?php

/* Algorithm to use to hash user password (see https://php.net/manual/password.constants.php) */
$GLOBALS['config']['class']['user']['password']['algorithm']=PASSWORD_DEFAULT;

/* [OPTIONS] */
/* Option for password_hash */
/* Define the hash cost for password */
$GLOBALS['config']['class']['user']['password']['options']['cost']=6;


?>
