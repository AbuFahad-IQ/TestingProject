<?php

namespace Src\Http\Route;

use Src\Http\Route\RouteCreate;

class Route
{
    public static function get($route, $callback, $nameRoute = null): void
    {
        RouteCreate::create('get', $route, $callback, $nameRoute);
    }

    public static function post($route, $callback, $nameRoute = null)
    {
        RouteCreate::create('post', $route, $callback, $nameRoute);
    }
}
