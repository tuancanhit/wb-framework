<?php
/**
 * Copyright © William, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Base\Framework;

/**
 * Class Boot
 */
class Boot implements \William\Base\Api\Framework\BootInterface
{
    public static $_instance = null;
    protected string $rootDir;
    protected array $args;

    /**
     * @param string $rootDir
     * @param array  $args
     */
    public function __construct(string $rootDir, array $args)
    {
        $this->rootDir = $rootDir;
        $this->args = $args;
        self::$_instance = $this;
    }

    /**
     * @return Boot|null
     * @throws \William\Base\Exception\SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new \William\Base\Exception\SystemInitFailureException('');
        }
        return self::$_instance;
    }

    /**
     * @param string $rootDir
     * @param array  $args
     * @return static
     */
    public static function create(string $rootDir, array $args)
    {
        return new self(...func_get_args());
    }

    /**
     * @return string
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }
}