<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class HomeHandler implements RequestHandlerInterface
{
    /**
     * This needs a constructor with the renderer injected
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new HtmlResponse('<div>This is working</div>');
    }

}
