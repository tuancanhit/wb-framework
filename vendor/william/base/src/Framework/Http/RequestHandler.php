<?php

declare(strict_types=1);

namespace William\Base\Framework\Http;

use William\Base\Controller\AbstractControllerInterface;
use William\Base\Controller\AbstractFrontendController;
use William\Base\Controller\RequestInterface;
use William\Base\Helper\DependencyResolver;
use William\Base\Exception\RouteNotFoundException;
use William\Base\Model\AbstractInstance;

/**
 * Class RequestHandler
 */
class RequestHandler extends AbstractInstance
{
    /** @var DependencyResolver */
    protected DependencyResolver $dependencyResolver;

    public function __construct(array $data = [])
    {
        $this->dependencyResolver = new DependencyResolver();
        parent::__construct($data);
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
            echo $controller->launch();
        } catch (\Exception|TypeError|Throwable $e) {
            if (config('debug')) {
                throw $e;
            }
            echo $this->returnError($request);
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function returnError(RequestInterface $request)
    {
        if (config('site.notfound')) {
            return $this->dependencyResolver->resolve(config('site.notfound'))->launch();
        }
        return (new AbstractFrontendController($request))->launch();
    }
}