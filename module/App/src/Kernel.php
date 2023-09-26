<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\HttpHandlerRunner\RequestHandlerRunnerInterface;
use Laminas\Stratigility\MiddlewarePipeInterface;
use Laminas\View\Model\ModelInterface;
use Laminas\View\View;
use Laminas\View\Model\ViewModel;
use Mezzio\Router\Route;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webinertia\Utils\Debug;

use function in_array;
use function Laminas\Stratigility\path;
use function strlen;
use function substr;

class Kernel
{
    private const USER_PARAM_KEY = 'user';
    public const  REQUESTED_USER = 'requestedUser';
    private array $queryParams;

    public function __construct(
        private MiddlewareFactoryInterface $factory,
        private MiddlewarePipeInterface $pipeline,
        private RequestHandlerRunnerInterface $runner,
        private array $config
    ) {
        // $this->request = $this->request->withHeader('X-Requested-With', 'XMLHttpRequest');
        // $this->queryParams = $this->request->getQueryParams();
        // if (
        //     isset($this->queryParams[self::USER_PARAM_KEY])
        //     && isset($this->config['user-data'][$this->queryParams[self::USER_PARAM_KEY]])
        // ) {
        //     $this->request = $this->request->withAttribute(
        //         'requestedUser',
        //         $this->config['user-data'][$this->queryParams[self::USER_PARAM_KEY]]
        //     );
        // }
        // $this->request = $this->request->withAttribute('isAjax', false);
        // if (in_array('XMLHttpRequest', $this->request->getHeader('X-Requested-With'), true)) {
        //     $this->request = $this->request->withAttribute('isAjax', true);
        // }
    }

    public function run(): void
    {
        $this->runner->run();
         //Debug::dump($this->request);
        // //Debug::dump();
         //die();
        // $layout = $this->getModel();
        // $layout->setTemplate('layout');
        // $layout->setOption('has_parent', true);
        // $page = $this->getModel($this->getRequestedPage());
        // $layout->addChild($page);
        // if ($this->request->getAttribute('isAjax')) {
        //     $layout->setTerminal(true);
        // }
        // return $this->renderApp($layout);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipeline->handle($request);
    }

    /**
     * Proxies to composed pipeline to process.
     * {@inheritDocs}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->pipeline->process($request, $handler);
    }

    // protected function getRequestedPage(): string
    // {
    //     $uri  = $this->request->getUri();
    //     $page = $uri->getPath();
    //     return substr($page, 1, (strlen($page) - 1));
    // }

    // protected function getModel(string $page = null): ModelInterface
    // {
    //     $model = new ViewModel();
    //     if ($page !== null && $page !== '') {
    //         $model->setTemplate($page);
    //     } else {
    //         $model->setTemplate('home');
    //     }
    //     $model->setVariables($this->config['app_settings']['page_data'][$model->getTemplate()] ?? []);
    //     if ($model->getTemplate() === 'profile') {
    //         $model->setVariable(
    //             self::USER_PARAM_KEY,
    //             $this->request->getAttribute(self::REQUESTED_USER)
    //         );
    //     }
    //     return $model;
    // }

    // private function renderApp(ViewModel $layout)
    // {
    //     $response = new HtmlResponse(
    //         $this->view->render($layout)
    //     );
    //     echo $response->getBody();
    // }

    public function __call($name, $arguments)
    {
        switch($name) {
            case $name === 'get':
            case $name === 'post':
            case $name === 'put':
            case $name === 'delete':
                $this->pipe(...$arguments);
        }
    }

    public function pipe($middlewareOrPath, $middleware = null): void
    {
        $middleware = $middleware ?: $middlewareOrPath;
        $path       = $middleware === $middlewareOrPath ? '/' : $middlewareOrPath;

        $middleware = $path !== '/'
            ? path($path, $this->factory->prepare($middleware))
            : $this->factory->prepare($middleware);

        $this->pipeline->pipe($middleware);
    }
}
