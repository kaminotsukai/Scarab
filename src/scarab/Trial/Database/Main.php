<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

use PDO;

require('DB.php');
require('QueryBuilder.php');

class Main
{
    public function main()
    {
		$pdo = new PDO("mysql:host=127.0.0.1; dbname=security;", 'root', 'password');
		$db = new DB($pdo);

		// SELECT
		echo $db->table('users')->select()->toSql() . PHP_EOL;
		echo $db->table('users')->select(['id'])->toSql() . PHP_EOL;
		echo $db->table('users')->select(['id', 'name'])->toSql() . PHP_EOL;

		// WHERE
		echo $db->table('users')->select(['id'])->where('name', 'makoto')->toSql() . PHP_EOL;
		echo $db->table('users')->select(['id'])->where('name', '=', 'makoto')->toSql() . PHP_EOL;
		echo $db->table('users')->select(['id'])->where('name', '=', 'makoto')->where('age', 21)->toSql() . PHP_EOL;

		// ORDER BY
		echo $db->table('users')->select(['id'])->orderBy('name', 'desc')->toSql() . PHP_EOL;
		echo $db->table('users')->select(['id'])->orderBy('name')->toSql() . PHP_EOL;
		try { echo $db->table('users')->select(['id'])->orderBy('name', '=')->toSql() . PHP_EOL; }
		catch (\Exception $e) { echo "ERROR: {$e->getMessage()}"; }

		// GET
		print_r($db->table('users')->select()->orderBy('name')->get());
		print_r($db->table('users')->select(['id'])->orderBy('name')->get());
    }
}

$main = new Main();
$main->main();
