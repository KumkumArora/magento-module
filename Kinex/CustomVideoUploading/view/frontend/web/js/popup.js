require([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function ($, modal) {
    'use strict';
    var options = {
        type: 'popup',
        responsive: true,
        innerScroll: true,
        title: 'Product Video',
        buttons: [{
                    text: $.mage.__('Close'),
                    class: '',
                    click: function () {
                        this.closeModal();
                    }
                }]
    };

    var popup = modal(options, $('#popup-modal-main'));

    $('#custom-button-id').on('click', function () {
        $('#popup-modal-main').modal('openModal');
    });
});