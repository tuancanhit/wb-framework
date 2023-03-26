<?php

declare(strict_types=1);

use William\Base\Controller\AbstractControllerInterface;
use William\Base\Controller\AbstractFrontendController;
use William\Base\Controller\RequestInterface;
use William\Base\DependencyResolver;
use William\Base\Exception\RouteNotFoundException;

/**
 * Class RequestHandler
 */
class RequestHandler
{
    /**
     * @param RequestInterface $request
     * @return void
     * @throws Exception
     * @throws Throwable
     */
    public function run(RequestInterface $request)
    {
        try {
            $handler = getRequestHandler($request);
            /** @var AbstractControllerInterface $controller */
            $controller = (new DependencyResolver())->resolve($handler);
            $controller->launch();
        } catch (\Exception|TypeError|Throwable $e) {
            if (config('debug')) {
                throw $e;
            }
            $this->redirectPageNotFound();
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function redirectPageNotFound()
    {
        (new AbstractFrontendController())->launch();
    }
}