<?php

namespace Src\Config;

use ArrayAccess;

class Config implements ArrayAccess
{
    use ConfigSupport;
    protected array $config;
    public function __construct($array)
    {
        foreach ($array as $key => $value) {
            $this->config[$key] = $value;
        }
    }
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }


    public function offsetUnset(mixed $offset): void
    {
        $this->unset($offset);
    }
}
