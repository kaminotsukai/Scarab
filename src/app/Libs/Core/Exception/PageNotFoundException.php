<?php declare(strict_types = 1);

namespace App\Libs\Core\Exception;


class PageNotFoundException extends \Exception implements HttpExceptionInterface
{
    const CODE = 404;
    const MESSAGE = 'Not Found';

    public function getStatusCode(): array
    {
        return [
            self::CODE,
            self::MESSAGE
        ];
    }
}
