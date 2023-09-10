<?php

declare(strict_types=1);

namespace App;

use App\View\Helper\Config;
use App\View\Helper\Factory\ConfigFactory;
use App\View\Helper\MenuHelper;
use App\View\Helper\Factory\MenuHelperFactory;
use Laminas\View;
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
        return [
            'factories' => [
                Kernel::class                          => Factory\KernelFactory::class,
                ServerRequestInterface::class          => Factory\RequestFactory::class,
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
    }
}
