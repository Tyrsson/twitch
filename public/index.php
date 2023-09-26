<?php

declare(strict_types=1);

use App\Kernel;

chdir(dirname(__DIR__)); // make sure the php process is running from the correct dir

require 'vendor/autoload.php'; // Using the composer autoloader, its pretty much industry standard now

//run app;
(function () {
    // This returns a configured container instance that is aware of all of our service mappings
    $container = require 'config/container.php';
    // This returns us an instance of the Kernel class ready for use
    $app       = $container->get(Kernel::class);
    $factory   = $container->get(\App\MiddlewareFactory::class);
    (require 'config/pipeline.php')($app, $factory, $container);
    $app->run();
})();
