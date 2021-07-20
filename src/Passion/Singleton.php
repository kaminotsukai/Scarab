<?php declare(strict_types = 1);

namespace Passion;

trait Singleton
{
    static $instance = null;

    private function __construct() {}

    public static function getInstance()
    {
        return static::$instance ?? static::$instance = new static();
    }
}
