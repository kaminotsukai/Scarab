<?php

declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use Scarab\Trial\Database\DB;

class QueryBuilderTest extends TestCase
{
    private DB $db;

    protected function setUp(): void
    {
        $pdo = new PDO("mysql:host=mariadb; dbname=test;", 'root', 'abcde123');
        $this->db = new DB($pdo);
    }

    public function testSELECT句でカラムを指定しなかった場合(): void
    {
        $query = $this->db->table('users')->select();
        $expected = "SELECT * FROM users";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testSELECT句でカラムを1つ指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id']);
        $expected = "SELECT id FROM users";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testSELECT句でカラムを2つ指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id', 'name']);
        $expected = "SELECT id, name FROM users";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句で条件を1つ指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->where('name', '=', 'makoto');
        $expected = "SELECT id FROM users WHERE name = makoto";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句でイコールを省略した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->where('name', 'makoto');
        $expected = "SELECT id FROM users WHERE name = makoto";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句で条件を2つ指定した場合(): void
    {
        $query = $this->db->table('users')
            ->select(['id'])
            ->where('name', '=', 'makoto')
            ->where('age', '=', 21);
        $expected = "SELECT id FROM users WHERE name = makoto AND age = 21";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testORDER_BY句を指定した場合()
    {
        $query = $this->db->table('users')->select(['id'])->orderBy('name');
        $expected = "SELECT id FROM users ORDER BY name ASC";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testORDER_BY句で降順指定した場合()
    {
        $query = $this->db->table('users')->select(['id'])->orderBy('name', 'desc');
        $expected = "SELECT id FROM users ORDER BY name DESC";

        $this->assertEquals($expected, $query->toSql());
    }
}
