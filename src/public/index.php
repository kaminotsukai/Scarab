<?php declare(strict_types = 1);

require '../vendor/autoload.php';

// 例外処理
// $handleException = require __DIR__ . '/../app/Libs/Core/handle-exception.php';
// $handleException();

// DIコンテナ
$container = require __DIR__ . '/../app/Libs/Core/container.php';
$container();

// ルーティングの定義
$routes = require __DIR__ . '/../app/Libs/Core/routes.php';
$routes();

// 設定ファイルの定義
$config = require __DIR__ . '/../app/Libs/Core/config.php';
$config();
