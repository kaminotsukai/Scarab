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

	/**
	 * クエリを実行する
	 * SQLインジェクション対策はなし
	 *
	 * @param string $query
	 * @return array
	 */
	public function exec(string $query): array
	{
		$statement = $this->pdo->query($query);
		return $statement->fetchAll();
	}

	public function table(string $table): QueryBuilder
	{
		return new QueryBuilder($this, $table);
	}
}




