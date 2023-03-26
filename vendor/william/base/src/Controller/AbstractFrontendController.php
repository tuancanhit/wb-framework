<?php

namespace William\Base\Controller;
use William\Base\Api\PageResponse\Response;
use William\Base\Api\PageResponse\ResponseInterface;

class AbstractFrontendController extends AbstractController
{
    /** @var string  */
    protected string $scope = 'Frontend';

    /**
     * @return void
     */
    function execute(): ResponseInterface
    {
        return (new Response())->setVars([])->setTemplate('404.php');
    }
}