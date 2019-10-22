<?php
namespace Atty31\Subscription\Controller\Adminhtml\Subscription;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @return void
     */
    public function execute()
    {
        $isPost = $this->getRequest()->getPost();

        if ($isPost) {
            $subscriptionId = $this->getRequest()->getParam('subscription')['id'];

            if ($subscriptionId) {
                $subscriptionModel = $this->_objectManager->create('Atty31\Subscription\Model\Subscription');
                $subscriptionModel->load($subscriptionId);
                $formData = $this->getRequest()->getParam('subscription');
                $subscriptionModel->setData($formData);
                try {
                    // Save subscription
                    $subscriptionModel->save();

                    // Display success message
                    $this->messageManager->addSuccess(__('The subscription has been saved.'));

                    // Check if 'Save and Continue'
                    if ($this->getRequest()->getParam('back')) {
                        $this->_redirect('*/*/edit', ['id' => $subscriptionModel->getId(), '_current' => true]);
                        return;
                    }

                    // Go to grid page
                    $this->_redirect('*/*/');
                    return;
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }

                $this->_getSession()->setFormData($formData);
                $this->_redirect('*/*/edit', ['id' => $subscriptionId]);
            }
        }
    }
}
