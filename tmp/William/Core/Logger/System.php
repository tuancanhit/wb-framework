<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Logger;

use DateTimeZone;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class System
 */
class System extends Logger
{
    /**
     * @param string            $name
     * @param array             $handlers
     * @param array             $processors
     * @param DateTimeZone|null $timezone
     */
    public function __construct(string $name = 'system', array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct($name, $handlers, $processors, $timezone);
        $this->pushHandler(new StreamHandler('var/log/system.log', Logger::ERROR));
    }
}