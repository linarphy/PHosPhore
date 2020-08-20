<?php

/* Action used by this page */
$GLOBALS['config']['mod']['login']['register']['action']='register';
/* If the optionnal parameters can be used */
$GLOBALS['config']['mod']['login']['register']['strict']=false;
/* [DEFAULT] */
/* Default email at registration */
$GLOBALS['config']['mod']['login']['register']['default']['email']='';
/* Default avatar at registration */
$GLOBALS['config']['mod']['login']['register']['default']['avatar']='default.png';
/* Default status at registration */
$GLOBALS['config']['mod']['login']['register']['default']['banned']=false;
/* [PARAMETERS] */
/* [NICKNAME] */
/* If the parameter has to be filled */
$GLOBALS['config']['mod']['login']['register']['parameters']['nickname']['necessary']=true;
/* The pattern the value of this paramater must match with */
$GLOBALS['config']['mod']['login']['register']['parameters']['nickname']['pattern']='^\S+$';
/* Type of the input */
$GLOBALS['config']['mod']['login']['register']['parameters']['nickname']['type']='text';
/* [PASSWORD] */
/* If the parameter has to be filled */
$GLOBALS['config']['mod']['login']['register']['parameters']['password']['necessary']=true;
/* The pattern the value of this paramater must match with */
$GLOBALS['config']['mod']['login']['register']['parameters']['password']['pattern']='^\S+$';
/* Type of the input */
$GLOBALS['config']['mod']['login']['register']['parameters']['password']['type']='password';
/* [EMAIL] */
/* If the parameter has to be filled */
$GLOBALS['config']['mod']['login']['register']['parameters']['email']['necessary']=false;
/* The pattern the value of this paramater must match with */
$GLOBALS['config']['mod']['login']['register']['parameters']['email']['pattern']='^\S+@\S+\.\S+$';
/* Type of the input */
$GLOBALS['config']['mod']['login']['register']['parameters']['email']['type']='email';
/* [AVATAR] */
/* If the parameter has to be filled */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['necessary']=false;
/* Type of the input */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['type']='file';
/* Max size for an avatar (in o) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['max_size']=1000000;
/* Min size for an avatar (in o) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['min_size']=0;
/* Max height for an avatar (in px) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['height_max']=1000;
/* Min height for an avatar (in px) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['height_min']=1;
/* Max width for an avatar (in px) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['width_max']=1000;
/* Min width for an avatar (in px) */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['width_min']=1;
/* Available extensions for an avatar */
$GLOBALS['config']['mod']['login']['register']['parameters']['avatar']['extensions']=array('png', 'gif', 'png', 'jpeg');

?>
