<?php
namespace Atty31\Subscription\Ui\DataProvider\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class ProductDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param \Magento\Ui\DataProvider\AddFieldToCollectionInterface[] $addFieldStrategies
     * @param \Magento\Ui\DataProvider\AddFilterToCollectionInterface[] $addFilterStrategies
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $addFieldStrategies = [],
        array $addFilterStrategies = [],
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $collectionFactory, $addFieldStrategies, $addFilterStrategies, $meta, $data);
        $this->collection->addAttributeToFilter('subscription', '1');
    }

}