<?php

declare(strict_types=1);

namespace App\Repositories;

use Scarab\Database\BaseMySqlRepository;

class TestMySqlRepository  extends BaseMySqlRepository implements TestRepositoryInterface
{
    public function __construct()
    {
        parent::__construct('test');
    }
}
