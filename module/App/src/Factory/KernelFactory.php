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
        return new Kernel(
            $container->get(ServerRequestInterface::class),
            $container->get(View::class),
            $container->get('config')
        );
    }
}
