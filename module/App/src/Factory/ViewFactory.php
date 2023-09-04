<?php

declare(strict_types=1);

namespace App\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\View;
use Laminas\View\ViewEvent;
use Psr\Container\ContainerInterface;

class ViewFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): View
    {
        $renderer = $container->get(PhpRenderer::class); // get an instance that is returned from the PhpRendererFactory
        $view = new $requestedName(); // create a new instance of Laminas\View\View ;)
        $view->getEventManager()->attach(
            ViewEvent::EVENT_RENDERER,
            static function () use ($renderer) {
                return $renderer;
            }
        );
        return $view;
    }
}
