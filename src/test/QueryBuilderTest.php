<?php

use PHPUnit\Framework\TestCase;
use Scarab\Database\DB;
use Scarab\Database\QueryBuilder;

class QueryBuilderTest extends TestCase
{
    public function testSelect句で何も指定しなかった場合のtoSqlメソッド()
    {
        $query = DB::table('table');
        $this->assertEquals('select * from table;', $query->toSql());
    }

    public function testSelect句でカラムを1つ指定した場合()
    {
        $query = DB::table('table')->select('column');
        $this->assertEquals('select `column` from table;', $query->toSql());
    }

    public function testSelect句でカラムを2つ指定した場合()
    {
        // 引数を複数指定
        $query = DB::table('table')->select('column1', 'column2');
        $this->assertEquals('select `column1`, `column2` from table;', $query->toSql());

        // 配列で指定
        $query = DB::table('table')->select(['column1', 'column2']);
        $this->assertEquals('select `column1`, `column2` from table;', $query->toSql());
    }

    public function testSelect句でテーブル名を指定する場合()
    {
        // カラム1つ
        $query = DB::table('table')->select('table.column');
        $this->assertEquals('select `table`.`column` from table;', $query->toSql());
        // 全カラム
        $query = DB::table('table')->select('table.*');
        $this->assertEquals('select `table`.* from table;', $query->toSql());
    }

    public function testSelect句で生のSQLを書いた場合()
    {
        $query = DB::table('table')->selectRaw('max(column)');
        $this->assertEquals('select max(column) from table;', $query->toSql());
    }

    public function testWhere句の条件が1つの場合のtoSqlメソッド()
    {
        $query = DB::table('table');
        $query->where('column', '=', 1);
        $expected = 'select * from table where column = ?;';

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWhere句の条件が2つの場合のtoSqlメソッド()
    {
        $query = DB::table('table')
            ->where('name', '=', 'test')
            ->where('email', '=', 'test@example.com', 'and');
        $expected = 'select * from table where name = ? and email = ?;';

        $this->assertEquals($expected, $query->toSql());
    }
}
