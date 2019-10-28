<?php
namespace Atty31\Subscription\Block\Adminhtml\Subscription\Edit;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\UrlInterface;

class CustomerInfo extends Template
{
    protected $customerRepositoryInterface;
    protected $coreRegistry;
    protected $objectManager;
    protected $urlBuilder;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepositoryInterface,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        UrlInterface $urlBuilder
    )
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->coreRegistry = $registry;
        $this->objectManager = $objectManager;
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function getCustomerInformation()
    {
        /** @var \Atty31\Subscription\Model\subscription $model */
        $model = $this->coreRegistry->registry('subscription');

        return $this->objectManager->create('Magento\Customer\Model\Customer')->load($model->getData('customer_id'));
    }

    /**
     * @param int $customerId
     * @return string
     */
    public function getCustomerUrl(int $customerId) : string
    {
        return $this->urlBuilder->getUrl('customer/index/edit', $paramsHere = ['id'=> $customerId ]);
    }

}