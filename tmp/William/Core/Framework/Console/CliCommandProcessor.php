<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Console;

use William\Core\Api\Framework\Console\CliCommandProcessorInterface;
use William\Core\Api\Framework\Console\CliResolverInterface;
use William\Core\Model\DataObject;
use William\Core\Resolver\Dependency;

/**
 * Class CliCommandProcessor
 *
 * @package William\Core\Framework\Console
 */
class CliCommandProcessor extends DataObject implements CliCommandProcessorInterface
{
    protected ?CliResolverInterface $cliResolver;

    /**
     * @param array $data
     * @throws \ReflectionException
     */
    public function __construct(array $data = []) {
        $this->cliResolver = Dependency::getInstance()->resolve(CliResolverInterface::class);
        parent::__construct($data);
    }

    /**
     * @param array    $argv
     * @param int|null $argc
     * @return void
     */
    public function run(array $argv = [], $argc = null): void
    {
        $cliName = $argv[1] ?? '';
        $command = $this->cliResolver->get($cliName);
        $command->execute($argv, $argc);
    }
}