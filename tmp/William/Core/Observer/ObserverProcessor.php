<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Observer;

use William\Core\Api\Observer\ObserverInterface;

/**
 * Class ObserverProcessor
 */
class ObserverProcessor implements ObserverInterface
{
    public function __construct()
    {
    }

    public function dispatch(string $event, array $args = [])
    {
        //todo: implement logic
    }
}