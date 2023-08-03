define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function(targetModule){

        var updatePrice = targetModule.prototype._UpdatePrice;
        var updatePriceWrapper = wrapper.wrap(updatePrice, function(original){
            var allSelected = true;
            for(var i = 0; i<this.options.jsonConfig.attributes.length;i++){
                if (!$('div.product-info-main .product-options-wrapper .swatch-attribute.' + this.options.jsonConfig.attributes[i].code).attr('data-option-selected')){
                    allSelected = false;
                }
            }
            var productSku = this.options.jsonConfig.skus[this.getProduct()];
            var productName = this.options.jsonConfig.names[this.getProduct()];
            var productOffer = this.options.jsonConfig.offer[this.getProduct()];
            var productAvalibility = this.options.jsonConfig.availability[this.getProduct()];
            
            if (allSelected){
                var products = this._CalcProducts();
                productSku = this.options.jsonConfig.skus[products.slice().shift()];
                productName = this.options.jsonConfig.names[products.slice().shift()];
                productOffer = this.options.jsonConfig.offer[products.slice().shift()];
                productAvalibility = this.options.jsonConfig.availability[products.slice().shift()];
            }
            $('div.product-info-main .sku .value').html(productSku);
            $('div.product-info-main .page-title .base').html(productName);

            if(productAvalibility == 1){
            $('div.product-info-main>h3>strong').html(productOffer).show();
            $('div.product-options-bottom').show();
            $('div.product-info-price .price-box .price-final_price').show();
            $('div.product-info-stock-sku .available>span').show();
            $('div.reviews-actions').html('<h1><strong>This Product is Not Available</strong></h1>').hide();

            }else{
                $('div.product-info-main>h3>strong').html(productOffer).hide();
                $('div.product-options-bottom').hide();
                $('div.product-info-price .price-box .price-final_price').hide();
                $('div.product-info-stock-sku .available>span').hide();
                $('div.reviews-actions').html('<h2><strong>This Product is Not Available</strong></h2>').css("color", "red").show();
            }
                  
              return original();
        });
 
        targetModule.prototype._UpdatePrice = updatePriceWrapper;
        return targetModule;
    };
});