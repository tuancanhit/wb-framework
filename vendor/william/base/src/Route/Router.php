<?php

namespace William\Base\Route;

use William\Base\Controller\Request;
use William\Base\Model\AbstractInstance;

/**
 * Class Router
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
     * @param string $route
     * @param string $handler
     * @return $this
     * @throws \Exception
     */
    public function get(string $route, string $handler)
    {
        $method = Request::GET;
        if (isset($this->routes[$route][$method])) {
            throw new \Exception('Route already existed');
        }
        $this->routes[$route][$method] = $handler;
        return $this;
    }

    /**
     * @param string $route
     * @param string $handler
     * @return $this
     * @throws \Exception
     */
    public function post(string $route, string $handler)
    {
        $method = Request::POST;
        if (isset($this->routes[$route][$method])) {
            throw new \Exception('Route already existed');
        }
        $this->routes[$route][$method] = $handler;
        return $this;
    }

    /**
     * @param string $route
     * @param string $handler
     * @return $this
     * @throws \Exception
     */
    public function put(string $route, string $handler)
    {
        $method = Request::PUT;
        if (isset($this->routes[$route][$method])) {
            throw new \Exception('Route already existed');
        }
        $this->routes[$route][$method] = $handler;
        return $this;
    }

    /**
     * @param string $route
     * @param string $handler
     * @return $this
     * @throws \Exception
     */
    public function delete(string $route, string $handler)
    {
        $method = Request::DELETE;
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
}