<?php
namespace Kinex\CustomProductCollection\Block\Product;

class ProductsList extends \Magento\CatalogWidget\Block\Product\ProductsList
{
    protected function _construct()
    {
        // parent::_construct();
        $this->setTemplate('Kinex_CustomProductCollection::product/widget/content/grid.phtml');
    }
}