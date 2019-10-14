<?php
namespace Atty31\Subscription\Block\Adminhtml\Subscription;
class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Atty31_Subscription';
        $this->_controller = 'adminhtml_subscriptions';
        $this->_headerText = __('Manage Subscriptions');
        $this->_addButtonLabel = __('Add New Subscription');

        parent::_construct();
    }
}