<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;

// we gotta have this so throw require at it
$config = require __DIR__ . '/config.php';

// build container
$serviceManager = new ServiceManager($config);
/**
 * This creates a application service known as config
 * so that within our factories we can do this:
 * $config = $container->get('config');
 * Since merging happens prior to initializing the container, the application factories
 * have access to all configuration at this point, and also, all services.
 * This is like literally the 5th in the callstack, thats pretty darn early
 * */
$serviceManager->setService('config', $config);

// return container
return $serviceManager;
