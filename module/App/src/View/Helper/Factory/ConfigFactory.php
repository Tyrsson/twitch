<?php

declare(strict_types=1);

namespace App\View\Helper\Factory;

use App\View\Helper\Config;
use Psr\Container\ContainerInterface;

final class ConfigFactory
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
    ): Config {
        return new Config($container->get('config'));
    }
}
