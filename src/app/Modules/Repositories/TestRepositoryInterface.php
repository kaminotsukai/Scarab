<?php declare(strict_types = 1);

namespace App\Modules\Repositories;

interface TestRepositoryInterface
{
    /**
     * レコードを挿入する
     * @param array $datas カラム名とカラム値からなる連想配列
     * @return int 挿入されたレコードのid値
     */
    public function create(array $data): int;
}


