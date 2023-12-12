<?php
/**
 * Copyright © Will, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace William\Core\Api\Framework\Http;

use William\Core\Framework\Http\AbstractController;

/**
 * Interface ControllerInterface
 *
 * @api
 * @package William\Core\Api\Framework\Http
 */
interface ControllerInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function launch(RequestInterface $request): ResponseInterface;

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function execute(RequestInterface $request): ResponseInterface;

    /**
     * @return RequestInterface
     * @throws \ReflectionException
     */
    public function getRequest(): RequestInterface;

    /**
     * @param array $middlewares
     * @return ControllerInterface
     */
    public function setMiddleware(array $middlewares): ControllerInterface;
}