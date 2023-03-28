<?php

namespace William\Base\Controller;
use William\Base\Api\PageResponse\Response;
use William\Base\Api\PageResponse\ResponseInterface;

class AbstractFrontendController extends AbstractController
{
    /** @var string  */
    protected string $scope = \William\Base\Controller\AbstractControllerInterface::FRONT;

    /**
     * @return void
     */
    function execute(): ResponseInterface
    {
        return (new Response())->setVars([])->setTemplate('@app::404.php');
    }
}