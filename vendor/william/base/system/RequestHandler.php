<?php

declare(strict_types=1);

use William\Base\Controller\AbstractControllerInterface;
use William\Base\Controller\AbstractFrontendController;
use William\Base\Controller\RequestInterface;
use William\Base\Helper\DependencyResolver;
use William\Base\Exception\RouteNotFoundException;

/**
 * Class RequestHandler
 */
class RequestHandler
{
    /** @var DependencyResolver */
    protected DependencyResolver $dependencyResolver;

    public function __construct()
    {
        $this->dependencyResolver = new DependencyResolver();
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws Exception
     * @throws Throwable
     */
    public function run(RequestInterface $request)
    {
        try {
            (new \William\Base\Helper\ScopeResolver($request->getScope()));
            $handler = get_request_handler($request);
            /** @var AbstractControllerInterface $controller */
            $controller = $this->dependencyResolver->resolve($handler);
            $result = $controller->launch();
            if ($result) {
                echo $result;
            }
        } catch (\Exception|TypeError|Throwable $e) {
            if (config('debug')) {
                throw $e;
            }
            $this->redirectPageNotFound($request);
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function redirectPageNotFound(RequestInterface $request)
    {
        if (config('site.notfound')) {
            $this->dependencyResolver->resolve(config('site.notfound'))->launch();
            return;
        }
        (new AbstractFrontendController($request))->launch();
    }
}