<?php

namespace Src\Http\Route;

use App\View\ViewError;
use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Http\Route\RouteCreate;
use Src\Http\Partials\RouteHttp;
use Src\Http\Route\RouteHandler;

class RouteResolved extends RouteHttp
{
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function handle(): void
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $matchedRoute = RouteCreate::matchRoute($method, $path);

        if (!$matchedRoute) {
            ViewError::error('404');
            exit;
        }

        $action = $matchedRoute['callback'];
        $params = $matchedRoute['params'];

        match (true) {
            is_string($action) => RouteHandler::handleStringAction($action, $params),
            is_array($action) => RouteHandler::handleArrayAction($action, $params),
            is_callable($action) => RouteHandler::handleCallableAction($action, $params),
            default => false
        };
    }
}
