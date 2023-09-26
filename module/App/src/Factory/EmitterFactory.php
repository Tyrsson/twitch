<?php

/**
 * Credit Mezzio Team
 */

declare(strict_types=1);

namespace App\Factory;

use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\EmitterStack;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Container\ContainerInterface;

class EmitterFactory
{
    public function __invoke(ContainerInterface $container): EmitterInterface
    {
        $stack = new EmitterStack();
        $stack->push(new SapiEmitter());
        return $stack;
    }
}
