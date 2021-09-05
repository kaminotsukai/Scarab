<?php declare(strict_types = 1);

namespace Scarab\Trial\Database;

/**
 * DBとの接続を行う
 */
class DB
{
  public static function table(string $table): QueryBuilder
  {
    return new QueryBuilder($table);
  }
}




