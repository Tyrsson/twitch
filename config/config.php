<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

/**
 * This is VERY important.
 * The reason is that the service manager expects certain keys to be present at certain levels
 * by doing this as we are we do not have to key juggle, nor do we have to add a new method just to return a
 * specific key of the array. Its just simpler.
 */
$configProvider = new App\ConfigProvider();

$aggregator = new ConfigAggregator([
    \Laminas\HttpHandlerRunner\ConfigProvider::class,
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
    new PhpFileProvider(realpath(__DIR__) . '/autoload/{{,*.}global,{,*.}local}.php'),
    // we want runtime settings that intersect config options to override so they are honored after merge
    new PhpFileProvider(realpath(__DIR__ . '/../') . '/data/app/settings/{,*}.php'),
    // Load development config if it exists
    new PhpFileProvider(realpath(__DIR__) . '/development.config.php'),
]);
// return the merged config
return $aggregator->getMergedConfig();
