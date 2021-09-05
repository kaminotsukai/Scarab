<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

use PDO;

/**
 * DBとの接続を行う
 */
class DB
{
	private PDO $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
	}

	public function beginTransaction(): void
	{
		$this->pdo->beginTransaction();
	}

	public function commit(): void
	{
		$this->pdo->commit();
	}

	public function rollback(): void
	{
		$this->pdo->rollBack();
	}

	public function exec(string $query): void
	{
		$this->pdo->exec($query);
	}

	public static function table(string $table): QueryBuilder
	{
		return new QueryBuilder($table);
	}
}




