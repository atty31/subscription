<?php

namespace Atty31\Subscription\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    const ENABLED  = 1;
    const DISABLED = 0;
    const PAUSED = 2;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            self::ENABLED => __('Enabled'),
            self::DISABLED => __('Disabled'),
            self::PAUSED => __('Paused')
        ];

        return $options;
    }
}