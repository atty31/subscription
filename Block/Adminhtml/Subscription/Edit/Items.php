<?php
namespace Atty31\Subscription\Block\Adminhtml\Subscription\Edit;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\ObjectManagerInterface;

class Items extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        Context $context,
        Registry $registry,
        ObjectManagerInterface $objectManager
    )
    {
        $this->coreRegistry = $registry;
        $this->objectManager = $objectManager;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getSubscriptionItemInformation()
    {
        /** @var \Atty31\Subscription\Model\subscription $model */
        $model = $this->coreRegistry->registry('subscription');

        return $this->objectManager->create('Atty31\Subscription\Model\Items')->load($model->getData('id'), 'subscription_id');
    }
}