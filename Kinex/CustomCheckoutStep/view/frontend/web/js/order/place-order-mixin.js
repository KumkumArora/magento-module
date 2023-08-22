define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_CheckoutAgreements/js/model/agreements-assigner',
    'Magento_Checkout/js/model/quote',
    'Magento_Customer/js/model/customer',
    'Magento_Checkout/js/model/url-builder',
    'mage/url',
    'Magento_Checkout/js/model/error-processor',
    'uiRegistry'
], function (
    $, 
    wrapper, 
    agreementsAssigner,
    quote,
    customer,
    urlBuilder, 
    urlFormatter, 
    errorProcessor,
    registry
) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add agreement_ids to request */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            agreementsAssigner(paymentData);
            var isCustomer = customer.isLoggedIn();
            var quoteId = quote.getQuoteId();

            var url = urlFormatter.build('kinex/quote/save');

            var textField = jQuery('[name="text_field"]').val();
            var selectField = jQuery('[name="select_field"]').val();
            var checkboxField = jQuery('[name="checkbox_field"]').prop('checked');
            var dateField = jQuery('[name="date_field"]').val();

            if (textField && selectField && dateField) {
                var payload = {
                    'cartId': quoteId,
                    'is_customer': isCustomer,
                    'text_field' : textField,
                    'select_field': selectField,
                    'checkbox_field' : checkboxField,
                    'date_field' : dateField,
                };
                if (!payload.text_field && payload.select_field && payload.date_field) {
                    return true;
                }

                var result = true;

                $.ajax({
                    url: url,
                    data: payload,
                    dataType: 'text',
                    type: 'POST',
                }).done(
                    function (response) {
                        result = true;
                    }
                ).fail(
                    function (response) {
                        result = false;
                        errorProcessor.process(response);
                    }
                );
            }
            
            return originalAction(paymentData, messageContainer);
        });
    };
});