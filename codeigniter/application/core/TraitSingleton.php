<?php

trait TraitSingleton
{
    protected function __construct()
    {
    }
    public static function getInstance()
    {
        static $obj = null;
        return $obj ?: $obj = new static;
    }

    public function __clone()
    {
        throw new RuntimeException("You can't clone this instance.");
    }
}
