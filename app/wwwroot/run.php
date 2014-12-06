<?php
error_reporting(E_ALL);
//ini_set("memory_limit","100M");

define('L_DEBUG', true);
define('L_ENV', 'develop'); //develop|test|work
define('L_APP_PATH', dirname(__DIR__) . '/');
define('L_WORKSPACE_PATH', dirname(L_APP_PATH) . '/');

//load & init lavender
require L_WORKSPACE_PATH . 'lavender/Core.php';

$user = array("username"=>"hjc", "password"=>"123");

//\App\Api\User::addUser($user);


var_dump(\App\Api\Passport::is_username_exit("hjc1"));
var_dump(\App\Api\Passport::is_username_exit("hjc"));
