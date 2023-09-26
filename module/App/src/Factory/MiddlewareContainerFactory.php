<?php

declare(strict_types=1);

namespace App\Factory;

use App\MiddlewareContainer;
use Psr\Container\ContainerInterface;

class MiddlewareContainerFactory
{
    public function __invoke(ContainerInterface $container): MiddlewareContainer
    {
        return new MiddlewareContainer($container);
    }
}
