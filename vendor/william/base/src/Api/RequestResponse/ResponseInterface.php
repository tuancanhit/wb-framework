<?php
declare(strict_types=1);

namespace William\Base\Api\RequestResponse;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Base\Api\RequestResponse
 */
interface ResponseInterface
{
    public function toJson(array $keys = []);
}