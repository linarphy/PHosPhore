<?php

$GLOBALS['config']['generator']['chest']=array(
	'nbr_item_weigth'         => array(2 => 50, 3 => 100, 4 => 75, 5 => 50, 6 => 25),
	'quality_modifier_weigth' => array(-2 => 2, -1 => 15, 0 => 100, 1 => 15, 2 => 2),
	'config'                  => array(
		'content_type' => 'XML',
		'notification' => False,
	),
	'parameters'              => array(
		'quality' => array(
			'necessary' => True,
			'regex'     => '\\d+',
		),
	),
);

?>