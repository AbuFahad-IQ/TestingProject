<?php

namespace Src\Http\Partials;

use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Http\Partials\RouteStorage;

abstract class RouteHttp extends RouteStorage
{
    protected Request $request;
    protected Response $response;
}
