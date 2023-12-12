<?php

return [
    \William\Core\Api\Observer\ObserverInterface::class => William\Core\Observer\ObserverProcessor::class,
    \William\Core\Api\Framework\Http\RequestInterface::class => William\Core\Framework\Http\Request::class,
    \William\Core\Api\Framework\Http\ResponseInterface::class => William\Core\Framework\Http\Response::class,
    \William\Core\Api\Framework\Console\CliResolverInterface::class => \William\Core\Framework\Console\CliResolver::class,
];