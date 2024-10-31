<?php

namespace Core;

class Config
{
    const AUTHOR  = "SETHAR";
    const VERSION = "1.0";
    const LOGO    = "logo.jpg";

    public static function get($key)
    {
        return $_ENV[$key];
    }
}
