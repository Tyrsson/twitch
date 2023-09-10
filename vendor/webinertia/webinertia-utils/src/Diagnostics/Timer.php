<?php

declare(strict_types=1);

namespace Webinertia\Utils\Diagnostics;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Log\PsrLoggerAdapter as Logger;
use Laminas\Log\Writer\FirePhp;
use Laminas\Mvc\MvcEvent;

use function microtime;
use function sprintf;

class Timer extends AbstractListenerAggregate
{
    protected Logger $logger;
    protected float $startTime;
    protected float $endTime;
    protected float $elapsedTime;
    protected array $settings;

    public function __construct(Logger $logger, array $settings)
    {
        $this->logger   = $logger;
        $this->settings = $settings;
    }

    /** @inheritDoc */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        if ($this->settings['log_execution_time'] || $this->settings['enable_firebug']) {
            $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'start']);
            $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'stop']);
        }
    }

    public function start(MvcEvent $event)
    {
        //$this->startTime = microtime(true);
        $this->startTime = $event->getRequest()->getServer()->get('REQUEST_TIME_FLOAT');
    }

    public function stop(MvcEvent $event)
    {
        $precision         = 2;
        $this->endTime     = microtime(true);
        $this->elapsedTime = $this->endTime - $this->startTime;
        if ($this->elapsedTime * 1000 >= 1) {
            $time = sprintf('%.' . $precision . 'f ms', $this->elapsedTime * 1000);
        }
        if ($this->settings['enable_firebug']) {
            $writer = new FirePhp();
            $logger = $this->logger->getLogger();
            $logger->addWriter($writer);
            $this->logger->info('Total Execution time: ' . $time);
            return;
        }
        $this->logger->debug('Total Execution time: ' . $time);
    }
}
