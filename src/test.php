<?php

declare(strict_types=1);

use Scarab\Database\DB;
use Scarab\Database\QueryBuilder;
use Scarab\Database\PDO\PdoConnector;
use Scarab\Database\Expression\WhereExpression;

require 'vendor/autoload.php';

$config = require 'app/Libs/Core/config.php';
$config();

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
