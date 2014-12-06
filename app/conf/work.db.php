<?php
$main_database = array(
	'host' => '127.0.0.1',
	'port' => 3306,
	'database' => '4hi',
	'user' => 'root',
	'password' => '123123',
	'charset' => 'utf8',
);

return array(
	'session' => $main_database,
	'user' => $main_database,
	'id_maker' => $main_database
);

