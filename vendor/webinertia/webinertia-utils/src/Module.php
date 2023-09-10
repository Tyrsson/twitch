<?php

declare(strict_types=1);

namespace Webinertia\Utils;

use Webinertia\Utils\ConfigProvider;

class Module
{
    /**
     * Return webinertia-modulemanager configuration for laminas-mvc application.
     *
     * @return array
     */
    public function getConfig()
    {
        return [
            'diagnostic_settings' => [
                'log_execution_time'  => true,
                'enable_firebug'      => true,
                'enable_db_profiling' => true,
            ],
            'listeners'           => [
                Diagnostics\Timer::class,
            ],
            'service_manager'     => (new ConfigProvider())->getDependencyConfig(),
        ];
    }
}
