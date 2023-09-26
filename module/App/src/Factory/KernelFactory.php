<?php

declare(strict_types=1);

namespace App\Factory;

use App\Kernel;
use App\ApplicationPipeline;
use App\MiddlewareFactoryInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Laminas\Stratigility\MiddlewarePipe;
use Laminas\Stratigility\MiddlewarePipeInterface;
use Laminas\View\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class KernelFactory
{
    public function __invoke(ContainerInterface $container): Kernel
    {
        // return our instance, injected with our initialized dependencies, created by their respective factories
        return new Kernel(
            $container->get(MiddlewareFactoryInterface::class),
            $container->get(ApplicationPipeline::class),
            $container->get(RequestHandlerRunnerInterface::class),
            $container->get('config')
        );
    }
}
