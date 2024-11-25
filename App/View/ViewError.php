<?php

namespace App\View;

class ViewError
{
    public static function error($error): void
    {
        ViewHandler::checkContentReplace($error, true);
    }
}
