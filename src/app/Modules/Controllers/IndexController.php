<?php declare(strict_types = 1);

namespace App\Modules\Controllers;

class IndexController
{
    public function __construct()
    {
        //
    }

    public function index()
    {
        echo 'IndexController::indexAction()がコールされました。';
    }
}
