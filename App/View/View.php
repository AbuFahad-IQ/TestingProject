<?php

namespace App\View;

use App\View\ViewHandler;

class View
{
    public static function make($view, $params = []): string
    {
        return str_replace(
            '{{content}}',
            ViewHandler::checkContentReplace($view, params: $params),
            ViewHandler::getBaseContent(),
        );
    }
}
