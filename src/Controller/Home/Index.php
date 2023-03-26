<?php

namespace William\Wb\Controller\Home;

use William\Base\Api\PageResponse\ResponseInterface;
use William\Base\Controller\AbstractFrontendController;
use William\Base\Controller\Request;
use William\Base\Controller\RequestInterface;
use William\Base\Model\Product;

/**
 * Class Index
 *
 * @package William\Wb\Home
 */
class Index extends AbstractFrontendController
{
    /**
     * @param RequestInterface|null $request
     * @return ResponseInterface
     */
    function execute(RequestInterface $request = null): ResponseInterface
    {
        echo "<pre>";
        print_r([1]);
        die;
    }
}