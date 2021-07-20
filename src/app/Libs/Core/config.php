<?php declare(strict_types = 1);

return function () {

    $config = [];
    $fileList = glob(__DIR__ . '/../../../config/*');

    foreach ($fileList as $file) {
        $config[basename($file, '.php')] = require $file;
    }

    Passion\Config\ApplicationConfig::getInstance()->set($config);
};
