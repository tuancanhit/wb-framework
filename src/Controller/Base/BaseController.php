<?php

namespace William\Wb\Controller\Base;

use William\Base\Api\PageResponse\ResponseInterface;
use William\Base\Controller\AbstractFrontendController;

/**
 * Class BaseController
 *
 * @package William\Wb\Controller
 */
class BaseController extends AbstractFrontendController
{
    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        return parent::execute();
    }
}