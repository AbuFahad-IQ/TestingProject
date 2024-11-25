<?php

namespace Src\Config;

use DirectoryIterator;

class ConfigLoad
{
    public function __construct(protected DirectoryIterator $directory) {}

    public function load(): array
    {
        $items = [];

        foreach ($this->directory as $file) {
            if ($file->isDot()) {
                continue;
            }

            $fileName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $items[$fileName] = require configPath() . $file->getFilename();
        }
        return $items;
    }
}
