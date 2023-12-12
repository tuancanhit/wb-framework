<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Cache\Console;

use William\Cache\Api\Console\FlushRedisCacheCommandInterface;
use William\Cache\Service\RedisCache;
use William\Core\Exception\InputErrorException;
use William\Core\Framework\Console\AbstractCommand;

/**
 * Class FlushRedisCacheCommand
 *
 * @package William\Cache\Api\Console
 */
class FlushRedisCacheCommand extends AbstractCommand implements FlushRedisCacheCommandInterface
{
    public function __construct(protected RedisCache $redisCache)
    {}

    /**
     * @param array    $argv
     * @param int|null $argc
     * @return void
     * @throws InputErrorException
     */
    public function execute(array $argv = [], $argc = null): void
    {
        $cacheKey = $this->getArgument('key', $argv);
        if (!$cacheKey) {
            throw new InputErrorException(__('Cache key is required'));
        }
        $this->redisCache->set($cacheKey, '');
    }
}