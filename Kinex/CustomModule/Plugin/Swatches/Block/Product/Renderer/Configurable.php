<?php
namespace Kinex\CustomModule\Plugin\Swatches\Block\Product\Renderer;

use Magento\CatalogInventory\Api\StockRegistryInterface;
 
class Configurable
{
    protected $stockRegistry;

    public function __construct(
        StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;
    }

    public function afterGetJsonConfig(\Magento\Swatches\Block\Product\Renderer\Configurable $subject, $result) {     
        $jsonResult = json_decode($result, true);
        $jsonResult['skus'] = [];
        $jsonResult['names'] = [];
        $jsonResult['offer'] = [];
        $jsonResult['availability']= [];
        $jsonResult['qty']= [];
 
        foreach ($subject->getAllowProducts() as $simpleProduct) {
           $jsonResult['skus'][$simpleProduct->getId()] = $simpleProduct->getSku();
           $jsonResult['names'][$simpleProduct->getId()] = $simpleProduct->getName();
           $jsonResult['offer'][$simpleProduct->getId()] = $simpleProduct->getData('add_offer_Tag');
           $jsonResult['availability'][$simpleProduct->getId()] = $simpleProduct->getData('Product_availability');
           $stockitem = $this->stockRegistry->getStockItem(
                $simpleProduct->getId(),
                $simpleProduct->getStore()->getWebsiteId()
            );
            $jsonResult['qty'][$simpleProduct->getId()] = $stockitem->getQty();
       
        }
        $result = json_encode($jsonResult);
        return $result;
	}
}