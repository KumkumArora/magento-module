var config = {
   config: {
       mixins: {
           'Magento_ConfigurableProduct/js/configurable': {
               'Kinex_CustomModule/js/model/skuswitch': true
           },
           'Magento_Swatches/js/swatch-renderer': {
               'Kinex_CustomModule/js/model/swatch-skuswitch': true
           }
       }
  }
};