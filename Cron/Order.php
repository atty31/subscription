<?php
namespace Atty31\Subscription\Cron;

/**
 * Create orders from subscriptions
 * Class Quote
 * @package Atty31\Subscription\Cron
 */
class Order
{

    protected $_logger;

    /**
     * Order constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    /**
     * Run cron job
     * @cron create_orders
     * @return $this
     */
    public function execute()
    {
        $this->_logger->info('Hello Order');
        return $this;
    }
}

