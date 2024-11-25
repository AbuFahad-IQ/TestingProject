<?php

namespace Src\Http\Route;

use App\View\ViewError;

class RouteHandler
{
    private static function checkClassAndMethod($class, $method): bool
    {
        try {
            if (! class_exists($class) || ! method_exists($class, $method)) {
                throw new \ErrorException("Not Found Class Or Method $class::$method");
            }
        } catch (\ErrorException $e) {
            echo 'Error Class Or Method : ' . $e->getMessage();
            exit;
        }
        return true;
    }


    public static function handleStringAction($action, $params = []): void
    {
        if (str_contains($action, '@')) {
            $routeString = explode('@', $action);
            $class = $routeString[0];
            $method = $routeString[1];
            static::checkClassAndMethod($class, $method);
            $reflection = new \ReflectionClass($class);
            $methodReflection = $reflection->getMethod($method);

            if (count($methodReflection->getParameters()) > 0 && count($methodReflection->getParameters()) !== count($params)) {
                ViewError::error('404');
                return;
            }

            call_user_func_array([new $class, $method], $params);
        }
    }

    public static function handleArrayAction($action, $params = []): void
    {
        static::checkClassAndMethod($action[0], $action[1]);
        $reflection = new \ReflectionClass($action[0]);
        $method = $reflection->getMethod($action[1]);

        if (count($method->getParameters()) > 0 && count($method->getParameters()) !== count($params)) {
            ViewError::error('404');
            return;
        }

        call_user_func_array([new $action[0], $action[1]], $params);
    }

    public static function handleCallableAction($action, $params = []): void
    {
        $reflection = new \ReflectionFunction($action);

        if (count($reflection->getParameters()) !== count($params)) {
            ViewError::error('404');
            return;
        }

        call_user_func_array($action, $params);
    }
}
