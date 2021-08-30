<?php

use Scarab\Database\DB;
use Scarab\Database\QueryBuilder;

require 'vendor/autoload.php';

$config = require 'app/Libs/Core/config.php';
$config();

# case 1
$query = new QueryBuilder('hoge');
echo $query->toSql() . PHP_EOL;

$expected = "select * from hoge;";
assert($query->toSql() === $expected);

# case 2
$query->select('hoge');
echo $query->toSql() . PHP_EOL;

$expected = "select `hoge` from hoge;";
assert($query->toSql() === $expected);

# case 3
$query->select(['column1', 'column2']);
echo $query->toSql() . PHP_EOL;

$expected = "select `column1`, `column2` from hoge;";
assert($query->toSql() === $expected);

# case 4
$query->selectRaw('max(column1)');
echo $query->toSql() . PHP_EOL;

$expected = "select max(column1) from hoge;";
assert($query->toSql() === $expected);

# case 5
$query = $query->select('table.*');
echo $query->toSql() . PHP_EOL;

$expected = "select `table`.* from hoge;";
assert($query->toSql() === $expected);

# DB
$query = DB::table('table_name');
echo $query->toSql() . PHP_EOL;
$expected = "select * from table_name;";
assert($query->toSql() === $expected);

$query = DB::table('table_name');
print_r($query->get());

$expected = [['column1' => 1], ['column2' => 2]];
$isSame = $query->get() === $expected;
// assert($isSame);
