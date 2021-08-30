<?php

class DB
{
}

class QueryBuilder
{
    private string $tableName;
    private array $columns = ['`*`'];
    private array $wheres = [];

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }


    public function select(string|array $columns): self
    {
        $tmpColumns = is_string($columns) ? func_get_args() : $columns;
        $this->columns = $this->excapeColumns($tmpColumns);

        return $this;
    }

    public function selectRaw(string|array $columns): self
    {
        $this->columns = is_string($columns) ? func_get_args() : $columns;

        return $this;
    }

    public function where(string $column, string $operator, $value)
    {
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
        $columnsString = implode(', ', $this->getColumns());

        return "select {$columnsString} from {$this->getTableName()};";
    }

    private function excapeColumns(array $columns)
    {
        return array_map(
            fn (string $column) => $this->escape($column),
            $columns
        );
    }

    // テーブル名やカラム名を``でエスケープする
    private function escape(string $target)
    {
        if (strpos($target, '.') !== false) {
            // テーブル名.カラム名の場合
            [$table, $column] = explode('.', $target);
            return "`{$table}`.`{$column}`";
        }

        return "`{$target}`";
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

# case 1
$query = new QueryBuilder('hoge');
echo $query->toSql() . PHP_EOL;

$expected = "select `*` from hoge;";
assert($query->toSql() === $expected);

# case 2
$query->select('hoge');
echo $query->toSql() . PHP_EOL;

$expected = "select `hoge` from hoge;";
assert($query->toSql() === $expected);

# case 3
$query->select(['column1', 'column2']);
echo $query->toSql() . PHP_EOL;

$expected = "select `column1`, `column2` from hoge;";
assert($query->toSql() === $expected);

# case 4
$query->selectRaw('max(column1)');
echo $query->toSql() . PHP_EOL;

$expected = "select max(column1) from hoge;";
assert($query->toSql() === $expected);

# case 5
$query = $query->select('table.*');
echo $query->toSql() . PHP_EOL;

$expected = "select `table`.`*` from hoge;";
assert($query->toSql() === $expected);
