<?php declare(strict_types = 1);

namespace Passion\Database\PDO;

use PDO;

/**
 * リレーショナルデータベース用のクエリを組み立てる汎用的なリポジトリクラス（PHPでクエリを扱いやすくする）
 */
abstract class AbstractSqlRepository
{
    /**
     * データベース接続インスタンス
     */
    protected PDO $connection;

    /**
     * 操作対象のテーブル名
     */
    protected string $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->connection = (new PdoConnector())->connect();
    }

    /**
     * トランザクションを開始する
     */
    public function beginTransaction(): void
    {
        // TODO: Laravelでは条件分岐してないけど大丈夫？
        if (!$this->connection->inTransaction()) {
            $this->connection->beginTransaction();
        }
    }

    /**
     * トランザクションをコミットする
     */
    public function commit(): void
    {
        if ($this->connection->inTransaction()) {
            $this->connection->commit();
        }
    }

    /**
     * 直近にinsertしたIDカラム値(またはシーケンス値)を取得する
     */
    abstract public function lastInsertId(): int;

    /**
     * レコードを挿入する
     */
    public function create(array $data): int
    {
        return $this->createRecord($this->tableName, $data);
    }

    /**
     * レコードを生成(INSERT)する
     * @param string $table テーブル名
     * @param array $datas カラムと値からなる連想配列
     */
    protected function createRecord(string $table, array $data): int
    {
        // Construct SQL
        $keys = array_keys($data);

        $sql = "INSERT INTO {$table} (";
        $sql .= implode(', ', $keys);
        $sql .= ") VALUES (";
        $sql .= implode(', ', array_map(fn ($key) => ":$key", $keys));
        $sql .= ")";

        // Prepare Exec
        $statement = $this->connection->prepare($sql);

        // Bind Value
        foreach ($data as $key => $value) {
            $statement->bindValue(":{$key}", $value, $this->getPdoParamType($value));
        }

        $statement->execute();
        return $this->lastInsertId();
    }

    /**
     * レコードを更新する
     */
    public function update(int $id, array $data): void
    {
        $this->updateRecord($this->tableName, $id, $data);
    }

    /**
     * レコードを更新(UPDATE)する
     */
    protected function updateRecord(string $table, int $id, array $data): void
    {
        $keys = array_keys($data);
        $sql = "UPDATE {$table} SET ";
        $sql .= implode(', ', array_map(fn ($key) => "{$key} = :{$key}", $keys));
        $sql .= "WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->bindValue(':id', $id);
        foreach ($data as $key => $value) {
            $statement->bindValue(":{$key}", $value);
        }
        $statement->execute();
    }

    private function getPdoParamType($value): ?int
    {
        if (is_int($value)) return PDO::PARAM_INT;
        if (is_string($value)) return PDO::PARAM_STR;
        if (is_null($value)) return PDO::PARAM_NULL;
        return null;
    }
}
