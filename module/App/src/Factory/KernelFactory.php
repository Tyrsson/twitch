<?php

declare(strict_types=1);

namespace App\Factory;

use App\Kernel;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\View;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class KernelFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Kernel
    {
        return new $requestedName($container->get(ServerRequestInterface::class), $container->get(View::class));
    }
}
