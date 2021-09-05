<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

require('DB.php');
require('QueryBuilder.php');

class Main
{
    public function main()
    {
		// SELECT
		echo DB::table('users')->select()->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id'])->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id', 'name'])->toSql() . PHP_EOL;

		// WHERE
		echo DB::table('users')->select(['id'])->where('name', 'makoto')->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id'])->where('name', '=', 'makoto')->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id'])->where('name', '=', 'makoto')->where('age', 21)->toSql() . PHP_EOL;

		// ORDER BY
		echo DB::table('users')->select(['id'])->orderBy('age', 'desc')->toSql() . PHP_EOL;
		echo DB::table('users')->select(['id'])->orderBy('age')->toSql() . PHP_EOL;
		try { echo DB::table('users')->select(['id'])->orderBy('age', '=')->toSql() . PHP_EOL; }
		catch (\Exception $e) { echo "ERROR: {$e->getMessage()}"; }
    }
}

$main = new Main();
$main->main();
