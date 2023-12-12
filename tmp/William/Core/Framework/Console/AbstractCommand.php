<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Console;

use William\Core\Api\Framework\Console\CommandInterface;

/**
 * Class AbstractCommand
 *
 * @package William\Core\Framework\Console
 */
abstract class AbstractCommand implements CommandInterface
{
    /**
     * @param array    $argv
     * @param int|null $argc
     * @return void
     */
    public function execute(array $argv = [], $argc = null): void
    {

    }

    /**
     * @param string $argName
     * @param array  $argv
     * @return int|string|mixed
     */
    public function getArgument(string $argName, array $argv)
    {
        $argv = array_map('strtolower', $argv);
        $argv = array_map('trim', $argv);
        foreach ($argv as $arg) {
            if (!str_starts_with($arg, '--')) {
                continue;
            }
            if (str_starts_with($arg, __('--%s=', $argName))) {
                $arg = substr($arg, 2);
                $arg = explode('=', $arg);
                return $arg[1] ?? '';
            }
        }
        return null;
    }
}