<?php

use William\Base\Route\Router;

$router = new Router();
$router->get('/', \William\Wb\Controller\Home\Index::class);

return $router->getRoutes();