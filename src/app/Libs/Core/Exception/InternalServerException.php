<?php declare(strict_types = 1);

namespace App\Libs\Core\Exception;


class InternalServerException extends \Exception implements HttpExceptionInterface
{
    const CODE = 500;
    const MESSAGE = 'Internal Server';

    public function getStatusCode(): array
    {
        return [
            self::CODE,
            self::MESSAGE
        ];
    }
}
