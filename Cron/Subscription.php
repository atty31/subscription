<?php
namespace Atty31\Subscription\Cron;

/**
 * Create subscriptions for customers
 * Class Quote
 * @package Atty31\Subscription\Cron
 */
class Subscription
{

    protected $_logger;

    /**
     * Subscription constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * Run cron job
     * @cron create_subscriptions
     * @return $this
     */
    public function execute()
    {
        $this->_logger->info('Hello Subscription');
        return $this;
    }
}

