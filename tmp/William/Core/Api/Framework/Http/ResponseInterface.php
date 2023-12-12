<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Http;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Core\Api\Framework\Http
 */
interface ResponseInterface
{
    public function sendResponse();
}