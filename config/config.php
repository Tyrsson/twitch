<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$configProvider = new App\ConfigProvider();
$aggregator = new ConfigAggregator([
    // Default App module config
    //App\ConfigProvider::class,
    new ArrayProvider($configProvider->getDependencyConfig()),
    // Load application config in a pre-defined order in such a way that local settings
    // overwrite global settings. (Loaded as first to last):
    //   - `global.php`
    //   - `*.global.php`
    //   - `local.php`
    //   - `*.local.php`
    /**
     * include the settings files from /data/app. They are stored there because they will be modified
     * loading in this order allows for any development mode settings to override them
     * without having to change the base values
     */
    new PhpFileProvider(realpath(__DIR__ . '/../') . '/data/app/settings/{,*}.php'),
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
]);

return $aggregator->getMergedConfig();
