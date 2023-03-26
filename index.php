<?php

use William\Base\Controller\Request;
use William\Base\Route\Router;

require 'vendor/autoload.php';
require 'vendor/william/base/system/InitConfigHandler.php';
require 'vendor/william/base/system/RouterHandler.php';
require 'vendor/william/base/system/RequestHandler.php';
require 'vendor/william/base/system/DbConnectHandler.php';

$request = new Request();
if (!$request->isCli()) {
    (new RequestHandler())->run($request);
}
