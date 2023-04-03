<?php

use William\Base\Controller\Request;

$root_folder = __DIR__;

try {
    require 'vendor/autoload.php';
} catch (\Exception $e) {
    echo <<<HTML
        <div style="font:12px/1.35em arial, helvetica, sans-serif;">
            <div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
                <h3 style="margin:0;font-size:1.7em;font-weight:normal;text-transform:none;text-align:left;color:#2f2f2f;">
                Autoload error</h3>
            </div>
            <p>{$e->getMessage()}</p>
        </div>
        HTML;
    exit(1);
}

require $root_folder . '/vendor/william/base/system/InitConfigHandler.php';
require $root_folder . '/vendor/william/base/system/RouterHandler.php';
require $root_folder . '/vendor/william/base/system/RequestHandler.php';
require $root_folder . '/vendor/william/base/system/DbConnectHandler.php';
require $root_folder . '/vendor/william/base/src/etc/events.php';
require $root_folder . '/src/etc/events.php';

$request = new Request();
if (!$request->isCli()) {
    (new RequestHandler())->run($request);
}
