<?php declare(strict_types = 1);

namespace App\Modules\Repositories;

class TestMariadbRepository implements TestRepositoryInterface
{
    public function create(array $data): int
    {
        return 1;
    }
}
