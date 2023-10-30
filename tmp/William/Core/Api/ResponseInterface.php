<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api;

/**
 * Interface RequestInterface
 *
 * @api
 */
interface ResponseInterface
{
    public function toResponse();
}