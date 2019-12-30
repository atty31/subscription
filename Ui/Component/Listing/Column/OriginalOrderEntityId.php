<?php
/**
 * Created by PhpStorm.
 * User: attila
 * Date: 30.12.19
 * Time: 20:43
 */

namespace Atty31\Subscription\Ui\Component\Listing\Column;

use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Framework\UrlInterface;

class OriginalOrderEntityId extends \Magento\Ui\Component\Listing\Columns\Column
{
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        UrlInterface $urlBuilder
    ){
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['original_order_entity_id'] = $this->getOrder((int) $item['original_order_entity_id']);
            }
        }

        return $dataSource;
    }

    /**
     * @param int $orderEntityId
     * @return string
     */
    public function getOrder(int $orderEntityId) : string
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\OrderRepository')->get($orderEntityId);
        return $this->getOrderUrlWithIncrementId((int) $orderEntityId, (string) $order->getIncrementId());
    }

    /**
     * @param int $orderEntityId
     * @param int $orderIncrementId
     * @return string
     */
    public function getOrderUrlWithIncrementId(int $orderEntityId, string $orderIncrementId) : string
    {
        $orderAdminUrl = ($orderEntityId > 0) ?
            $this->urlBuilder->getUrl('sales/order/view', $paramsHere = ['order_id'=> $orderEntityId ])
            :
            '#';

        return "<a href='{$orderAdminUrl}' target='_blank'>{$orderIncrementId}</a>";
    }
}