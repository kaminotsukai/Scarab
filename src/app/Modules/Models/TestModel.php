<?php declare(strict_types = 1);

namespace App\Modules\Models;

use App\Modules\Repositories\TestMariadbRepository;
use App\Modules\Repositories\TestRepositoryInterface;

class TestModel
{
    private TestRepositoryInterface $testRepository;

    public function __construct()
    {
        // TODO: DIする
        $this->testRepository = new TestMariadbRepository();
    }

    public function create(): int
    {
        return $this->testRepository->create(['value' => 'test']);
    }
}
