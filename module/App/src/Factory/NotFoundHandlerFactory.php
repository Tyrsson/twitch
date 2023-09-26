<?php

declare(strict_types=1);

namespace App\Factory;

use App\Handler\NotFoundHandler;
use App\Response\Psr17ResponseFactoryTrait;
use Laminas\View\Renderer\RendererInterface;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

use function array_key_exists;

class NotFoundHandlerFactory
{
    use Psr17ResponseFactoryTrait;

    public function __invoke(ContainerInterface $container): NotFoundHandler
    {
        $config = $container->has('config') ? $container->get('config') : [];
        Assert::isArrayAccessible($config);

        $renderer = $container->has(RendererInterface::class)
            ? $container->get(RendererInterface::class)
            : ($container->has(\Zend\Expressive\Template\TemplateRendererInterface::class)
                ? $container->get(\Zend\Expressive\Template\TemplateRendererInterface::class)
                : null);

        $mezzioConfiguration = $config['mezzio'] ?? [];
        Assert::isMap($mezzioConfiguration);
        $errorHandlerConfig = $mezzioConfiguration['error_handler'] ?? [];

        $template = $errorHandlerConfig['template_404'] ?? NotFoundHandler::TEMPLATE_DEFAULT;
        $layout   = array_key_exists('layout', $errorHandlerConfig)
            ? (string) $errorHandlerConfig['layout']
            : NotFoundHandler::LAYOUT_DEFAULT;

        $responseFactory = $this->detectResponseFactory($container);

        return new NotFoundHandler(
            $responseFactory,
            $renderer,
            $template,
            $layout
        );
    }
}
