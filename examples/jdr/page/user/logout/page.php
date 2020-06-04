<?php

unset($_SESSION);
session_destroy();
header('location: '.$Router->createLink(array()));
exit();

?>