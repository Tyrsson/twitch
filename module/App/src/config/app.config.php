<?php

declare(strict_types=1);

namespace App;

use Laminas\View;
use Psr\Http\Message\ServerRequestInterface;

return [
    'factories' => [
        Kernel::class                          => Factory\KernelFactory::class,
        ServerRequestInterface::class          => Factory\RequestFactory::class,
        View\Resolver\TemplatePathStack::class => Factory\TemplatePathStackFactory::class,
        View\Renderer\PhpRenderer::class       => Factory\PhpRendererfactory::class,
        View\View::class                       => Factory\ViewFactory::class,
    ],
    'view' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];