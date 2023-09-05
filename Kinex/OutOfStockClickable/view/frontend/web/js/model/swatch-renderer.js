define([
    'jquery',
    'underscore',
    'mage/utils/wrapper'
], function ($,_, wrapper) {
    'use strict';

    return function(targetModule){
        var updateSwatch = targetModule.prototype.disableSwatchForOutOfStockProducts;
        var updateSwatchWrapper = wrapper.wrap(updateSwatch, function(original){
                let $widget = this, container = this.element;
              
                $.each(this.options.jsonConfig.attributes, function () {
                    let item = this;
               
                    if ($widget.options.jsonConfig.canDisplayShowOutOfStockStatus) {
                        let salableProducts = $widget.options.jsonConfig.salable[item.id],
                            swatchOptions = $(container).find(`[data-attribute-id='${item.id}']`).find('.swatch-option');
                        swatchOptions.each(function (key, value) {
                            let optionId = $(value).data('option-id');
                            if (!salableProducts.hasOwnProperty(optionId)) {
                                setTimeout(() => {
                                    $(value).attr('disabled', true).removeAttr('disabled').removeClass('disabled').addClass('custom');
                                }, 100);
                                
                            }
                        });
                    }
                });
                return original();
        });
        targetModule.prototype.disableSwatchForOutOfStockProducts = updateSwatchWrapper;
        return targetModule;
    };
});