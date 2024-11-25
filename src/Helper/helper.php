<?php

if (! function_exists('basePath')) {
    function basePath(): string
    {
        return dirname(__DIR__) . '/../';
    }
}


if (! function_exists('viewPath')) {
    function viewPath(): string
    {
        return basePath() . 'Views/';
    }
}


if (! function_exists('configPath')) {
    function configPath(): string
    {
        return basePath() . 'Config/';
    }
}


if (! function_exists('value')) {
    function value($value): mixed
    {
        return ($value instanceof \Closure) ? $value() : $value;
    }
}


if (! function_exists('env')) {
    function env($key, $default = null): mixed
    {
        return $_ENV[$key] ?? value($default);
    }
}


if (! function_exists('toSpace')) {
    function toSpace($value): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', ' ', $value);
    }
}


if (! function_exists('app')) {
    function app(): ?Src\Application\App
    {
        static $instance;

        if (! $instance) {
            $instance = new Src\Application\App();
        }
        return $instance;
    }
}



if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app()->config;
        }

        if (is_array($key)) {
            return app()->config->set($key);
        }

        return app()->config->get($key, $default);
    }
}



if (! function_exists('bcrypt')) {
    function bcrypt($password): string
    {
        return Src\Hash\Hash::bcrypt($password);
    }
}



if (! function_exists('view')) {
    function view($view, $params = []): void
    {
        echo App\View\View::make($view, $params);
    }
}



if (! function_exists('route')) {
    function route($routeName)
    {
        return Src\Http\Route\RouteCreate::getRouteName($routeName);
    }
}
