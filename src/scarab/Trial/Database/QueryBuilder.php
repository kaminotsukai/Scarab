<?php

declare(strict_types=1);

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

    /** select句のカラム */
    private array $columns = ['*'];

    /** where句の条件 */
    private array $wheres = [];

    /** order by句の条件 */
    private array $orders = [];

    private array $bindings = [
        'where' => []
    ];

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
     * @return self
     */
    public function select(array $columns = ['*']): self
    {
        $this->columns = $columns;

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

        $this->wheres[] = [$column, $operator, $value, 'AND'];

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

        $this->orders[] = [$column, $direction];

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
        $columns = implode(', ', $this->columns);
        $query = "SELECT {$columns} FROM {$this->table}";

        if (!empty($this->wheres)) {
            $whereClause = "WHERE";

            foreach ($this->wheres as $index => $where) {
                [$col, $op, $val, $join] = $where;

                if ($index === 0) {
                    $whereClause .= " {$col} {$op} {$val}";
                } else {
                    $whereClause .= " {$join} {$col} {$op} {$val}";
                }
            }
            $query = $query . " {$whereClause}";
        }

        if (!empty($this->orders)) {
            $orderByClause = "ORDER BY";

            foreach ($this->orders as $index => $order) {
                [$col, $dir] = $order;

                if ($index === 0) {
                    $orderByClause .= " {$col} {$dir}";
                } else {
                    $orderByClause .= ", {$col} {$dir}";
                }
            }
            $query = $query . " {$orderByClause}";
        }

        return $query;
    }
}
