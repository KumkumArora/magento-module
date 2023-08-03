<?php

namespace Kinex\CustomGrid\Model\Allgrids\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    protected $allGrids;

    public function __construct(\Kinex\CustomGrid\Model\Allgrids $allGrids)
    {
        $this->allGrids = $allGrids;
    }

    public function toOptionArray()
    {
        $availableOptions = $this->allGrids->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
?>