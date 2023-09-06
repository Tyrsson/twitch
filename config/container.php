<?php

declare(strict_types=1);

use Laminas\ServiceManager\ServiceManager;

$config = require __DIR__ . '/config.php';

// build container
$serviceManager = new ServiceManager($config);
$serviceManager->setService('config', $config);

// return container
return $serviceManager;
