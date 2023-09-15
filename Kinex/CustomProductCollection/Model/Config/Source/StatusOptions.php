<?php
namespace Kinex\CustomProductCollection\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class StatusOptions extends AbstractSource
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
                                ['label' => __('Buyer'), 'value' => 'buyer'],
                                ['label' => __('Seller'), 'value' => 'seller']
                            ];
        }
        return $this->_options;
    }
}