<?php declare(strict_types = 1);

require '../vendor/autoload.php';

// ルーティングの定義
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {
    $router->addRoute('GET', '/', function ($params) {
        $controller = new App\Modules\Controllers\IndexController();
        $controller->index();
    });

    $router->addRoute('GET', '/users', function ($params) {
        $controller = new App\Modules\Controllers\User\UserController();
        $controller->index();
    });

    // キー + ":" + 値を表す正規表現
    $router->addRoute('GET', '/users/{id:\d+}', function ($params) {
        $controller = new App\Modules\Controllers\User\UserController();
        $controller->show($params);
    });
});

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
        echo 'ページが見つかりません';
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
