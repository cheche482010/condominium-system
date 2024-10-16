<?php

namespace Core;

class Config
{
    public static function get($key)
    {
        return $_ENV[$key];
    }
}
