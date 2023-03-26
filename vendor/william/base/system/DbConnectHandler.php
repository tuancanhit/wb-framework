<?php
declare(strict_types=1);

use William\Base\Api\DbConnector;
use William\Base\Api\DbConnectorInterface;
use William\Base\DBConnectResolver;
use William\Base\Exception\SystemInitFailureException;

/**
 * @return DbConnector|DbConnectorInterface
 * @throws SystemInitFailureException
 */
function dbConnector()
{
    $dbConfigs = config('database');
    try {
        $connector = DBConnectResolver::getInstance();
    } catch (SystemInitFailureException $e) {
        $connector = (new DBConnectResolver($dbConfigs));
    }
    return $connector;
}