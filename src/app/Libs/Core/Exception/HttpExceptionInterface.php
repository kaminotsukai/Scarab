<?php declare(strict_types = 1);

namespace App\Libs\Core\Exception;

interface HttpExceptionInterface
{
    public function getStatusCode();
}
