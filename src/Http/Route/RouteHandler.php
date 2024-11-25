<?php

namespace Src\Http\Route;

use App\View\ViewError;

class RouteHandler
{
    public static function handleStringAction(string $action, array $params = []): void
    {
        if (str_contains($action, '@')) {
            [$class, $method] = explode('@', $action);
            static::handleClassMethod($class, $method, $params);
        }
    }

    public static function handleArrayAction(array $action, array $params = []): void
    {
        static::handleClassMethod($action[0], $action[1], $params);
    }

    public static function handleCallableAction(callable $action, array $params = []): void
    {
        $reflection = new \ReflectionFunction($action);

        if (count($reflection->getParameters()) !== count($params)) {
            ViewError::error('404');
            return;
        }

        call_user_func_array($action, $params);
    }


    public static function handleClassMethod($class, $method, $params): void
    {
        if (! class_exists($class) || ! method_exists($class, $method)) {
            ViewError::error('404');
            exit;
        }

        $reflection = new \ReflectionClass($class);
        $methodReflection = $reflection->getMethod($method);

        if (count($methodReflection->getParameters()) > 0 && count($methodReflection->getParameters()) !== count($params)) {
            ViewError::error('404');
            exit;
        }

        call_user_func_array([new $class, $method], $params);
    }
}
