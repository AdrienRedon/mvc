<?php

namespace Core;

class App
{
    public static function get($key)
    {
        return DIC::getInstance()->get($key);
    }
}