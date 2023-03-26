<?php
declare(strict_types=1);

namespace William\Base;

use William\Base\Api\DbConnector;
use William\Base\Api\DbConnectorInterface;
use William\Base\Exception\SystemInitFailureException;

/**
 * Class DBConnectResolver
 *
 * @package William\Base
 */
class DBConnectResolver
{
    /** @var DBConnectResolver|null  */
    private static ?DBConnectResolver $_instance = null;

    /** @var array  */
    private array $configs = [];

    /**
     * @param array $configs
     */
    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
        self::$_instance = $this;
    }

    /**
     * @return DbConnectorInterface
     * @throws SystemInitFailureException
     */
    public function getConnector()
    {
        return new DbConnector($this->configs);
    }

    /**
     * @throws SystemInitFailureException
     */
    public static function getInstance()
    {
        if (null == self::$_instance) {
            throw new SystemInitFailureException('Must init system first');
        }
        return self::$_instance;
    }
}