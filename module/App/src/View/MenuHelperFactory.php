<?php

declare(strict_types=1);

namespace App\View;

use Laminas\Escaper\Escaper;
use Laminas\View\HelperPluginManager;
use Laminas\View\HtmlAttributesSet;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MenuHelperFactory
{
    public function __invoke(ContainerInterface $container): MenuHelper
    {
        $manager = $container->get(HelperPluginManager::class);
        return new MenuHelper(
            $container->get(ServerRequestInterface::class),
            new HtmlAttributesSet(new Escaper()),
            $container->get('config')
        );
    }
}
