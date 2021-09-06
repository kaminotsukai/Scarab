<?php declare(strict_types = 1);

namespace Scarab\Http;

/**
 * リクエストデータを扱うクラス
 */
class Request
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * リクエストで送られてきたデータをキーで取得する
     */
    public function input(string $key)
    {
        return $this->data[$key] ?? null;
    }
}
