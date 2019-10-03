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
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Sales\Model\Order $orderModel
    )
    {
        $this->orderModel = $orderModel;
        $this->_logger = $logger;
    }

    /**
     * Run cron job
     * @cron create_quotes
     * @return $this
     */
    public function execute()
    {
        $this->getOrders();
        return $this;
    }

    public function getOrders(){
        $orders = $this->orderModel->getCollection();
//        $orders->join(array('item' => 'sales_order_item'), 'main_table.entity_id = item.order_id AND main_table.store_id='.$store.' ');
        $orders->getSelect()->group('main_table.entity_id');
        $orders->getSelect()->order('main_table.created_at DESC');
        foreach($orders as $k => $order) {
            echo $order->getId();
        }
        return;
    }
}

