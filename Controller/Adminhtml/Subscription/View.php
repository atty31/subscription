<?php
namespace Atty31\Subscription\Controller\Adminhtml\Subscription;
use Magento\Customer\Controller\Adminhtml\Index;

class View extends Index
{
    /**
     * Customer subscription grid
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }

}