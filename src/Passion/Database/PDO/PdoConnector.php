<?php declare(strict_types = 1);

namespace Passion\Database\PDO;

use Passion\Config\ApplicationConfig;
use PDO;

/**
 * PDOによるデータベース接続クラス
 */
class PdoConnector
{
    public static ?PDO $connection = null;

    public function connect(): PDO
    {
        $dbConfig = ApplicationConfig::getDatabase();

        if (is_null(self::$connection)) {
            self::$connection = new PDO($dbConfig['dns'], $dbConfig['username'], $dbConfig['password']);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラー時に例外をスローする
            self::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$connection;
    }
}
