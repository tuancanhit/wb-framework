<?php
declare(strict_types=1);

use William\Base\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$configs = require __DIR__ . '/../../../../src/etc/config.php';

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
