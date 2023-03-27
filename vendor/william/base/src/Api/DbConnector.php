<?php
declare(strict_types=1);

namespace William\Base\Api;

use William\Base\Exception\SystemInitFailureException;

/**
 * Class DbConnector
 *
 * @package William\Base\Api
 */
class DbConnector implements DbConnectorInterface
{
    /** @var \mysqli|null  */
    private ?\mysqli $connect;

    /** @var DbConnector|null  */
    private static ?DbConnector $_instance = null;

    /**
     * @throws SystemInitFailureException
     */
    public function __construct(array $configs)
    {
        $this->connect = new \mysqli(
            sprintf('%s:%s', $configs['host'], $configs['port']),
            $configs['username'],
            $configs['password'],
            $configs['dbname']
        );
        if ($this->connect->connect_error) {
            throw new SystemInitFailureException('Can not connect mysql');
        }
        self::$_instance = $this;
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

    /**
     * @return \mysqli
     */
    public function getConnect(): \mysqli
    {
        return $this->connect;
    }

    /**
     * @param string $query
     * @return bool|\mysqli_result
     * @throws \Exception
     */
    public function query(string $query)
    {
        $result = $this->connect->query(...func_get_args());
        if (!$result) {
            throw new \Exception($this->connect->error);
        }
        return $result;
    }

    /**
     * @param string $query
     * @return array|false|null
     * @throws \Exception
     */
    public function fetchAssoc(string $query)
    {
        return $this->query(...func_get_args())->fetch_assoc();
    }
}