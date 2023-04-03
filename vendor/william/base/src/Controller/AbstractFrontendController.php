<?php

namespace William\Base\Controller;
use William\Base\Api\PageResponse\Response;
use William\Base\Api\PageResponse\ResponseInterface;
use William\Base\Api\PageResponse\ResponseInterface as PageResponseInterface;
use William\Base\Api\RequestResponse\ResponseInterface as RequestResponseInterface;

class AbstractFrontendController extends AbstractController
{
    /**
     * @return PageResponseInterface|RequestResponseInterface|\William\Base\Block\BlockInterface
     */
    function execute()
    {
        return (new Response())->setVars([])->setTemplate('@app::404.php');
    }
}