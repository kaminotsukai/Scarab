<?php

declare(strict_types=1);

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

	/**
	 * クエリを実行する
	 * SQLインジェクション対策あり
	 */
	public function query(string $query, array $bindings = []): array
	{
		$statement = $this->pdo->prepare($query);
		$statement->execute($bindings);

		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function insert(string $query, array $bindings = []): bool
	{
		$statement = $this->pdo->prepare($query);

		foreach ($bindings as $key => $value) {
			$statement->bindValue($key + 1, $value, $this->getPdoParamType($value));
		}

		return $statement->execute();
	}

	public function table(string $table): QueryBuilder
	{
		return new QueryBuilder($this, $table);
	}

	/**
	 * 値の型を取得する
	 *
	 * @param mixed $value
	 * @return integer|null
	 */
	public function getPdoParamType($value): ?int
	{
		if (is_int($value)) return PDO::PARAM_INT;
		if (is_string($value)) return PDO::PARAM_STR;
		if (is_null($value)) return PDO::PARAM_NULL;
		return null;
	}
}
