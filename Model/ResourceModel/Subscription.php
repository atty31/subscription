<?php
namespace Atty31\Subscription\Model\ResourceModel;
/**
 * Class Subscription
 * @package Atty31\Subscription\Model\ResourceModel
 */
class Subscription extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('atty31_subscription', 'id');
    }

}
