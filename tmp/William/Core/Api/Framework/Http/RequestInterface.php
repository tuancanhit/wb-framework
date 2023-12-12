<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Http;

/**
 * Interface RequestInterface
 *
 * @api
 * @package William\Core\Api\Request
 */
interface RequestInterface
{
    const CLI    = 'CLI';
    const GET    = 'GET';
    const POST   = 'POST';
    const PUT    = 'PUT';
    const DELETE = 'DELETE';

    public function getParam(string $key, $default = null);
    public function getParams();
    public function getMethod();
    public function getRequestPath();
    public function getFullPath();
    public function getScope();
    public function getUserIpAddress();
}