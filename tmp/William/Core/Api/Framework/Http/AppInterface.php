<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Http;

/**
 * Interface AppInterface
 *
 * @api
 * @package William\Core\Api\Framework\Http
 */
interface AppInterface
{
    /**
     * @param RequestInterface|null $request
     * @return void
     */
    public function run(RequestInterface $request = null);
}