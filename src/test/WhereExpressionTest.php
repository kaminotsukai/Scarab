<?php

use PHPUnit\Framework\TestCase;
use Scarab\Database\Expression\WhereExpression;

class WhereExpressionTest extends TestCase
{
   public function test論理演算子がない場合の戻り値()
   {
      $expression = new WhereExpression('column', '=');
      $expected = 'column = ?';

      $this->assertEquals($expected, $expression->getExpression());
   }

   public function test論理演算子がある場合の戻り値()
   {
      $expression = new WhereExpression('column', '=', 'and');
      $expected = 'and column = ?';

      $this->assertEquals($expected, $expression->getExpression());
   }

   public function test比較演算子が無効な場合、InvalidArgumentExceptionを投げること()
   {
      $this->expectException(InvalidArgumentException::class);
      $expression = new WhereExpression('column', '_', 'and');
   }
}
