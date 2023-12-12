<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Http;

use William\Core\Api\Framework\Http\ControllerInterface;
use William\Core\Api\Framework\Http\RequestInterface;
use William\Core\Api\Framework\Http\ResponseInterface;
use William\Core\Api\Framework\Middleware\MiddlewareInterface;
use William\Core\Resolver\Dependency;

/**
 * Class AbstractController
 *
 * @package William\Core\Framework\Http
 */
abstract class AbstractController implements ControllerInterface
{
    protected array $middlewares = [];

    /**
     * @param Dependency       $dependency
     * @param RequestInterface $request
     */
    public function __construct(
        protected Dependency $dependency,
        protected RequestInterface $request
    ){}

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function launch(RequestInterface $request): ResponseInterface
    {
        $this->runMiddleware();
        return $this->execute($request);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    abstract public function execute(RequestInterface $request): ResponseInterface;

    /**
     * @param array $middlewares
     * @return ControllerInterface
     */
    public function setMiddleware(array $middlewares): ControllerInterface
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    protected function runMiddleware()
    {
        foreach ($this->middlewares as $middleware) {
            if (!is_subclass_of($middleware, MiddlewareInterface::class)) {
                continue;
            }
            /** @var MiddlewareInterface $middlewareIns */
            $middlewareIns = $this->dependency->resolve($middleware);
            $middlewareIns->execute($this->getRequest());
        }
    }
}