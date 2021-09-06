<?php

declare(strict_types=1);

namespace Scarab\Database;

use Scarab\Database\Expression\WhereExpression;

class QueryFormatter
{
    public static function toSql(array $columns, string $table, array $wheres)
    {
        $selectClause = self::buildSelectClause($columns);
        $whereClause = empty($wheres) ? null : self::buildWhereClause($wheres);

        $query = "{$selectClause} from {$table}";

        if ($whereClause !== null) {
            $query .= " {$whereClause}";
        }
        $query .= ';';

        return $query;
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
            $clause = "{$clause} {$where->getExpression()}";
        }

        return $clause;
    }
}
