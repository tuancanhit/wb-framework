<?php

namespace William\Base\Controller;

/**
 * Interface RequestInterface
 *
 * @api
 * @package William\Base\Controller
 */
interface RequestInterface
{
    public function getParam(string $key, $default = null);
    public function getParams();
    public function getMethod();
    public function getRequestPath();
}