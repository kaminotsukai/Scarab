<?php declare(strict_types = 1);

use App\Libs\Mailer\SESMailSender;

return function () {
    // DIコンテナの作成
    $container = new Pimple\Container();

    $container['mailer'] = function ($c) {
        $mailer = new SESMailSender();
        return $mailer;
    };

    $container['repository'] = function ($c) {
        // $repository = new 
    };
};
