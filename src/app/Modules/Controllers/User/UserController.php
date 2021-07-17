<?php declare(strict_types = 1);

namespace App\Modules\Controllers\User;

use App\Libs\Core\Exception\InternalServerException;

class UserController
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        echo 'UserController::indexAction()がコールされました。';
    }

    public function show($params)
    {
        echo $params['id'];
    }
}
