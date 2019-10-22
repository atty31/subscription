<?php

namespace Atty31\Subscription\Block\Adminhtml\Subscription\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use  Atty31\Subscription\Model\Config\Status;

class Form extends Generic
{

    protected $status;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        Status $status,
        array $data = []
    ) {
        $this->status = $status;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Maxime\Jobs\Model\Department $model */
        $model = $this->_coreRegistry->registry('subscription');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );

        $form->setHtmlIdPrefix('subscription_');
        $form->setFieldNameSuffix('subscription');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('General Information'), 'class' => 'fieldset-wide']
        );
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'customer_id',
            'text',
            [
                'name' => 'customer_id',
                'label' => __('Customer Id'),
                'title' => __('Customer Id'),
                'required' => true
            ]
        );

        $fieldset->addField('scheduled_at',
            'date',
            [
                'name' => 'scheduled_at',
                'label' => __('Scheduled At'),
                'title' => __('Scheduled At'),
                'date_format' => $this->_localeDate->getDateFormat(\IntlDateFormatter::SHORT),
                'class' => 'validate-date'
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'name'      => 'status',
                'label'     => __('Status'),
                'title' => __('Status'),
                'options'   => $this->status->toOptionArray()
            ]
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}