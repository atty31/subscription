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
        $subscriptionItems = []; $numberOfDays = [];
        foreach ($items as $item) {
            /** @var \Magento\Catalog\Model\Product $product */
            $productData = $this->productCollection->load($item->getProductId());
            if ($productData->getSubscription()){
                /** @var todo  check if the scheduled days is a valid one */
                $subscriptionItems[] = [
                    'item'  =>  $item->getData(),
                ];
                array_push($numberOfDays, $productData->getData('number_of_days'));
            }
        }

        /** @todo add validation before submit */
        $numberOfDays = array_unique($numberOfDays);
        $this->validateNumberOfDays($numberOfDays);

        //Insert into database
        if (!empty($subscriptionItems)) {
            $subscriptionModel = $this->objectManager->create('Atty31\Subscription\Model\Subscription');
            $subscriptionModel->setData('scheduled_at', $this->calculateNextScheduledDate((int)$productData->getNumberOfDays()));
            $subscriptionModel->setData('customer_id', (int)$order->getCustomerId());
            $subscriptionModel->setData('original_order_entity_id', (int)$order->getId());
            $subscriptionModel->setData('status', \Atty31\Subscription\Model\Config\Status::ENABLED);
            $subscriptionModel->setData('number_of_days', $numberOfDays[0]); // it should have always only one item in the array

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

    /**
     * @param array $numberOfDays
     * @throws \Exception
     */
    public function validateNumberOfDays(array $numberOfDays) : void
    {
        if ((int) count($numberOfDays) > 1){  // check if we have different values of the `number of days` for the items
            $numberOfDaysValues = implode(' - ', $numberOfDays);
            throw new \Exception("All of the products should have the same `number of days`! \n The following values were given: {$numberOfDaysValues} ");
        }
    }
}