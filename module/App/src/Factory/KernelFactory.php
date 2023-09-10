<?php

declare(strict_types=1);

namespace App\Factory;

use App\Kernel;
use Laminas\View\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class KernelFactory
{
    public function __invoke(ContainerInterface $container): Kernel
    {
        // return our instance, injected with our initialized dependencies, created by their respective factories
        return new Kernel(
            $container->get(ServerRequestInterface::class), // calls the RequestFactory
            $container->get(View::class), // calls the View::class factory
            $container->get('config') // remember the 'config' service we created when we built the container, this is its usage
        );
    }
}
