<?php

/* format for logging */
$GLOBALS['config']['class']['core']['Logger']['format'] = '[{types}] - {date}: {message} in {file} at line {line}';
/* format for date in logging */
$GLOBALS['config']['class']['core']['Logger']['date_format'] = 'Y-m-d H:i:s';
/* type of logging to log */
$GLOBALS['config']['class']['core']['Logger']['logged_types'] = '*';
/* directory where logs files are located */
$GLOBALS['config']['class']['core']['Logger']['directory'] = 'log/';

?>
