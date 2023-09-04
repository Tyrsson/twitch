<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Resolver\TemplatePathStack;
use Psr\Container\ContainerInterface;

class TemplatePathStackFactory implements FactoryInterface
{
    private const SCRIPT_PATHS = ['script_paths' => [__DIR__ . '/../view']];

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): TemplatePathStack
    {
        $config = $container->get('config');
        // $requestedName = TemplatePathStack::class
        return new $requestedName(self::SCRIPT_PATHS);
    }
}
