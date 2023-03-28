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
class AjaxRenderResponse extends Response
{
    /**
     * @return bool
     */
    public function isAjaxRender(): bool
    {
        return true;
    }
}