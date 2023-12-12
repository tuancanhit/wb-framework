<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Console;

/**
 * Interface CliResolverInterface
 *
 * @api
 * @package William\Core\Api\Framework\Console
 */
interface CliResolverInterface
{
    /**
     * @return CommandInterface
     */
    public function get(string $name);
}