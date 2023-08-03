define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
 'use strict';
 
    return function(targetModule){
 
        var reloadPrice = targetModule.prototype._reloadPrice;
        var reloadPriceWrapper = wrapper.wrap(reloadPrice, function(original){
        var result = original();
        var simpleSku = this.options.spConfig.skus[this.simpleProduct];
        var productOffer = this.options.jsonConfig.offer[this.getProduct()];
 
            if(simpleSku != '') {
                $('div.product-info-main .sku .value').html(simpleSku);
                productOffer = this.options.jsonConfig.offer[products.slice().shift()];
            }
            return result;
        });
        targetModule.prototype._reloadPrice = reloadPriceWrapper;
        return targetModule;
 };
});