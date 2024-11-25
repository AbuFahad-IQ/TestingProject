<?php

namespace Src\Application;

use Dotenv\Dotenv;
use Src\Database\DB;
use DirectoryIterator;
use Src\Config\Config;
use Src\Config\ConfigLoad;
use Src\Database\Managers\MySQLManager;
use Src\Http\Request\Request;
use Src\Http\Response\Response;
use Src\Http\Route\RouteResolved;

class App
{
    protected RouteResolved $route;
    protected Request $request;
    protected Response $response;
    protected DirectoryIterator $directory;
    protected ConfigLoad $configLoad;
    protected DB $db;
    protected Config $config;
    public function __construct()
    {
        Dotenv::createImmutable(basePath())->load();
        $this->directory = new DirectoryIterator(configPath());
        $this->configLoad = new ConfigLoad($this->directory);
        $this->config = new Config($this->configLoad->load());
        $this->db = new DB($this->getDriverDatabase());
        $this->request = new Request();
        $this->response = new Response();
        $this->route = new RouteResolved($this->request, $this->response);
    }

    private function getDriverDatabase()
    {
        return match (env('DB_DRIVER')) {
            'mysql' => new MySQLManager(),
        };
    }

    public function run()
    {
        $this->db->connect();
        $this->route->handle();
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }
}
