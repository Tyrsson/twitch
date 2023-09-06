<?php

declare(strict_types=1);

namespace App;

class Module
{
    public function getConfig(): array
    {
        $configProvider = new ConfigProvider();
        return [
            'service_manager' => $configProvider->getDependencyConfig(),
        ];
        return include __DIR__ . '/../config/app.config.php';
    }
}