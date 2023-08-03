<?php
namespace Kinex\CustomModule\Plugin;

class FinalPriceBox
{
    public function afterToHtml(\Magento\Catalog\Pricing\Render\FinalPriceBox $subject,  $result)
    {   
        if($subject->getSaleableItem()->getData('product_select_attribute') == 1){

            if($subject->getSaleableItem()->getData('Product_availability') != 0)
            {
                return $result;
            }
        }else{
            return "";
        }
    }
}

