<?php

declare(strict_types=1);

namespace Scarab\Database\Expression;

use InvalidArgumentException;

class WhereExpression
{
    const VALID_OPERATORS = [
        '=',
        '!=',
        'like',
        '<',
        '>',
        '<=',
        '>='
    ];

    public function __construct(
        private string $column,
        private string $operator,
        private string $join = '',
        // stringにしたら自動で変換されていた(strict_typesが効いていなさそう)
    ) {
        if (!in_array($operator, self::VALID_OPERATORS)) {
            throw new InvalidArgumentException("where句で有効な演算子ではありません。");
        }
    }

    public function getExpression(): string
    {
        $join = $this->join === '' ? '' : "{$this->join} ";
        return "{$join}{$this->column} {$this->operator} ?";
    }

    public function dump()
    {
        print_r([
            $this->column,
            $this->operator,
            $this->value
        ]);
    }
}
