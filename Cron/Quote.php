<?php
namespace Atty31\Subscription\Cron;

/**
 * Create quotes for subscriptions
 * Class Quote
 * @package Atty31\Subscription\Cron
 */
class Quote
{

    protected $_logger;

    /**
     * Quote constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * Run cron job
     * @cron create_quotes
     * @return $this
     */
    public function execute()
    {
        $this->_logger->info('Hello Quote');
        return $this;
    }
}
