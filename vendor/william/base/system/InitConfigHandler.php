<?php
declare(strict_types=1);

use William\Base\Helper\ConfigResolver;
use William\Base\Controller\RequestInterface;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Exception\SystemInitFailureException;

$app_configs  = require $root_folder . '/src/etc/config.php';
$base_configs = require $root_folder . '/vendor/william/base/src/etc/config.php';
$tmpl_configs = require $root_folder . '/src/etc/tmpl.php';

$configs = array_merge($base_configs, $app_configs, ['tmpl' => $tmpl_configs], ['root_folder' => $root_folder]);

function config(string $path = '')
{
    global $configs;
    try {
        $connector = ConfigResolver::getInstance();
    } catch (SystemInitFailureException $e) {
        $connector = (new ConfigResolver($configs));
    }
    return $connector->config($path);
}

function urlBuild(string $route)
{
    global $configs;
    if ($route[0] == '/') {
        $route = ltrim($route, $route[0]);
    }
    $baseUrl = $configs['site']['base_url'] ?? '/';
    if ($baseUrl[strlen($baseUrl) - 1] != '/') {
        $baseUrl = sprintf('%s/', $baseUrl);
    }
    return sprintf('%s%s', $baseUrl, $route);
}