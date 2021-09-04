<?php

namespace Scarab\Database;

use Scarab\Database\QueryFormatter;
use Scarab\Database\Expression\WhereExpression;

class QueryBuilder
{
    private string $tableName;
    private array $columns = ['*'];
    private array $wheres = [];

    private array $bindings = [
        'where' => [],
    ];

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function get(): array
    {
        return DB::execute($this->toSql(), $this->getBindings());
    }

    // TODO: 引数をstring | arrayに限定する
    public function select($columns): self
    {
        $tmpColumns = is_string($columns) ? func_get_args() : $columns;
        $this->columns = $this->escapeColumns($tmpColumns);

        return $this;
    }

    // TODO: 引数をstring | arrayに限定する
    public function selectRaw($columns): self
    {
        $this->columns = is_string($columns) ? func_get_args() : $columns;

        return $this;
    }

    public function where(string $column, string $operator, $value, string $join = '')
    {
        $where = new WhereExpression($column, $operator, $join);
        $this->wheres[] = $where;
        $this->bindings['where'][] = $value;

        return $this;
    }

    public function orWhere(string $column, string $operator, $value)
    {
    }

    public function whereNull(string $column, bool $isNull)
    {
        if ($isNull) {
        } else {
        }
    }

    public function toSql(): string
    {
        return QueryFormatter::toSql(
            $this->getColumns(),
            $this->getTableName(),
            $this->wheres
        );
    }

    public function getBindings(): array
    {
        $bindings = [];
        foreach ($this->bindings as $values) {
            $bindings = [...$bindings, ...$values];
        }
        return $bindings;
    }

    private function escapeColumns(array $columns)
    {
        return array_map(
            fn (string $column) => $this->escape($column),
            $columns
        );
    }

    /**
     * テーブル名やカラム名を``でエスケープする
     */
    private function escape(string $target)
    {
        // テーブル名.カラム名の場合
        if (strpos($target, '.') !== false) {
            [$table, $column] = explode('.', $target);

            $escapedTarget = "`{$table}`.";
            $escapedTarget .= $column === '*' ? $column : "`{$column}`";

            return $escapedTarget;
        }

        return $target === '*' ? $target : "`{$target}`";
    }

    private function getTableName(): string
    {
        return $this->tableName;
    }

    private function getColumns(): array
    {
        return $this->columns;
    }
}
