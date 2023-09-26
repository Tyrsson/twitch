<?php

declare(strict_types=1);

use App\MiddlewareFactory;
use App\Handler\HomeHandler;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;

return function ($app, MiddlewareFactory $factory, ContainerInterface $container): void {
    // for future use
    $app->pipe(ErrorHandler::class);
    $app->pipe('/', HomeHandler::class);
};