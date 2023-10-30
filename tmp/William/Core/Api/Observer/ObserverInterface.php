<?php
/**
 * Copyright © SmartOSC, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Observer;

/**
 * Interface ObserverInterface
 *
 * @api
 */
interface ObserverInterface
{
    public function dispatch(string $event, array $args = []);
}