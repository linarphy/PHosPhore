<?php

/* number of bytes used to generate a random selector */
$GLOBALS['config']['class']['user']['Token']['bytes_selector'] = 16;
/* number of bytes used to generate a random validator */
$GLOBALS['config']['class']['user']['Token']['bytes_validator'] = 16;
/* algorithm used to hash validator */
$GLOBALS['config']['class']['user']['Token']['algorithm'] = PASSWORD_DEFAULT;
/* options used to hash validator */
$GLOBALS['config']['class']['user']['Token']['options'] = [];
/* time interval (https://www.php.net/manual/fr/dateinterval.construct.php) before the expiration of the token */
$GLOBALS['config']['class']['user']['Token']['period_before_expiration'] = 'PT10M';

?>
