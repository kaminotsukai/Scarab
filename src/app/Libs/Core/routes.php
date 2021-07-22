<?php declare(strict_types = 1);

use App\Libs\Core\Exception\PageNotFoundException;

return function () {
    $dispatcher = require __DIR__ . '/../../../routes/routes.php';

    // RequestからURIとHTTP Methodを取得する
    $httpMethod = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // クエリパラメーターを削除して、URIデコードを行う
    if (false !== $pos = strpos($uri, '?')) {
        $uri = substr($uri, 0, $pos);
    }
    $uri = rawurldecode($uri);

    // 紐づいたコントローラーを呼び出す
    $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            throw new PageNotFoundException();
            break;
        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            echo 'HTTPメソッドが許可されていません。';
            break;
        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $params = $routeInfo[2];
            echo $handler($params);
            break;
    }
};
