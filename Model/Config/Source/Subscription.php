<?php
namespace Atty31\Subscription\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Subscription extends AbstractSource
{
    /**
     * Get all options
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (null === $this->_options) {
            $this->_options=[
                ['label' => __('Enable'), 'value' => 1],
                ['label' => __('Disable'), 'value' => 0]
            ];
        }
        return $this->_options;
    }
}