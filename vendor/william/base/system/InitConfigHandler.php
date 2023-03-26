<?php
declare(strict_types=1);

use William\Base\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$configs = require __DIR__ . '/../../../../src/etc/config.php';
$routes = require __DIR__ . '/../../../../src/Route/web.php';

function config(string $path)
{
    global $configs;
    try {
        $connector = ConfigResolver::getInstance();
    } catch (SystemInitFailureException $e) {
        $connector = (new ConfigResolver($configs));
    }
    return $connector->config($path);
}

/**
 * @param RequestInterface $request
 * @return mixed
 * @throws RouteNotFoundException
 */
function getRequestHandler(RequestInterface $request)
{
    global $routes;
    $path = $request->getRequestPath();
    if (!$path) {
        throw new RouteNotFoundException('Route not found');
    }
    $path = array_values(array_filter(explode('/', $path)));
    if (count($path) < 1) {
        $path[0] = 'index';
    }
    if (count($path) < 2) {
        $path[1] = 'index';
    }
    if (count($path) < 3) {
        $path[2] = 'index';
    }
    $path = implode('/', $path);
    if (empty($routes[$path]['class'])) {
        throw new RouteNotFoundException('Route not found');
    }
    if ($routes[$path]['method'] !== $request->getMethod()) {
        throw new RouteNotFoundException('Request method not found');
    }
    return $routes[$path]['class'];
}

