<?php

namespace Atty31\Subscription\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const DISABLED = 0;
    const ENABLED  = 1;
    const PAUSED = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::DISABLED => __('Inactive'),
            self::ENABLED => __('Active'),
            self::PAUSED => __('Paused')
        ];

        return $options;
    }
}