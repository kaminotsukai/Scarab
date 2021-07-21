<?php declare(strict_types = 1);

namespace Scarab\Database;

use Scarab\Database\PDO\AbstractSqlRepository;

/**
 * MySQL専用の汎用的なリポジトリクラス
 */
abstract class BaseMySqlRepository extends AbstractSqlRepository
{
    public function __construct(string $tableName)
    {
        parent::__construct($tableName);
    }

    public function lastInsertId(): int
    {
        return (int)$this->connection->lastInsertId();
    }
}
