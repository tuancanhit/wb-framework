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
    /**
     * @param array $keys
     * @return string
     */
    public function toJson(array $keys = []);

    /**
     * @return bool
     */
    public function isAjaxRender():bool;

    /**
     * @return string
     */
    public function makeResponse();
}