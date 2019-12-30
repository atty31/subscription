<?php
/**
 * Created by PhpStorm.
 * User: attila
 * Date: 30.12.19
 * Time: 20:00
 */

namespace Atty31\Subscription\Ui\Component\Listing\Column;

use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

class Customer extends \Magento\Ui\Component\Listing\Columns\Column
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
                $item['customer_id'] = $this->getCustomerName((int) $item['customer_id']);
            }
        }

        return $dataSource;
    }

    /**
     * @param int $customerEntityId
     * @return string
     */
    public function getCustomerName(int $customerEntityId) : string
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customer = $objectManager->create('Magento\Customer\Model\Customer')->load($customerEntityId);

        $customerName = ($customer->getMiddlename()) ?
            $customer->getFirstname().' '.$customer->getMiddlename().' '.$customer->getLastname()
            :
            $customer->getFirstname().' '.$customer->getLastname();

        return $this->getCustomerUrl((int) $customer->getId(), (string) $customerName);
    }

    /**
     * @param int $customerId
     * @return string
     */
    public function getCustomerUrl(int $customerId, string $customerName) : string
    {
        $customerAdminUrl = ($customerName !== '') ?
            $this->urlBuilder->getUrl('customer/index/edit', $paramsHere = ['id'=> $customerId ])
            :
            '#';

        return "<a href='{$customerAdminUrl}' target='_blank'>{$customerName}</a>";
    }
}