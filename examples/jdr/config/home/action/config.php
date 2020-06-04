<?php

$GLOBALS['config']['home']['action']=array(
	'parameters' => array(
		'name' => array(
			'necessary' => True,
			'regex'     => '\\S',
		),
		'id'   => array(
			'necessary' => True,
			'regex'     => '\\d+',
		),
	),
);

?>