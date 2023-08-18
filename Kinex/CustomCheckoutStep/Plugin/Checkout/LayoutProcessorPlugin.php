<?php
namespace Kinex\CustomCheckoutStep\Plugin\Checkout;

use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessorPlugin
{
    public function afterProcess(LayoutProcessor $subject, array $jsLayout) 
    {
        $jsLayout['components']['checkout']['children']['steps']['children']['custom-step']['children']['custom-checkout-form-container']['children'];
        return $jsLayout;
    }
}