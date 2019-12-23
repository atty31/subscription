<?php
namespace Atty31\Subscription\Plugin;

use DateTime;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Catalog\Model\Product;

class OrderAfterSave
{
    protected $objectManager;
    protected $orderRepositoryInterface;

    public function __construct(
        ObjectManagerInterface $objectManager,
        OrderRepositoryInterface $orderRepositoryInterface,
        Product $productCollection
    ) {
        $this->objectManager = $objectManager;
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->productCollection = $productCollection;
    }

    public function afterSave(\Magento\Sales\Api\OrderRepositoryInterface $orderRepo, \Magento\Sales\Api\Data\OrderInterface $order)
    {
        $items = $order->getAllVisibleItems();
        $subscriptionItems = [];
        foreach ($items as $item) {
            /** @var \Magento\Catalog\Model\Product $product */
            $productData = $this->productCollection->load($item->getProductId());
            if ($productData->getSubscription()){
                /** @var todo  check if the scheduled days is a valid one */
                $subscriptionItems[] = [
                    'item'  =>  $item->getData(),
                ];
            }
        }

        //Insert into database
        if (!empty($subscriptionItems)) {
            $subscriptionModel = $this->objectManager->create('Atty31\Subscription\Model\Subscription');
            $subscriptionModel->setData('scheduled_at', $this->calculateNextScheduledDate((int)$productData->getNumberOfDays()));
            $subscriptionModel->setData('customer_id', (int)$order->getCustomerId());
            $subscriptionModel->setData('original_order_entity_id', (int)$order->getId());
            $subscriptionModel->setData('status', \Atty31\Subscription\Model\Config\Status::ENABLED);

            $subscriptionModelId = $subscriptionModel->save();
            foreach ($subscriptionItems as $item){
                $subscriptionItemsModel = $this->objectManager->create('Atty31\Subscription\Model\Items');
                $subscriptionItemsModel->setData('sku', $item['item']['sku']);
                $subscriptionItemsModel->setData('name', $item['item']['name']);
                $subscriptionItemsModel->setData('subscription_id', $subscriptionModelId->getId());
                $subscriptionItemsModel->save();
            }
        }

        return $order;
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