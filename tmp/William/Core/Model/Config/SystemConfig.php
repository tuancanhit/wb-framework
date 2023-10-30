<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Model\Config;

use William\Core\Resolver\GlobalRequire;
use William\Core\Model\DataObject;

/**
 * Class SystemConfig
 */
class SystemConfig extends DataObject
{
    protected array $configs = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->configs = GlobalRequire::getInstance()->execute(
            '/vendor/william/*/etc/config.php',
            '/package/*/etc/config.php'
        );
        parent::__construct(array_merge($this->configs, $data));
    }

    /**
     * @return $this
     */
    public static function getInstance(...$args)
    {
        if (null == self::$instance) {
            self::$instance = new self(...$args);
        }
        return self::$instance;
    }

    /**
     * @param string $path
     * @param mixed  $default
     * @return int|string|null
     */
    public function getConfig(string $path, $default = null)
    {
        $path = str_replace('.', '/', $path);
        $config = self::getInstance()->getDataByPath($path);
        if (null == $config) {
            return $default;
        }
        return $config;
    }
}