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
        'doctype'             => 'HTML5',
    ],
];