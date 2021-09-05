<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

/**
 * SQLを構築する
 */
class QueryBuilder
{
    private string $table;

    private string $query;

    public function __construct(string $table)
    {
        $this->table = $table;
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
     * SQLクエリを取得する
     *
     * @return string
     */
    public function toSql(): string
    {
        return $this->query;
    }
}
