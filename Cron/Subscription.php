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

    /**
     * Subscription constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\Order $orderModel
    )
    {
        $this->orderModel = $orderModel;
        $this->logger = $logger;
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

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        foreach($orders as $k => $order) {
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                /** @var \Magento\Catalog\Model\Product $product */
                $product = $objectManager->get('Magento\Catalog\Model\Product')->load($item->getId());
                if ($product->getResource()->getAttributeRawValue($item->getId(),'subscription',$order->getStoreId())){
                    //add here condition
                }
            }
        }
        return;
    }
}

