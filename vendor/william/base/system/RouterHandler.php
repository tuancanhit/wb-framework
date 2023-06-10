<?php
declare(strict_types=1);

use William\Base\Helper\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$custom_routes = require $root_folder . '/src/route/web.php';
$base_routes   = require $root_folder . '/vendor/william/base/src/route/web.php';
$route_list    = array_merge($base_routes, $custom_routes);

/**
 * @param RequestInterface $request
 * @return mixed
 * @throws RouteNotFoundException
 */
function get_request_handler(RequestInterface $request)
{
    global $route_list;
    $path   = $request->getFullPath();
    $method = strtolower($request->getMethod());
    if (!$path || !isset($route_list[$path][$method])) {
        throw new RouteNotFoundException('Route not found');
    }
    return $route_list[$path][$method];
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