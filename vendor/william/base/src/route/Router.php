<?php

namespace William\Base\Route;

use William\Base\Controller\Request;
use William\Base\Model\AbstractInstance;

/**
 * Class Router
 * @method Router get(string $route, string $handler)
 * @method Router post(string $route, string $handler)
 * @method Router put(string $route, string $handler)
 * @method Router delete(string $route, string $handler)
 *
 * @package William\Base\Route
 */
class Router extends AbstractInstance
{
    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @param string $method
     * @param array  $args
     * @return $this|array|bool|mixed|null
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        $methods = [Request::GET, Request::POST, Request::PUT, Request::DELETE];
        $methods = array_map('strtolower', $methods);
        $method  = strtolower($method);
        if (!in_array($method, $methods)) {
            throw new \Exception(sprintf('Method not found in %s', get_class($this)));
        }
        return $this->addRoute($method, ...$args);
    }

    /**
     * @param string $route
     * @param string $handler
     * @return $this
     * @throws \Exception
     */
    protected function addRoute(string $method, string $route, string $handler)
    {
        $route = self::buildFullPath($route);
        if (isset($this->routes[$route][$method])) {
            throw new \Exception('Route already existed');
        }
        $this->routes[$route][$method] = $handler;
        return $this;
    }

    /**
     * @param string $route
     * @param string $method
     * @return mixed
     * @throws \Exception
     */
    public function getHandler(string $route, string $method)
    {
        if (!isset($this->routes[$route][$method])) {
            throw new \Exception('Route not found');
        }
        return $this->routes[$route][$method];
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function buildFullPath(string $path)
    {
        $path = array_values(
            array_filter(
                explode('/', $path)
            )
        );
        if (count($path) < 1) {
            $path[0] = 'index';
        }
        if (count($path) < 2) {
            $path[1] = 'index';
        }
        if (count($path) < 3) {
            $path[2] = 'index';
        }
        return implode('/', $path);
    }
}