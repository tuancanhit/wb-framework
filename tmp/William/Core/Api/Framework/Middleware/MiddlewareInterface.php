<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Middleware;

use William\Core\Api\Framework\Http\RequestInterface;

/**
 * Interface MiddlewareInterface
 *
 * @api
 */
interface MiddlewareInterface
{
    public function execute(RequestInterface $request);
}