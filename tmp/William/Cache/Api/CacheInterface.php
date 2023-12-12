<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Cache\Api;

/**
 * Interface CacheInterface
 *
 * @api
 */
interface CacheInterface
{
    public function get(string $key);

    public function set(string $key, $value);

    public function getCacheVersion(): int;

    public function getCachePrefix(): string;

}