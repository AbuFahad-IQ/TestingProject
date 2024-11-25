<?php

namespace Src\Database\Connects;

use Src\Database\Managers\Contract\DatabaseManager;

trait ConnectTo
{
    public static function connect(DatabaseManager $manager)
    {
        return $manager->connect();
    }
}
