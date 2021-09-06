<?php declare(strict_types = 1);

use App\Modules\Controllers\IndexController;
use App\Modules\Controllers\User\UserController;
use Scarab\Http\Request;

/**
 * ルーティング定義ファイル
 */
return $dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $router) {

    // コントローラーを呼び出す時にRequestクラスをDIする
    $run = function ($class, $action, $params) {
        $controller = new $class();
        $controller->$action(new Request($params));
    };

    $router->addRoute('GET', '/', function ($params) use ($run) {
        $run(IndexController::class, 'index', $params);
    });

    $router->addRoute('GET', '/users', function ($params) use ($run) {
        $run(UserController::class, 'index', $params);
    });

    // キー + ":" + 値を表す正規表現
    $router->addRoute('GET', '/users/{id:\d+}', function ($params) use ($run) {
        $run(UserController::class, 'show', $params);
    });
});
