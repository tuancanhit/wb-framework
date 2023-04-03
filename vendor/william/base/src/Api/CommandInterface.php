<?php

namespace William\Base\Api;

/**
 * Interface CommandInterface
 *
 * @api
 * @package William\Base\Api
 */
interface CommandInterface
{
    public function execute();
    public function setData($key, $value = null);
    public function getData(string $key = null);
}