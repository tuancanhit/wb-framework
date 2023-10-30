<?php


use William\Core\Model\Config\SystemConfig;

if (!WB_ROOT) {
    throw new \Exception('Not found root folder location.');
}

// Common
/**
 * @param string $pattern
 * @param        ...$args
 * @return string
 */
function __(string $pattern, ...$args)
{
    return sprintf($pattern, ...$args);
}

/**
 * @param string|mixed $first
 * @param string|mixed $second
 * @return bool
 */
function str_compare($first, $second)
{
    return strtolower(trim($first)) === strtolower(trim($second));
}

// InitConfigHandler

/**
 * @param string $path
 * @param int|string $default
 * @return array|mixed|null
 */
function config(string $path = '', $default = null)
{
    $ins = SystemConfig::getInstance();
    return $ins->getConfig(...func_get_args());
}

/**
 * @param string $path
 * @param string $type
 * @return string
 */
function asset(string $path, string $type)
{
    return sprintf('%s/pub/%s/%s', config('site.base_url'), $type, $path);
}