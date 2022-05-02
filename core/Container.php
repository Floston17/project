<?php

namespace core;

class Container
{
    protected static array $data = [];

    /**
     * Binds key to the value by storing it in array.
     */
    public static function bind($key, $value)
    {
        static::$data[$key] = $value;
    }

    /**
     * Gets stored data by key.
     */
    public static function get($key)
    {
        return static::$data[$key];
    }
}