<?php

namespace William\Base\Command\Config;

use William\Base\Api\CommandInterface;
use William\Base\Model\AbstractInstance;

/**
 * Class ConfigInfo
 *
 * @package William\Base\Command
 */
class ConfigInfo extends AbstractInstance implements CommandInterface
{
    /**
     * @return void
     */
    public function execute()
    {
        print_r(config());
    }
}