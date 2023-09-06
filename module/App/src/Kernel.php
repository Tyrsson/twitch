<?php

declare(strict_types=1);

namespace App;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\UriFactory;
use Laminas\View\Model\ModelInterface;
use Laminas\View\View;
use Laminas\View\Model\ViewModel;
use Webinertia\Utils\Debug;

use function strlen;
use function substr;

class Kernel
{
    public function __construct(
        private ServerRequest $request,
        private View $view,
        private array $config
    ) {
    }

    public function run()
    {
        $layout = $this->getModel();
        $layout->setTemplate('layout');
        $layout->setOption('has_parent', true);
        //Debug::dump($this->config);
        $page = $this->getModel($this->getRequestedPage());
        $page->setVariables($this->config['app_settings']['page_data'][$page->getTemplate()] ?? []);

        $layout->addChild($page);
        $this->renderApp($layout);
    }

    protected function getRequestedPage(): string
    {
        $uri = UriFactory::createFromSapi($this->request->getServerParams(), $this->request->getHeaders());
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
        return $model;
    }

    private function renderApp(ViewModel $layout)
    {
        echo $this->view->render($layout);
    }
}
