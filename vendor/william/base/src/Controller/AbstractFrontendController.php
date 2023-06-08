<?php

namespace William\Base\Controller;

use William\Base\Api\PageResponse\Response;
use William\Base\Api\PageResponse\ResponseInterface;
use William\Base\Api\PageResponse\ResponseInterface as PageResponseInterface;
use William\Base\Api\RequestResponse\ResponseInterface as RequestResponseInterface;

/**
 * Class AbstractFrontendController
 *
 * @package William\Base\Controller
 */
class AbstractFrontendController extends AbstractController
{
    /**
     * @param array $events
     * @return void
     */
    protected function beforeExecute(array $events = [])
    {
        $events = [
            'abstract_fronend_controller_before_execute'
        ];
        parent::beforeExecute($events);
    }

    /**
     * @param array $events
     * @return void
     */
    protected function afterExecute(array $events = [])
    {
        $events = [
            'abstract_fronend_controller_after_execute'
        ];
        parent::beforeExecute($events);
    }

    /**
     * @return PageResponseInterface|RequestResponseInterface|\William\Base\Block\BlockInterface
     */
    function execute()
    {
        return (new Response())->setVars([])->setTemplate('@app::404.php');
    }
}