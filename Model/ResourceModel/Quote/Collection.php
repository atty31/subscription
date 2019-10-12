<?php
namespace Atty31\Subscription\Model\ResourceModel\Quote;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'atty31_subscription_quote_collection';
    protected $_eventObject = 'quote';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Atty31\Subscription\Model\Quote', 'Atty31\Subscription\Model\ResourceModel\Quote');
    }

}

