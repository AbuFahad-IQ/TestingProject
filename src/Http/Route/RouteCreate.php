<?php

namespace Src\Http\Route;

use Src\Http\Request\Request;
use Src\Http\Partials\RouteStorage;

class RouteCreate extends RouteStorage
{
    protected Request $request;
    public function __construct()
    {
        $this->request = new Request();
    }


    public static function create($method, $route, $callback, $routeName = null)
    {
        $instance = new self();
        return $instance->handle($method, $route, $callback, $routeName);
    }


    private function handle($method, $route, $callback, $routeName = null)
    {
        if (!RouteValidate::validate($method, $route, $callback)) {
            exit;
        }

        $routePattern = self::getRoutePattern($route);
        preg_match_all('/{(\w+)}/', $route, $keyParams);

        self::$storage[$method][$routePattern] = [
            'callback' => $callback,
            'baseRoute' => $route,
            "params" => $keyParams[1],
            'routeName' => $routeName,
        ];
    }

    public static function matchRoute($method, $path)
    {
        foreach (self::$storage[$method] as $routePattern => $routeData) {
            if (preg_match("#^$routePattern$#", $path, $match)) {
                $valueParams = array_slice($match, 1);
                $keyParams = $routeData['params'];

                if (count($keyParams) === count($valueParams)) {
                    $routeData['params'] = array_combine($keyParams, $valueParams);
                    return $routeData;
                }
            }
        }
        return false;
    }


    public static function getRoutePattern($route)
    {
        return preg_replace('/{(\w+)}/', '(\w+)', $route);
    }


    public static function getRouteName($name): mixed
    {
        foreach (self::$storage as $route) {
            foreach ($route as $data) {
                if (isset($data['routeName']) && $data['routeName'] === $name) {
                    return $data['baseRoute'];
                }
            }
        }
        return null;
    }
}