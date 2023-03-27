<?php

namespace William\Base\Model;

use William\Base\Api\DbConnector;
use William\Base\Api\DbConnectorInterface;
use William\Base\Exception\SystemInitFailureException;

/**
 * Class AbstractDb
 *
 * @package William\Base\Model
 */
abstract class AbstractDb extends \William\Base\Model\AbstractInstance
{
    /**
     * @var DbConnector|DbConnectorInterface
     */
    protected ?DbConnector $dbConnector = null;

    /**
     * @var string
     */
    protected string $class = '';

    /**
     * @throws SystemInitFailureException
     */
    public function __construct(array $data)
    {
        if (null == $this->dbConnector) {
            $this->dbConnector = db_connector();
        }
        $this->class = get_class($this);
        parent::__construct($data);
    }

    /**
     * @return string
     */
    public function getMainTable()
    {
        return $this->getData('table');
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getData('primary');
    }
}