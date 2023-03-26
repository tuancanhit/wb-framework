<?php

use William\Base\Controller\Request;

require 'vendor/autoload.php';
require 'vendor/william/base/system/InitConfigHandler.php';
require 'vendor/william/base/system/RequestHandler.php';
require 'vendor/william/base/system/DbConnectHandler.php';

$request = new Request();
if (!$request->isCli()) {
    (new RequestHandler())->run($request);
}
