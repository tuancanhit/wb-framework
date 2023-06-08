#!/usr/bin/env php

<?php

use William\Base\Api\CommandInterface;
use William\Base\Controller\Request;
use William\Base\Helper\DependencyResolver;
use William\Base\Helper\ScopeResolver;

$root_folder = __DIR__ . '/../';

require $root_folder . '/vendor/autoload.php';
require $root_folder . '/vendor/william/base/system/InitConfigHandler.php';
require $root_folder . '/vendor/william/base/system/DbConnectHandler.php';

$base_commands = include $root_folder . '/vendor/william/base/src/etc/command.php';
$app_commands  = include $root_folder . '/src/etc/command.php';
$command_list  = array_merge($base_commands, $app_commands);

if ($argc <= 1) {
    print_r($command_list);
    exit();
}

$command = $argv[1] ?? null;
if (!isset($command_list[$command])) {
    echo "Command not found\n";
    exit();
}

$args = [];
if (count($argv) > 2) {
    $args = $argv;
    unset($args[0]);
    unset($args[1]);
    $args = array_map(function ($arg) {
        $arg = strtolower(str_replace(' ', '', $arg));
        $arg = explode('=', $arg);
        if (count($arg) != 2) {
            return [];
        }
        return [trim($arg[0]) => trim($arg[1])];
    }, $args);
    $args = array_merge(...array_filter($args));
}


if (is_callable($command_list[$command])) {
    $command_list[$command]();
    exit();
}
(new ScopeResolver(Request::CLI));

if (!class_exists($command_list[$command])) {
    echo "Command not found\n";
    exit();
}

$handler = (new DependencyResolver())->resolve($command_list[$command]);
if (!$handler instanceof CommandInterface) {
    echo "Command register is incorrect\n";
    exit();
}
if (!empty($args)) {
    $handler->setData($args);
}
$handler->execute();