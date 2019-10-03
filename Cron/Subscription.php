<?php
namespace Atty31\Subscription\Cron;

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
        foreach($orders as $k => $order) {
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                /** @var \Magento\Catalog\Model\Product $product */
                $productData = $this->productCollection->load($item->getId());
                var_dump($productData->getData()); //get all data for the ordered product
                var_dump($productData->getSubscription()); //get subscription attribute value of the ordered product
            }
        }
        return $this;
    }
}

