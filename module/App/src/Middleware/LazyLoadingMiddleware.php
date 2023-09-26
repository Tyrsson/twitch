<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\InvalidMiddlewareException;
use App\MiddlewareContainer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LazyLoadingMiddleware implements MiddlewareInterface
{
    public function __construct(private MiddlewareContainer $container, public readonly string $middlewareName)
    {
    }

    /**
     * @throws InvalidMiddlewareException For invalid middleware types pulled
     *     from the container.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->container->get($this->middlewareName)->process($request, $handler);
    }
}