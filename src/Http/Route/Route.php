<?php

namespace Src\Http\Route;

use Src\Http\Route\RouteCreate;

class Route
{
    public static function get(string $route, mixed $callback, string $nameRoute = null): void
    {
        RouteCreate::create('get', $route, $callback, $nameRoute);
    }

    public static function post(string $route, mixed $callback, string $nameRoute = null)
    {
        RouteCreate::create('post', $route, $callback, $nameRoute);
    }
}
