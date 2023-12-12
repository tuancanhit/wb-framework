<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Framework\Http;

use Monolog\Logger;
use William\Core\Api\Framework\Http\AppInterface;
use William\Core\Api\Framework\Http\RequestInterface;
use William\Core\Api\Observer\ObserverInterface;
use William\Core\Logger\System;
use William\Core\Model\DataObject;
use William\Core\Resolver\Dependency;
use William\Core\Resolver\Router;

/**
 * Class App
 *
 * @package William\Core\Framework\Http
 */
class App extends DataObject implements AppInterface
{
    protected Dependency $DIResolver;

    protected RequestInterface $request;

    protected Router $routerResolver;

    protected ObserverInterface $observer;

    protected Logger $logger;

    /**
     * @param ...$args
     * @return void
     * @throws \ReflectionException
     */
    protected function afterConstruct(...$args)
    {
        $this->DIResolver     = Dependency::getInstance();
        $this->request        = $this->DIResolver->resolve(RequestInterface::class);
        $this->routerResolver = $this->DIResolver->resolve(Router::class);
        $this->observer       = $this->DIResolver->resolve(ObserverInterface::class);
        $this->logger         = $this->DIResolver->resolve(System::class);
    }

    /**
     * @param RequestInterface|null $request
     * @return void
     * @throws \Throwable
     */
    public function run(RequestInterface $request = null)
    {
        $request = $request ?: $this->request;
        try {
            $this->launch($request);
        } catch (\Exception | \Throwable $e) {
            $errorCode = $this->handleException($e);
            if (config('debug')) {
                throw $e;
            }
            $this->error($request, $errorCode);
        }
    }

    /**
     * @param RequestInterface $request
     * @return void
     * @throws \Exception
     */
    protected function launch(RequestInterface $request)
    {
        $this->observer->dispatch('before_launch', ['object' => $this, 'request' => $request]);
        $response = $this->routerResolver->resolve($request);
        $response->sendResponse();
        $this->observer->dispatch('after_launch', ['object' => $this, 'request' => $request]);
    }

    /**
     * @param RequestInterface $request
     * @param string           $errorCode
     * @return void
     */
    protected function error(RequestInterface $request, string $errorCode)
    {
        echo 'Something when wrong, please contact with admin';
        echo "<br>";
        echo sprintf('Error code: %s', $errorCode);
        echo "<br>";
    }

    /**
     * @param \Exception $e
     * @return string
     */
    protected function handleException($e)
    {
        $code = sprintf('%s%s%s', microtime(true), rand(100000, 1000000000), (int)$e->getCode());
        $code = str_replace('.', '', $code);
        $this->logger->error(sprintf('%s: %s', $code, $e->getMessage()), $e->getTrace());
        return $code;
    }
}