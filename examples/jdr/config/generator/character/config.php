<?php

$GLOBALS['config']['generator']['character']=array(
	'parameters' => array(
		'name' => array(
			'necessary' => True,
			'regex'     => '\\S',
		),
		'class' => array(
			'necessary' => True,
			'regex'     => '\\d+',
		),
		'race' => array(
			'necessary' => True,
			'regex'     => '\\d+',
		),
		'str' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'dex' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'con' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'int_' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'cha' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'agi' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'mag' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
		'acu' => array(
			'necessary' => False,
			'regex'     => '\\d+',
		),
	),
);

?>