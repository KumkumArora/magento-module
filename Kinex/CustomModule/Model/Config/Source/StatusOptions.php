<?php
namespace Kinex\CustomModule\Model\Config\Source;

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
                                ['label' => __('Yes'), 'value' => 1],
                                ['label' => __('No'), 'value' => 0]
                            ];
        }
        return $this->_options;
    }
}