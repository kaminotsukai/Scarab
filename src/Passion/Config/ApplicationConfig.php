<?php declare(strict_types = 1);

namespace Passion\Config;

use InvalidArgumentException;
use Passion\Singleton;

/**
 * アプリケーション全体で共有する設定情報を保持するクラス
 */
class ApplicationConfig
{
    use Singleton;

    /**
     * 設定情報を連想配列で保持する
     */
    private static array $items = [];

    /**
     * 設定情報の連想配列をセットする
     */
    public static function set(array $items): void
    {
        static::$items = $items;
    }

    /**
     * 設定ファイルから値を取得する
     */
    public static function get(string $key, $default = null)
    {
        return static::getUsingDotNotation(static::$items, $key, $default);
    }

    /**
     * ドット記法を使用して、配列からアイテムを取得する
     */
    private static function getUsingDotNotation(array $array, $key, $default)
    {
        if (strpos($key, '.') === false) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        return $array;
    }

    /**
     * 接続先のデータベース情報を取得
     */
    public static function getDatabase(): array
    {
        $driver = static::get('database.default');
        $dbConfig = static::get("database.connections.{$driver}");
        return $dbConfig;
    }
}
