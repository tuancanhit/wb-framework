<?php
declare(strict_types=1);

namespace William\Base\Api;

/**
 * Interface DbConnectorInterface
 *
 * @api
 * @package William\Base\Api
 */
interface DbConnectorInterface
{
    public function query(string $query);
    public function fetchAssoc(string $query);
    public function getConnect(): \mysqli;
}