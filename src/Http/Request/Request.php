<?php

namespace Src\Http\Request;

class Request
{
    public function method(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function path(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $path = $path !== '/' ? rtrim($path, '/') : $path;
        $path = str_contains($path, '?') ? explode('?', $path)[0] : $path;
        return $path;
    }
}
