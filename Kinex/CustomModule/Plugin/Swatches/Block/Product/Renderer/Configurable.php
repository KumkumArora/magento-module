<?php
namespace Kinex\CustomModule\Plugin\Swatches\Block\Product\Renderer;
 
class Configurable
{
    public function afterGetJsonConfig(\Magento\Swatches\Block\Product\Renderer\Configurable $subject, $result) {
 
        $jsonResult = json_decode($result, true);
        $jsonResult['skus'] = [];
        $jsonResult['names'] = [];
        $jsonResult['offer'] = [];
        $jsonResult['availability']= [];
 
        foreach ($subject->getAllowProducts() as $simpleProduct) {
            
           $jsonResult['skus'][$simpleProduct->getId()] = $simpleProduct->getSku();
           $jsonResult['names'][$simpleProduct->getId()] = $simpleProduct->getName();
           $jsonResult['offer'][$simpleProduct->getId()] = $simpleProduct->getData('add_offer_Tag');
           $jsonResult['availability'][$simpleProduct->getId()] = $simpleProduct->getData('Product_availability');
        }
        $result = json_encode($jsonResult);
       
        return $result;
	}
}