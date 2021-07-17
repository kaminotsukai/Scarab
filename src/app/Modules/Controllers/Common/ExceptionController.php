<?php declare(strict_types = 1);

namespace App\Modules\Controllers\Common;

use App\Libs\Core\Exception\PageNotFoundException;

class ExceptionController
{
    public function render(\Throwable $e)
    {
        if ($e instanceof PageNotFoundException) {
            list($statusCode, $statusMessage) = $e->getStatusCode();
            header('HTTP/1.1 ' . $statusCode . ' ' . $statusMessage);
            $message = 'Page Not Found';
        } else {
            header('HTTP/1.1 500 Internal Server Error');
            $message = '内部エラーが発生しました。';
        }

        echo <<< MESSAGE
<html>
<head><meta charset="utf-8"></head>
<body>
<h2>申し訳ありません。エラーが発生しました。</h2>
<p>メッセージ：{$message}</p>
</p>
</body>
MESSAGE;
        exit;
    }
}

