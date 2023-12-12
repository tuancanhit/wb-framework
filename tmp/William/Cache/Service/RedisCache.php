<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Cache\Service;

use Predis\Client;
use Predis\Response\Status;
use William\Core\Model\DataObject;

/**
 * Class RedisCache
 */
class RedisCache extends AbstractCache
{
    /**
     * @param Client $redis
     */
    public function __construct(protected Client $redis)
    {
        parent::__construct();
        $this->redis = new Client([
            'scheme' => config('cache.config.scheme', 'tcp'),
            'host'   => config('cache.config.host', 'localhost'),
            'port'   => config('cache.config.port', '6379'),
        ]);
    }

    /**
     * @return string
     */
    public function getCachePrefix(): string
    {
        return $this->cachePrefix;
    }

    /**
     * @return int
     */
    public function getCacheVersion(): int
    {
        return $this->cacheVersion;
    }

    /**
     * @param string $key
     * @return string
     */
    public function get(string $key)
    {
        $key = sprintf('%s_%s_%s', $this->getCachePrefix(), $key, $this->getCacheVersion());
        return $this->redis->get($key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return Status
     */
    public function set(string $key, mixed $value)
    {
        $key = sprintf('%s_%s_%s', $this->getCachePrefix(), $key, $this->getCacheVersion());
        if (is_array($value)) {
            $value = json_encode($value);
        }
        if ($value instanceof DataObject) {
            $value = $value->toJson();
        }
        return $this->redis->set($key, $value);
    }
}