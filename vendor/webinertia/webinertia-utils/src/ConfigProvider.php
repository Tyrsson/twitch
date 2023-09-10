<?php

declare(strict_types=1);

namespace Webinertia\Utils;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Webinertia\Utils\Debug;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * Return application-level dependency configuration
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases'   => [
                'Debug' => Debug::class,
            ],
            'factories' => [
                Debug::class             => InvokableFactory::class,
                Diagnostics\Timer::class => Diagnostics\TimerFactory::class,
            ],
        ];
    }
}
