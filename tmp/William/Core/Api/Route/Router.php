<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Route;

use William\Core\Api\RequestInterface;

/**
 * Class Router
 * @method \Router get(string $route, string $handler, $middleware = null, bool $isAdmin = false)
 * @method \Router post(string $route, string $handler, $middleware = null, bool $isAdmin = false)
 * @method \Router put(string $route, string $handler, $middleware = null, bool $isAdmin = false)
 * @method \Router delete(string $route, string $handler, $middleware = null, bool $isAdmin = false)
 *
 * @package William\Base\Route
 */
class Router extends \Core\Model\DataObject
{
    protected array $routes = [];
    protected static ?Router $instance = null;

    /**
     * @param string $method
     * @param array  $args
     * @return $this
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        $methods = [RequestInterface::GET, RequestInterface::POST, RequestInterface::PUT, RequestInterface::DELETE];
        $methods = array_map('strtolower', $methods);
        $method = strtolower($method);
        if (!in_array($method, $methods)) {
            throw new \Exception(sprintf('Method not found in %s', get_class($this)));
        }
        return $this->addRoute($method, ...$args);
    }

    /**
     * @return Router
     */
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param string $method
     * @param string $route
     * @param string $handler
     * @param null   $middleware
     * @param bool   $isAdmin
     * @return $this
     * @throws \Exception
     */
    protected function addRoute(string $method, string $route, string $handler, $middleware = null, bool $isAdmin = false)
    {
        if ('/' != $route) {
            $route = trim($route, '/');
        }
        $route = self::buildFullPath($route);
        if ($isAdmin) {
            $prefix = strtolower(config('admin.front_name', 'admin'));
            $route = sprintf('%s/%s', $prefix, $route == '/' ? '' : $route);
        }
        if ('/' != $route) {
            $route = trim($route, '/');
        }
        if (isset($this->routes[$route][$method])) {
            throw new \Exception('Route already existed');
        }
        $this->routes[$route][$method]['handler'] = $handler;
        if ($middleware) {
            $this->routes[$route][$method]['middleware'] = $middleware;
        }
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
        if (empty($path)) {
            return '/';
        }

        return implode('/', $path);
    }
}