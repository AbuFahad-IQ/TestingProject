<?php

namespace Src\Config;

use Src\Support\Arr;

trait ConfigSupport
{
    protected function get($key, $default = null): mixed
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }
        return Arr::get($this->config, $key, $default);
    }

    private function getMany($keys): array
    {
        $config = [];

        foreach ($keys as $key => $value) {
            $config[$key] = Arr::get($this->config, $key, $value);
        }

        return $config;
    }

    protected function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->config,  $value, $key);
        }
    }


    protected function unset($key): void
    {
        Arr::forget($this->config, $key);
    }

    protected function has($key): bool
    {
        return Arr::has($this->config, $key);
    }

    protected function all()
    {
        return $this->config;
    }

    public function __call($name, $arg)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arg);
        }
    }
}
