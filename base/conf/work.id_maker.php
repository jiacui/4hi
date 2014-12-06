<?php
$default_id_maker = array(
	'maker' => '\App\Api\Dao\IdMakerTable',
	'name' => 'default',
	'start' => '1000000',
);

return array(
	'account' => $default_id_maker,
	'user' => array(
		'maker' => '\Base\Dao\IdMakerTable',
		'name' => 'user',
		'start' => '1000000',
	),
	'order' => array(
		'maker' => '\Base\Dao\IdMakerTable',
		'name' => 'user',
		'start' => '1000000',
	)
);
