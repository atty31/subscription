<?php
namespace Atty31\Subscription\Model;

class Quote extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'atty31_subscription_subscription';

    protected $_cacheTag = 'atty31_subscription_subscription';
    protected $_eventPrefix = 'atty31_subscription_subscription';

    protected function _construct()
    {
        $this->_init('Atty31\Subscription\Model\ResourceModel\Quote');
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
