<?php
declare(strict_types=1);

use William\Base\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$routes = require __DIR__ . '/../../../../src/Route/web.php';

/**
 * @param RequestInterface $request
 * @return mixed
 * @throws RouteNotFoundException
 */
function getRequestHandler(RequestInterface $request)
{
    global $routes;
    $path = $request->getFullPath();
    if (!$path || !isset($routes[$path][$request->getMethod()])) {
        throw new RouteNotFoundException('Route not found');
    }
    return $routes[$path][$request->getMethod()];
}
