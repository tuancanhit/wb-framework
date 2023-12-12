<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Resolver;

use William\Cache\Service\RedisCache;
use William\Core\Api\Framework\Http\ControllerInterface;
use William\Core\Api\Framework\Http\RequestInterface;
use William\Core\Api\Framework\Http\ResponseInterface;
use William\Core\Exception\RouteNotFoundException;
use William\Core\Framework\Http\Response;
use William\Core\Model\DataObject;

/**
 * Class Router
 *
 * @package William\Core\Resolver
 */
class Router extends DataObject
{
    public const CACHE_KEY = 'routes_cache';
    protected array $routes = [];

    public function __construct(
        protected RedisCache $redisCache,
        protected Dependency $DIResolver,
        array $data = []
    ) {
        parent::__construct($data);
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getRoutes()
    {
        if (empty($this->routes)) {
            $routes = $this->redisCache->get(static::CACHE_KEY);
            if (empty($routes) || empty(json_decode($routes, true))) {
                $routes = GlobalRequire::getInstance(WB_ROOT)
                    ->setIdentifier('route')
                    ->execute();
                $this->redisCache->set(static::CACHE_KEY, json_encode($routes));
            } else {
                $routes = json_decode($routes, true);
            }
            $this->routes = $routes;
        }
        return $this->routes;
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws RouteNotFoundException
     */
    protected function getMatchedRoute(RequestInterface $request)
    {
        $fullPath = $request->getFullPath();
        if (!$fullPath) {
            $fullPath = '/';
        }
        $routes = $this->getRoutes();
        if (empty($routes[$fullPath][$request->getMethod()])) {
            throw new RouteNotFoundException(__('Route /%s with method %s not found.', $fullPath, $request->getMethod()));
        }
        return $routes[$fullPath][$request->getMethod()];
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function resolve(RequestInterface $request)
    {
        $matchedRoute = $this->getMatchedRoute($request);
        /** @var ControllerInterface $controller */
        $controller = $this->DIResolver->resolve($matchedRoute['handler']);
        return $controller->setMiddleware($matchedRoute['middleware'] ?? [])->launch($request);
    }
}