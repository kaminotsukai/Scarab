<?php declare(strict_types = 1);

return function () {

    $handleException = function (Throwable $e) {
        (new App\Modules\Controllers\Common\ExceptionController())->render($e);
    };
    set_exception_handler($handleException);

};
