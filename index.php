<?php

use William\Base\Controller\Request;

$root_folder = __DIR__;

require 'vendor/autoload.php';
require 'vendor/william/base/system/InitConfigHandler.php';
require 'vendor/william/base/system/RouterHandler.php';
require 'vendor/william/base/system/RequestHandler.php';
require 'vendor/william/base/system/DbConnectHandler.php';

$request = new Request();
if (!$request->isCli()) {
    (new RequestHandler())->run($request);
}
