<?php
namespace App\Api\Dao;
use Lavender\Dao\Exception;

class UserTable extends \Lavender\Dao\Table
{
	protected $database = 'user';
	protected $table = 'user';
}
