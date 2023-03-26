<?php

use William\Base\Controller\AbstractFrontendController;
use William\Base\Route\Router;
use William\Wb\Controller\Home\Index;

$router = new Router();
$router->get('index/index/index', Index::class);
$router->get('404', AbstractFrontendController::class);

return $router->getRoutes();