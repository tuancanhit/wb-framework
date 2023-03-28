<?php
declare(strict_types=1);

use William\Base\Helper\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$custom_routes = require $root_folder . '/src/route/web.php';
$base_routes   = require $root_folder . '/vendor/william/base/src/route/web.php';

/**
 * @param RequestInterface $request
 * @return mixed
 * @throws RouteNotFoundException
 */
function get_request_handler(RequestInterface $request)
{
    global $base_routes;
    global $custom_routes;
    $routes = array_merge($custom_routes, $base_routes);

    $path = $request->getFullPath();
    if (!$path || !isset($routes[$path][$request->getMethod()])) {
        throw new RouteNotFoundException('Route not found');
    }
    return $routes[$path][$request->getMethod()];
}

/**
 * @param string $path
 * @param string $type
 * @return string
 */
function asset(string $path, string $type)
{
    return sprintf('%s/pub/%s/%s', config('site.base_url'), $type, $path);
}