<?php
namespace Atty31\Subscription\Ui\Component\Listing\Column;

use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;

use \Atty31\Subscription\Model\Config\Status as SubscriptionStatus;

class Status extends \Magento\Ui\Component\Listing\Columns\Column
{
    private $status;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [],
        SubscriptionStatus $status
    ){
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->status = $status;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['status'] = $this->status->getStatusLabel((int) $item['status']);
            }
        }

        return $dataSource;
    }
}