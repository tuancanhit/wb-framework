<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Cache\Service;

use Predis\Client;
use William\Cache\Api\CacheInterface;

/**
 * Class AbstractCache
 *
 * @package William\Cache\Service
 */
class AbstractCache implements CacheInterface
{
    protected string $cachePrefix;
    protected int $cacheVersion;

    /**  */
    public function __construct()
    {
        $this->cachePrefix  = config('cache.config.prefix', 'redis');
        $this->cacheVersion = (int)config('cache.config.prefix', 'version');
    }

    /**
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $key
     * @param        $value
     * @return void
     */
    public function set(string $key, $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * @return int
     */
    public function getCacheVersion(): int
    {
        return $this->cacheVersion;
    }

    /**
     * @return string
     */
    public function getCachePrefix(): string
    {
        return $this->cachePrefix;
    }
}