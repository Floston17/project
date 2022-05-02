<?php

namespace core;

class Request
{
    /**
     * Returns URI (PHP_URL_PATH only and '/' is trimmed).
     */
    public static function getUri()
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Returns request method.
     */
    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function oldData(string $name)
    {
        if (isset($_POST[$name]) && $_POST[$name] != '') {
            return $_POST[$name];
        }
    }
}