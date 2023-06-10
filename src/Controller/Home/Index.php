<?php

namespace William\Wb\Controller\Home;

use William\Base\Api\PageResponse\Response;
use William\Base\Controller\AbstractFrontendController;
use William\Base\Controller\Request;

/**
 * Class Index
 *
 * @package William\Wb\Home
 */
class Index extends AbstractFrontendController
{
    public function __construct
    (
        Request $request
    )
    {
        parent::__construct($request);
    }

    /**
     * @return Response
     */
    public function execute()
    {
        return (new Response())->setVars([])->setTemplate('@app::base.php');
    }
}