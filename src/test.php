<?php

declare(strict_types=1);

use Scarab\Database\DB;
use Scarab\Database\QueryBuilder;
use Scarab\Database\PDO\PdoConnector;
use Scarab\Database\Expression\WhereExpression;

require 'vendor/autoload.php';

$config = require 'app/Libs/Core/config.php';
$config();

function test_select_clause()
{
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
}

function test_db_connection()
{
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
}

function test_where_expression()
{
    $whereExpression = new WhereExpression('column1', '=', 'and');
    $expression = $whereExpression->getExpression();
    var_dump($expression);

    assert($expression === 'and column1 = ?');

    // InvalidArgumentException
    // new WhereExpression('column1', '?', 1);
}

function test_where_clause()
{
    // 条件1つ + 実際の接続
    $query = DB::table('test_table');
    $query->where('column1', '=', 1);
    echo $query->toSql() . PHP_EOL;

    $expected = "select * from test_table where column1 = ?;";
    assert($query->toSql() === $expected);
    assert($query->getBindings() === [1]);

    $result = $query->get();
    print_r($result);

    // 条件2つ(or)
    $query = DB::table('test_table');
    $query->where('column1', '>=', 1);
    $query->where('column2', '<=', 3, 'and');
    echo $query->toSql() . PHP_EOL;
    $expected = "select * from test_table where column1 >= ? and column2 <= ?;";
    assert($query->toSql() === $expected);
}

// test_select_clause();
// test_db_connection();
test_where_expression();
test_where_clause();

// $dsn = "mysql:host=mariadb;dbname=test";
// $user = "root";
// $password = "abcde123";
// $connection = new PDO($dsn, $user, $password);
// print_r($connection);
// $statement = $connection->prepare('select * from test_table where column1 = ?');
// $statement->execute(['1']);
// $statement->debugDumpParams();

// $statement = $connection->prepare('select * from test_table where column1 = :column1');
// $statement->execute(['column1' => 2]);
// $statement->debugDumpParams();

// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
// print_r($result);
