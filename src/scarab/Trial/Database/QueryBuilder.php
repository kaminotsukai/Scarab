<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

use InvalidArgumentException;

/**
 * SQLを構築する
 */
class QueryBuilder
{
    private DB $connection;

    private string $table;

    private string $query;

    public function __construct(
        DB $connection,
        string $table
    ) {
        $this->connection = $connection;
        $this->table = $table;
    }

    /**
     * INSERT
     * TODO: bulk insert対応する
     *
     * @param array $data
     * @return bool
     */
    public function insert(array $data): bool
    {
        $columns = implode(', ', array_keys($data));
        $placeholder = implode(', ', array_fill(0, count($data), '?'));

        $this->query = "INSERT INTO {$this->table} (${columns}) VALUES (${placeholder})";

        return $this->connection->insert($this->query, array_values($data));
    }

    /**
     * SELECTするカラムをセットする
     *
     * @param array $columns
     * @return $this
     */
    public function select(array $columns = ['*']): self
    {
        $columns = implode(', ', $columns);
        $this->query = "SELECT ${columns} FROM {$this->table}";

        return $this;
    }

    /**
     * WHERE条件を追加する
     *
     * @param string $column
     * @param mixed|null $operator
     * @param mixed|null $value
     * @return $this
     */
    public function where(string $column, $operator = null, $value = null): self
    {
        // TODO: SQLインジェクション対策
        [$operator, $value] = $this->prepareValueAndOperator($operator, $value, func_num_args() === 2);

        if (str_contains($this->query, 'WHERE')) {
            $this->query .= " AND ${column} ${operator} ${value}";
        } else {
            $this->query .= " WHERE ${column} ${operator} ${value}";
        }

        return $this;
    }

    private function prepareValueAndOperator($operator = null, $value = null, bool $useDefault = true): array
    {
        if ($useDefault) {
            return ['=', $operator];
        } else {
            return [$operator, $value];
        }
    }

    /**
     * クエリに"order by"句を追加
     *
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction);

        if (!in_array($direction, ['ASC', 'DESC'])) {
            throw new InvalidArgumentException('Order direction must be "ASC" or "DESC".');
        }

        $this->query .= " ORDER BY ${column} ${direction}";

        return $this;
    }

    public function get(): array
    {
        return $this->connection->exec($this->query);
    }

    /**
     * SQLクエリを取得する
     *
     * @return string
     */
    public function toSql(): string
    {
        return $this->query;
    }
}

