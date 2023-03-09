<?php


namespace App\Core;

use StdCmp\DI\DIContainer;

class Router extends Controller
{
    private $container;
    public function __construct($container)
    {
        parent::__construct();
        $this->container = $container;
    }

    private $routes = [];

    public function add($route, $callback)
    {
        $this->routes[$route] = $callback;
    }

    public function reverseRoute($url, $route, $fn)
    {
        $t = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route)) . "$@D";
        $is_match = preg_match($t, $url, $matches);
        if ($is_match) {
            array_shift($matches);
            $class = "\App\Controllers\\$fn[0]";
            $obj = $this->container->get($class);
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $obj->{$fn[1]}(...$matches);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $obj->{$fn[1]}(new Request(), ...$matches);
            }
        }

        return $is_match;
    }


    public function run()
    {
        $url = ltrim($_SERVER['REQUEST_URI'], '/');
        $i = 0;
        foreach ($this->routes as $route => $callback) {
            $fn = explode('@', $callback);
            $is_match = $this->reverseRoute($url, $route, $fn);
           
            if ($is_match) {
                break;
            }

            $i++;
        }
        if (count($this->routes) == $i) {
            http_response_code(404);
            $this->render('errors/404.html.twig', []);
        }
    }
}
