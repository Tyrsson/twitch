<?php

declare(strict_types=1);

use App\Kernel;
use Webinertia\Utils\Debug;

chdir(dirname(__DIR__)); // make sure the php process is running from the correct dir

require __DIR__ . '/../vendor/autoload.php'; // this is what allows autoloading to work

//Debug::dump($templateName);

Kernel::init();