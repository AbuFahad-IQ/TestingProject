<?php

namespace Src\Support;

use ArrayAccess;

class Arr
{
    public static function only($array, $key): array
    {
        return array_intersect_key($array, array_flip((array) $key));
    }

    public static function accessible($array): bool
    {
        return is_array($array) || $array instanceof ArrayAccess;
    }

    public static function exists($array, $key): bool
    {
        return $array instanceof ArrayAccess ? $array->offsetExists($key)
            : array_key_exists($key, $array);
    }

    public static function has($array, $keys): bool
    {
        foreach (explode('.', $keys) as $key) {
            if (static::accessible($array) && static::exists($array, $key)) {
                $array = $array[$key];
            } else {
                return false;
            }
        }
        return true;
    }

    public static function forget(&$array, $key)
    {
        $keys = (array) $key;

        foreach ($keys as $key) {
            $segments = explode('.', $key);
            $lastKey = array_pop($segments);
            foreach ($segments as $segment) {
                if (static::accessible($array) && static::exists($array, $segment)) {
                    $array = &$array[$segment];
                } else {
                    $array = null;
                    break;
                }
            }
            unset($array[$lastKey]);
        }
    }

    public static function flatten($array, $depth = INF): array
    {
        $result = [];
        foreach ($array as $item) {
            if (static::accessible($item) && $depth > 1) {
                $result = array_merge($result, static::flatten($item, $depth - 1));
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }

    public static function get($array, $keys, $default = null)
    {
        if (!str_contains($keys, '.') && static::exists($array, $keys)) {
            return $array[$keys];
        }

        foreach (explode('.', $keys) as $key) {
            if (static::accessible($array) && static::exists($array, $key)) {
                $array = $array[$key];
            } else {
                return value($default);
            }
        }
        return $array;
    }

    public static function set(&$array, $value, $key = null)
    {
        if (is_null($key)) {
            return array_push($array, $value);
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);
            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }

    public static function isAssoc($array): bool
    {
        return !array_is_list($array);
    }

    public static function isList($array): bool
    {
        return array_is_list($array);
    }

    public static function last($array, ?callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? value($default) : end($array);
        }

        $array = array_reverse($array, true);
        return static::first($array, $callback, $default);
    }

    public static function first($array, ?callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? value($default) : reset($array);
        }

        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
    }

    public static function except(&$array, $keys)
    {
        if (!str_contains($keys, '.') && static::exists($array, $keys)) {
            unset($array[$keys]);
        }

        foreach (explode('.', $keys) as $key) {
            if (static::exists($array, $key)) {
                unset($array[$key]);
            } else {
                continue;
            }
        }
    }
}
