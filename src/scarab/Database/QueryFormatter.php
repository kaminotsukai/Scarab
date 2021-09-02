<?php

declare(strict_types=1);

namespace Scarab\Database;

use Scarab\Database\Expression\WhereExpression;

class QueryFormatter
{
    public static function toSql(array $columns, string $table, array $wheres)
    {
        $selectClause = self::buildSelectClause($columns);
        $whereClause = self::buildWhereClause($wheres);

        return "{$selectClause} from {$table} {$whereClause};";
    }

    /**
     * select句を作成する
     */
    private static function buildSelectClause(array $columns)
    {
        $columnString = implode(', ', $columns);
        return "select {$columnString}";
    }

    /**
     * Where句を作成する
     */
    private static function buildWhereClause(array $wheres)
    {
        $clause = 'where';
        foreach ($wheres as $where) {
            /** @var Scarab\Database\Expression\WhereExpression */
            $clause = "{$clause} {$where->getExpression()}";
        }

        return $clause;
    }
}
