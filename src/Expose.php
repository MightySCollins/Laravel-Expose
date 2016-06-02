<?php

namespace SCollins\LaravelExpose;

use Log;
use Expose\Queue;
use Expose\Manager;
use Expose\Notify\Email;
use Expose\FilterCollection;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class Expose extends Manager
{
    /**
     * Init the object and assign the filters
     *
     * @param \Expose\FilterCollection $filters Set of filters
     * @param LoggerInterface $logger
     * @param Queue $queue
     */
    public function __construct(FilterCollection $filters, LoggerInterface $logger = null, Queue $queue = null)
    {
        parent::__construct($filters, $logger, $queue);
    }

    public function makeNotify()
    {
        $notify = new Email();
        $notify->setToAddress(config('expose.mail.to'));
        $notify->setFromAddress(config('expose.mail.from'));
        return $notify;
    }

    public function makeLogger()
    {
        if (config('expose.logFile') === null) {
            return Log::getMonolog();
        }

        $logger = new Logger('expose');
        $logger->pushHandler(new StreamHandler(config('expose.logFile'), Logger::WARNING));
        return $logger;
    }

    public function makeCache()
    {
        $cache = new \Expose\Cache\File();
        $cache->setPath(config('expose.cache'));
        return $cache;
    }
}
