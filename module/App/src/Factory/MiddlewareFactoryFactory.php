<?php

declare(strict_types=1);

namespace App\Factory;

use App\MiddlewareContainer;
use App\MiddlewareFactory;
use App\MiddlewareFactoryInterface;
use Psr\Container\ContainerInterface;

class MiddlewareFactoryFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareFactoryInterface
    {
        return new MiddlewareFactory(
            $container->get(MiddlewareContainer::class)
        );
    }
}
