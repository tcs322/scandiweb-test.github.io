<?php

namespace Core;

class InitController
{
    public static function newController($controller)
    {
        $controller = "App\\Controllers\\" . $controller;
        return new $controller;
    }
}