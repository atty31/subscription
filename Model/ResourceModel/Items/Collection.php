<?php
namespace Atty31\Subscription\Model\ResourceModel\Items;
/**
 * Class Collection
 * @package Atty31\Subscription\Model\ResourceModel\Subscription
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'atty31_subscription_items_collection';
    protected $_eventObject = 'subscription_items_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Atty31\Subscription\Model\Items', 'Atty31\Subscription\Model\ResourceModel\Items');
    }

}

