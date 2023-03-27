<?php
declare(strict_types=1);

use William\Base\Api\DbConnector;
use William\Base\Api\DbConnectorInterface;
use William\Base\Exception\SystemInitFailureException;

/**
 * @return DbConnector|DbConnectorInterface
 * @throws SystemInitFailureException
 */
function db_connector()
{
    try {
        $connector = DbConnector::getInstance();
    } catch (SystemInitFailureException $e) {
        $connector = (new DbConnector(config('database')));
    }
    return $connector;
}