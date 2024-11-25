<?php

namespace Src\Http\Route;


use Src\Http\Route\RouteValidation;

class RouteValidate extends RouteValidation
{
    public static function validate($method, $route, $callback): bool
    {
        try {
            if (! static::isValidMethod($method) || ! static::isValidRoute($route) || ! static::isValidCallback($callback)) {
                throw new \ErrorException('The Route Not Valid Or Method Not Get Or Post Or Callback Not Supported');
            }
        } catch (\ErrorException $e) {
            echo 'Error Route : ' . $e->getMessage();
            return false;
        }
        return true;
    }
}
