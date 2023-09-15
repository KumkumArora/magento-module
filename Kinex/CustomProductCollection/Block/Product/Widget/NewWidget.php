<?php
namespace Kinex\CustomProductCollection\Block\Product\Widget;

class NewWidget extends \Magento\Catalog\Block\Product\Widget\NewWidget
{
    protected function _construct()
    {
        // parent::_construct();
        $this->setTemplate('Kinex_CustomProductCollection::product/widget/content/new_grid.phtml');
    }
}