Craft.PaymentAdjusterIndex = Craft.BaseElementIndex.extend(
    {
        editableProductTypes: null,
        $newProductBtnProductType: null,
        $newProductBtn: null,

        init: function (elementType, $container, settings) {
            this.base(elementType, $container, settings);
            
            var $btn = $('<a class="btn submit icon add" href="' + Craft.getUrl('super-payment-adjuster/payment-adjusters/edit/new') + '">' + Craft.t('super-payment-adjuster', 'New Payment Adjuster') + '</a>');
            this.addButton($btn);
        }
    }
)
Craft.registerElementIndexClass('pdaleramirez\\superpaymentadjuster\\elements\\PaymentAdjuster', Craft.PaymentAdjusterIndex);
