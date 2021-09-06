<?php declare(strict_types = 1);

namespace App\Modules\Controllers;

use Scarab\View\View;

class IndexController
{
    public function __construct()
    {
        //
    }

    public function index()
    {

        echo (new View())->render(
            __DIR__ . '/../Views/index.html',
            [
                'user' => [
                    'id' => 1,
                    'name' => 'makoto',
                    'age' => 22,
                    'company' => 'GIB Japan'
                ],
            ]
        );
    }
}
