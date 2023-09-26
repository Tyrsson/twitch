<?php

declare(strict_types=1);

namespace App;

use App\ApplicationPipeline;
use App\MiddlewareContainer;
use App\Factory\MiddlewareContainerFactory;
use App\MiddlewareFactory;
use App\MiddlewareFactoryInterface;
use App\View\Helper\Config;
use App\View\Helper\Factory\ConfigFactory;
use App\View\Helper\MenuHelper;
use App\View\Helper\Factory\MenuHelperFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Laminas\Stratigility\MiddlewarePipe;
use Laminas\View;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }
    public function getDependencyConfig(): array
    {
        // phpcs:disable Generic.Files.LineLength.TooLong
        return [
            'aliases'   => [
                RequestHandlerRunnerInterface::class => RequestHandlerRunner::class,
                MiddlewareFactoryInterface::class    => MiddlewareFactory::class,
            ],
            'factories' => [
                'App\ApplicationPipeline' => function(): MiddlewarePipe {
                    return new MiddlewarePipe();
                },
                EmitterInterface::class                => Factory\EmitterFactory::class,
                ErrorHandler::class                    => Factory\ErrorHandlerFactory::class,
                Kernel::class                          => Factory\KernelFactory::class,
                Handler\NotFoundHandler::class         => Factory\NotFoundHandlerFactory::class,
                MiddlewareContainer::class             => Factory\MiddlewareContainerFactory::class,
                MiddlewareFactory::class               => Factory\MiddlewareFactoryFactory::class,
                Middleware\ErrorResponseGenerator::class => Factory\ErrorResponseGeneratorFactory::class,
                RequestHandlerRunner::class            => Factory\RequestHandlerRunnerFactory::class,
                ResponseInterface::class               => Factory\ResponseFactoryFactory::class,
                Response\ServerRequestErrorResponseGenerator::class => Factory\ServerRequestErrorResponseGeneratorFactory::class,
                ServerRequestInterface::class          => Factory\ServerRequestFactoryFactory::class,
                View\HelperPluginManager::class        => Factory\HelperPluginManagerFactory::class,
                View\Resolver\TemplatePathStack::class => Factory\TemplatePathStackFactory::class,
                View\Renderer\PhpRenderer::class       => Factory\PhpRendererfactory::class,
                View\View::class                       => Factory\ViewFactory::class,
            ],
            'view_helpers' => [
                'aliases'   => [
                    'config'          => Config::class,
                    'menu'            => MenuHelper::class,
                ],
                'factories' => [
                    Config::class     => ConfigFactory::class,
                    MenuHelper::class => MenuHelperFactory::class,
                ],
            ],
            'view_manager' => [
                'base_path'                => '/',
                'display_not_found_reason' => true,
                'display_exceptions'       => true,
                'doctype'                  => 'HTML5',
                'default_template_suffix'  => 'phtml', // this can be set to php, tpl etc
                'not_found_template'       => 'error/404',
                'exception_template'       => 'error/index',
                'template_path_stack' => [
                    __DIR__ . '/../view',
                ],
            ],
        ];
        // phpcs:enable Generic.Files.LineLength.TooLong
    }
}
