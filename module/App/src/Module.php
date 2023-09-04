<?php

declare(strict_types=1);

namespace App;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/config/app.config.php';
    }
}