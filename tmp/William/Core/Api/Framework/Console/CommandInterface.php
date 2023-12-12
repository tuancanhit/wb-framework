<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Console;

/**
 * Interface CommandInterface
 *
 * @api
 * @package William\Core\Api\Framework\Console
 */
interface CommandInterface
{
    /**
     * @param array    $argv
     * @param int|null $argc
     * @return void
     */
    public function execute(array $argv = [], $argc = null): void;
}