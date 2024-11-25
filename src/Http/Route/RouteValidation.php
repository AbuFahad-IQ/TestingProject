<?php

namespace Src\Http\Route;

class RouteValidation
{
    protected static function isValidRoute(string $route): bool
    {
        return !empty($route) && is_string($route) && str_starts_with($route, '/');
    }


    protected static function isValidCallback(mixed $callback)
    {
        return !empty($callback) && is_string($callback) || is_array($callback) || is_callable($callback);
    }


    protected static function isValidMethod(string $method): bool
    {
        return !empty($method) && is_string($method) && $method === 'get' || $method === 'post';
    }
}
