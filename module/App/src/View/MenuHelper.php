<?php

declare(strict_types=1);

namespace App\View;

use DirectoryIterator;
use Laminas\Diactoros\ServerRequest;
use Laminas\View\HtmlAttributesSet;

use function substr;
use function strlen;
use function ucwords;
use function usort;

final class MenuHelper
{
    public const TEMPLATE_PATH   = __DIR__ . '/../../view';
    public const LAYOUT_TEMPLATE = 'layout';

    private string $activeClass = 'active';
    private HtmlAttributesSet $helper;
    private array $pages = [];
    private string $ext;
    private array $order;


    public function __construct(
        private ServerRequest $request,
        HtmlAttributesSet $helper,
        array $config
    ) {
        $this->helper = $helper;
        $this->ext = $config['view_manager']['default_template_suffix'] ?? 'phtml';
        $tmplHandler = new DirectoryIterator(self::TEMPLATE_PATH);
        foreach ($tmplHandler as $file) {
            if (! $file->isDir() && ! $file->isDot() && $file->getFilename() !== 'layout' . '.' . $this->ext) {
                $tmpl = $file->getFilename();
                $this->pages[] = substr($tmpl, 0, (strlen($tmpl) - (strlen($this->ext) + 1)));
            }
        }
    }

    public function __invoke(?array $order = null, array $attribs = ['class' => 'nav-link']): string|null
    {
        $this->helper->set($attribs);
        if ($order && $order !== []) {
            $this->setOrder($order);
            usort($this->pages, [$this, 'userSort']);
        }
        $uri = $this->request->getAttribute('uri')->getPath();
        $html = '';
        foreach ($this->pages as $page) {
            if ($uri === '/' . $page || ($uri === '/' && $page === 'home')) {
                $this->helper->add('class', $this->activeClass);
            }
            $link = $page === 'home' ? '/' : '/' . $page;
            $html .= '<li><a' . $this->helper . ' href="' . $link . '">' . ucwords($page) . '</a></li>';
            $this->helper->set($attribs);
        }
        return $html;
    }

    private function userSort($a, $b): int
    {
        foreach ($this->order as $key => $value) {
            if ($a == $value) {
                return 0;
                break;
            }
            if ($b == $value) {
                return 1;
                break;
            }
        }
    }

    public function setOrder(array $order): void
    {
        $this->order = $order;
    }

    public function getOrder(): null|array
    {
        return $this->order;
    }
}
