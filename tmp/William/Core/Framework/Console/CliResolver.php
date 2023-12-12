<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Console;

use ReflectionException;
use William\Core\Api\Framework\Console\CliResolverInterface;
use William\Core\Api\Framework\Console\CommandInterface;
use William\Core\Exception\CommandNotFoundException;
use William\Core\Resolver\Dependency;
use William\Core\Resolver\GlobalRequire;

/**
 * Class CliResolver
 *
 * @package William\Core\Framework\Console
 */
class CliResolver implements CliResolverInterface
{
    protected array $cliCommands = [];
    protected ?Dependency $DIResolver = null;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->DIResolver = Dependency::getInstance();
        $this->cliCommands = GlobalRequire::getInstance()
            ->setIdentifier('cli')
            ->execute();
    }

    /**
     * @param string $name
     * @return CommandInterface
     * @throws CommandNotFoundException|ReflectionException
     */
    public function get(string $name)
    {
        $name = $name ? trim($name) : '';
        if (empty($this->cliCommands[$name])) {
            throw new CommandNotFoundException(__('Command "%s" not found', $name));
        }
        $command = $this->DIResolver->resolve($this->cliCommands[$name]);
        if (!$command instanceof CommandInterface) {
            throw new CommandNotFoundException(__('Command must implement \William\Core\Api\Framework\Console\CommandInterface.'));
        }
        return $command;
    }
}