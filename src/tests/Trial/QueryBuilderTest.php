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

    // SELECT句
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

    // WHERE句
    public function testWHERE句で条件を1つ指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->where('name', '=', 'makoto');
        $expected = "SELECT id FROM users WHERE name = ?";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句でイコールを省略した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->where('name', 'makoto');
        $expected = "SELECT id FROM users WHERE name = ?";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句で条件を2つ指定した場合(): void
    {
        $query = $this->db->table('users')
            ->select(['id'])
            ->where('name', '=', 'makoto')
            ->where('age', '=', 21);
        $expected = "SELECT id FROM users WHERE name = ? AND age = ?";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testWHERE句で絞った条件に合うレコードを取得できること(): void
    {
        $users = [
            ['name' => 'test', 'email' => 'test@example.com'],
            ['name' => 'test2', 'email' => 'test2@example.com']
        ];
        $this->prepareUsersTable($users);

        $query = $this->db->table('users')->where('name', 'test')->select(['name', 'email']);

        $row = $query->get()[0];
        $expected = ['name' => 'test', 'email' => 'test@example.com'];

        $this->assertEquals($expected, $row);
    }

    // ORDER BY句
    public function testORDER_BY句を指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->orderBy('name');
        $expected = "SELECT id FROM users ORDER BY name ASC";

        $this->assertEquals($expected, $query->toSql());
    }

    public function testORDER_BY句で降順指定した場合(): void
    {
        $query = $this->db->table('users')->select(['id'])->orderBy('name', 'desc');
        $expected = "SELECT id FROM users ORDER BY name DESC";

        $this->assertEquals($expected, $query->toSql());
    }

    // INSERT文
    public function testInsertメソッドでレコードを追加できること(): void
    {
        $users = [
            ['name' => 'test', 'email' => 'test@example.com']
        ];
        $this->prepareUsersTable($users);

        $row = $this->db->exec('select count(*) as user_count from users;')[0];
        $count = $row['user_count'];

        $this->assertEquals(1, $count);
    }

    private function prepareUsersTable(array $users = []): void
    {
        $this->db->exec("drop table if exists users;");

        $createStatement = <<< EOS
        create table users (
            id int not null primary key auto_increment,
            name varchar(255) not null,
            email varchar(255) not null unique key
        );
        EOS;
        $this->db->exec($createStatement);

        $query = $this->db->table('users');
        foreach ($users as $user) {
            $query->insert($user);
        }
    }
}
