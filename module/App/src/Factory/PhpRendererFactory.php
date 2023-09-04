<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\TemplatePathStack; // we need this so we can use ::class to resolve the name
use Psr\Container\ContainerInterface;

class PhpRendererFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): PhpRenderer
    {
        /**
         * TemplatePathStack::class is how the service manager knows which service we are trying to get an instance of
         */
        return (new $requestedName())->setResolver($container->get(TemplatePathStack::class));
    }

}
