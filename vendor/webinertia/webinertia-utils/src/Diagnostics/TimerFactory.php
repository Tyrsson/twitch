<?php

declare(strict_types=1);

namespace Webinertia\Utils\Diagnostics;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Webinertia\Utils\Diagnostics\Timer;

class TimerFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Timer
    {
        return new $requestedName(
            $container->get(LoggerInterface::class),
            $container->get('config')['diagnostic_settings']
        );
    }
}
