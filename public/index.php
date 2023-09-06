<?php

declare(strict_types=1);

use App\Kernel;

chdir(dirname(__DIR__)); // make sure the php process is running from the correct dir

require 'vendor/autoload.php'; // this is what allows autoloading to work

//run app;
(function () {
    $container = require 'config/container.php';
    $app       = $container->get(Kernel::class);
    $app->run();
})();
