<?php
namespace Kinex\CustomModule\Plugin\ConfigurableProduct\Block\Product\View\Type;
 
class Configurable
{
    public function afterGetJsonConfig(
        \Magento\ConfigurableProduct\Block\Product\View\Type\Configurable $subject,
        $result
	) {
    $jsonResult = json_decode($result, true);
    $jsonResult['skus'] = [];
    $jsonResult['names'] = [];
    $jsonResult['offer'] = [];
    $jsonResult['availability']= [];
        foreach ($subject->getAllowProducts() as $simpleProduct) {
            $jsonResult['skus'][$simpleProduct->getId()] = $simpleProduct->getSku();
            $jsonResult['names'][$simpleProduct->getId()] = $simpleProduct->getName();
            $jsonResult['offer'][$simpleProduct->getId()] = $simpleProduct->getAttributeText('add_offer_Tag');
            $jsonResult['availability'][$simpleProduct->getId()] = $simpleProduct->getData('Product_availability');
	}
        $result = json_encode($jsonResult);
        return $result;
	}
}