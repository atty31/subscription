<?php

namespace Atty31\Subscription\Cron;

class Quote
{

    protected $_logger;

    public function __construct(\Psr\Log\LoggerInterface $logger) {
        $this->_logger = $logger;
    }

    public function execute() {
        $this->_logger->info('Hello');
        return $this;
    }
}

