<?php
namespace Mageplaza\Example\Block\Adminhtml\Subscription;
class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Atty31_Subscription';
        $this->_controller = 'adminhtml_blog';
        $this->_headerText = __('Manage Subscriptions');
        $this->_addButtonLabel = __('Add New Subscription');

        parent::_construct();
    }
}