<?php
declare(strict_types=1);

namespace William\Base\Logger;

use Monolog\Level;
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

/**
 * Class BaseLogger
 *
 * @package William\Base\Logger
 */
class BaseLogger
{
    protected $type = 'base';
    protected $path = '/var/log/base.log';

    /**
     * @param string $type
     * @param string $path
     */
    public function __construct()
    {
        $log = new MonoLogger($this->type);
        $log->pushHandler(new StreamHandler($this->getFullPath(), Level::Debug));
        $this->log = $log;
    }

    /**
     * @return string
     */
    protected function getFullPath()
    {
        return sprintf('%s%s', config('root_folder'), $this->path);
    }

    /**
     * @param string $message
     * @return void
     */
    public function debug(string $message, array $context = [])
    {
        $this->log->debug(...func_get_args());
    }

    /**
     * @param string $message
     * @return void
     */
    public function warn(string $message, array $context = [])
    {
        $this->log->warning(...func_get_args());
    }

    /**
     * @param string $message
     * @return void
     */
    public function error(string $message, array $context = [])
    {
        $this->log->error(...func_get_args());
    }
}