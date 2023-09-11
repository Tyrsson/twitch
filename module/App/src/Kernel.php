<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;
use Laminas\View\Model\ModelInterface;
use Laminas\View\View;
use Laminas\View\Model\ViewModel;
use Webinertia\Utils\Debug;

use function strlen;
use function substr;

class Kernel
{
    private const USER_PARAM_KEY = 'user';
    public const  REQUESTED_USER = 'requestedUser';
    private array $queryParams;

    public function __construct(
        private ServerRequest $request,
        private View $view,
        private array $config
    ) {
        $this->queryParams = $this->request->getQueryParams();
        if (
            isset($this->queryParams[self::USER_PARAM_KEY])
            && isset($this->config['user-data'][$this->queryParams[self::USER_PARAM_KEY]])
        ) {
            $this->request = $this->request->withAttribute(
                'requestedUser',
                $this->config['user-data'][$this->queryParams[self::USER_PARAM_KEY]]
            );
        }
    }

    public function run()
    {
        // Debug::dump($this->request);
        // //Debug::dump();
        // die();
        $layout = $this->getModel();
        $layout->setTemplate('layout');
        $layout->setOption('has_parent', true);
        $page = $this->getModel($this->getRequestedPage());


        $layout->addChild($page);
        return $this->renderApp($layout);
    }

    protected function getRequestedPage(): string
    {
        $uri  = $this->request->getUri();
        $page = $uri->getPath();
        return substr($page, 1, (strlen($page) - 1));
    }

    protected function getModel(string $page = null): ModelInterface
    {
        $model = new ViewModel();
        if ($page !== null && $page !== '') {
            $model->setTemplate($page);
        } else {
            $model->setTemplate('home');
        }
        $model->setVariables($this->config['app_settings']['page_data'][$model->getTemplate()] ?? []);
        if ($model->getTemplate() === 'profile') {
            $model->setVariable(
                self::USER_PARAM_KEY,
                $this->request->getAttribute(self::REQUESTED_USER)
            );
        }
        return $model;
    }

    private function renderApp(ViewModel $layout)
    {
        $response = new HtmlResponse(
            $this->view->render($layout)
        );
        echo $response->getBody();
    }
}
