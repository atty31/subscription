<?php
namespace Atty31\Subscription\Model\Config;

use Magento\Framework\Option\ArrayInterface;

/**
 * Class Status
 * @package Atty31\Subscription\Model\Config
 */
class Status implements ArrayInterface
{
    const DISABLED = 0;
    const ENABLED  = 1;
    const PAUSED = 2;

    /**
     * @return array
     */
    public function toOptionArray() : array
    {
        $options = [
            self::DISABLED => __('Inactive'),
            self::ENABLED => __('Active'),
            self::PAUSED => __('Paused')
        ];

        return $options;
    }

    /**
     * @param int $id
     * @return string
     */
    public function getStatusLabel(int $id) : string
    {
        $status = [
            '1' => 'Enabled',
            '2' => 'Paused',
            '0' => 'Disabled',
        ];

        return $status[$id];
    }
}