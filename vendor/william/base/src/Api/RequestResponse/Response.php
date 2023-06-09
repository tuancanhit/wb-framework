<?php
declare(strict_types=1);

namespace William\Base\Api\RequestResponse;

use William\Base\Model\AbstractInstance;

/**
 * Interface ResponseInterface
 *
 * @api
 * @package William\Base\Api\RequestResponse
 */
class Response extends AbstractInstance implements ResponseInterface
{
    /**
     * @return bool
     */
    public function isAjaxRender(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function makeResponse()
    {
        if ($this->isAjaxRender()) {
            return $this->toJson();
        }
        return $this->getData();
    }
}