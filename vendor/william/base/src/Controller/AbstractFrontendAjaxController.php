<?php

namespace William\Base\Controller;
use William\Base\Api\RequestResponse\Response;
use William\Base\Api\RequestResponse\ResponseInterface;
use William\Base\Controller\AbstractController;
use William\Base\Controller\RequestInterface;

class AbstractFrontendAjaxController extends AbstractController
{
    /**
     * @return void
     */
    function execute(): ResponseInterface
    {
        return (new Response());
    }
}