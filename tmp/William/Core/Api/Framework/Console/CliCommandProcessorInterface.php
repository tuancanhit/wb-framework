<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Console;

/**
 * Interface CliCommandProcessorInterface
 *
 * @api
 * @package William\Core\Api\Framework\Console
 */
interface CliCommandProcessorInterface
{
    /**
     * @return void
     */
    public function run(array $argv = [], $argc = null);
}