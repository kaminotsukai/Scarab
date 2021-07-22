<?php declare(strict_types = 1);

namespace App\Modules\Controllers\User;

use App\Libs\Core\Exception\InternalServerException;
use Scarab\Http\Request;

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

    public function show(Request $request)
    {
        $id = $request->input('id');
        echo $id;
    }
}
