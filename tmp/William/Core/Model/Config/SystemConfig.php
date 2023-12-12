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
    protected static $instance = null;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->configs = GlobalRequire::getInstance()->setIdentifier('config')->execute('');
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
    public function getConfig(string $path = '', $default = null)
    {
        if (!$path) {
            return self::getInstance()->getData();
        }
        $path = str_replace('.', '/', $path);
        $config = self::getInstance()->getDataByPath($path);
        if (null == $config) {
            return $default;
        }
        return $config;
    }
}