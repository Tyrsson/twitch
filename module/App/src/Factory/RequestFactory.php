<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\UriFactory;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RequestFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ServerRequest
    {
        $request = ServerRequestFactory::fromGlobals();
        $request = $request->withAttribute(
            'uri',
            UriFactory::createFromSapi($request->getServerParams(), $request->getHeaders())
        );
        return $request;
    }
}