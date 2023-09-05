<?php

declare(strict_types=1);

namespace App;

use App\Module;
use App\ModelInterface as AppModelInterface;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\UriFactory;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\Model\ModelInterface;
use Laminas\View\View;
use Laminas\View\Model\ViewModel;
use Webinertia\Utils\Debug;

use function strlen;
use function substr;

final class Kernel
{
    /** @var SerivceManager $sm */
    protected $sm;

    public function __construct(
        protected ServerRequest $request,
        protected View $view
    ) {
    }

    public static function init()
    {
        $config = (new Module())->getConfig();
        $sm = new ServiceManager($config);
        $sm->setService('config', $config);
        return $sm->get(self::class)->run($sm);
    }

    public function run(ServiceManager $sm)
    {
        $this->sm = $sm;
        $layout = $this->getModel();
        $layout->setTemplate('layout');
        $layout->setOption('has_parent', true);
        $page = $this->getModel($this->getRequestedPage());
        $layout->addChild($page);
        echo $this->view->render($layout);
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

    protected function pageModel(ModelInterface $page): AppModelInterface
    {
        if ($this->sm->has($page::class)) {
            return $this->sm->get($page::class);
        }
        return $page;
    }
}
