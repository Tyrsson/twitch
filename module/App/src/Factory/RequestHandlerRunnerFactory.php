<?php

declare(strict_types=1);

namespace App\Factory;

use App\ApplicationPipeline;
use App\Response\ServerRequestErrorResponseGenerator;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RequestHandlerRunnerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerRunner
    {
        return new RequestHandlerRunner(
            $container->get(ApplicationPipeline::class),
            $container->get(EmitterInterface::class),
            $container->get(ServerRequestInterface::class),
            $container->get(ServerRequestErrorResponseGenerator::class)
        );
    }
}
