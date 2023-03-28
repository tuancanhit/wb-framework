<?php
declare(strict_types=1);

namespace William\Base\Helper;

use William\Base\Exception\SystemInitFailureException;

/**
 * Class ConfigResolver
 */
class ConfigResolver
{
    /** @var ConfigResolver|null  */
    private static ?ConfigResolver $_instance = null;

    /** @var array  */
    private array $configs = [];

    /**
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
        self::$_instance = $this;
    }

    /**
     * @throws SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('Must init system first');
        }
        return self::$_instance;
    }

    /**
     * @param string $path
     * @return array|mixed|null
     */
    public function config(string $path)
    {
        $config = $this->configs;
        foreach (explode('.', $path) as $node) {
            if (!isset($config[$node])) {
                return null;
            } else {
                $config = $config[$node];
            }
        }
        return $config;
    }
}