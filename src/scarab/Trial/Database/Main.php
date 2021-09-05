<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

require('DB.php');
require('QueryBuilder.php');

class Main
{
    public function main()
    {
		echo DB::table('users')->select()->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id'])->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id', 'name'])->toSql() . PHP_EOL;
    }
}

$main = new Main();
$main->main();
