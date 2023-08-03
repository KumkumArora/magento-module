<?php
namespace Kinex\CustomModule\Block\Product;

class ProductsList extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    protected function _construct()
    {
        // parent::_construct();
        $this->setTemplate('Kinex_CustomModule::product/widget/content/grid.phtml');
    }
}