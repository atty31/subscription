<?php
/**
 * Created by PhpStorm.
 * User: attila
 * Date: 30.12.19
 * Time: 16:27
 */

namespace Atty31\Subscription\Ui\Component\Listing\Column;


class SubscriptionItemsActions extends \Magento\Ui\Component\Listing\Columns\Column
{
    const URL_PATH_VIEW_PRODUCT = 'catalog/product/edit';
    const URL_PATH_ADD_ITEM = 'subscriptions/subscription/additems';

    protected $urlBuilder;

    /**
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'view' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_VIEW_PRODUCT,
                                [
                                    'id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('View')
                        ],
                        'add' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_ADD_ITEM,
                                [
                                    'entity_id' => $item['entity_id']
                                ]
                            ),
                            'label' => __('Add'),
                            'confirm' => [
                                'title' => __('Add "${ $.$data.title }"'),
                                'message' => __('Are you sure you wan\'t to add a "${ $.$data.title }" item?')
                            ]
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}