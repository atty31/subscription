<?php
/**
 * Created by PhpStorm.
 * User: attila
 * Date: 23.12.19
 * Time: 12:11
 */

namespace Atty31\Subscription\Model;


class Items extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'atty31_subscription_subscription_items';

    protected $_cacheTag = 'atty31_subscription_subscription_items';
    protected $_eventPrefix = 'atty31_subscription_subscription_items';

    protected function _construct()
    {
        $this->_init('Atty31\Subscription\Model\ResourceModel\Items');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }
}