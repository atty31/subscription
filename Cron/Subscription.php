<?php
namespace Atty31\Subscription\Cron;

use DateTime;

/**
 * Create subscriptions for customers
 * Class Quote
 * @package Atty31\Subscription\Cron
 */
class Subscription
{

    protected $logger;
    protected $orderModel;
    protected $productCollection;

    /**
     * Subscription constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Sales\Model\Order $orderModel
     * @param \Magento\Catalog\Model\Product $productCollection
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\Order $orderModel,
        \Magento\Catalog\Model\Product $productCollection
    )
    {
        $this->orderModel = $orderModel;
        $this->logger = $logger;
        $this->productCollection = $productCollection;
    }

    /**
     * Run cron job
     * @cron create_subscriptions
     * @return $this
     */
    public function execute()
    {
        $orders = $this->orderModel->getCollection();
        $orders->getSelect()->order('main_table.created_at DESC');
        $subscriptionData = [];
        foreach($orders as $k => $order) {
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                /** @var \Magento\Catalog\Model\Product $product */
                $productData = $this->productCollection->load($item->getId());
                if ($productData->getSubscription()){
                    /** @var todo  check if the scheduled days is a valid one */
                    $subscriptionData['scheduled_at'] = $this->calculateNextScheduledDate((int) $productData->getNumberOfDays());
                    $subscriptionData['customer_id']  = (int) $order->getCustomerId();
                    $subscriptionData['status'] = 1;
                }
            }
        }
        return $this;
    }

    /**
     * Get next scheduled date
     * @param int $numberOfDays
     * @return string
     */
    public function calculateNextScheduledDate(int $numberOfDays) : string
    {
        $date = new DateTime();
        $date->modify("+{$numberOfDays} day");
        return $date->format('Y-m-d');
    }

}

