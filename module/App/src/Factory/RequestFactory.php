<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RequestFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ServerRequest
    {
        $factory = new ServerRequestFactory();
        return $factory::fromGlobals();
    }
}