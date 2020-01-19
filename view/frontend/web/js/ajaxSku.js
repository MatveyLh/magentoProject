define([
    'jquery',
    'mage/template',
    'Magento_Customer/js/customer-data',
    'jquery-ui-modules/widget',
],function($,mageTemplate,customerData){
    $.widget('mage.ajaxSku', {
        options: {
            url: '/checkout/cart/add',
            selectorSkuForm: '#formSku',
            selectorInputName: "input[name='skuProduct']"
        },

        skuNameInput: null,

        _create : function () {
            this.initDomBindings();
        },

        initDomBindings: function () {
            this.skuNameInput = $(this.options.selectorInputName);

            $('#skuProduct').keyup(function (e) {
                e.preventDefault();

                var value = this.skuNameInput.val();
                var minLength = 3;
                var url = '/matvey/search/search';
                var form = $(this);

                if (value.length >= minLength) {

                    this.ajaxComplete(form, url, function (data) {
                        var sections = ['cart'];
                        customerData.invalidate(sections);
                        customerData.reload(sections, true);
                        if (url === '/matvey/search/search') {
                            $('.products').html('');
                            $.each(data, function (index, value) {
                                var template = mageTemplate('#search-template');
                                var templateHtml = template({
                                    data: {
                                        name: value.name,
                                        sku: value.sku,
                                        url: 'pub/media/catalog/product' + value.image
                                    }
                                });
                                $('.products').append(templateHtml);
                            });

                            $('.product').click(function () {
                                var value = $(".sku");
                                $("#skuProduct").val(value.innerText);
                                $(".products").hide('fast');
                            })
                        }
                    })
                }
            }.bind(this));

            $(this.options.selectorSkuForm).submit(function (e) {
                var value = $('.checkbox');
                if (value.attr('checked') === 'checked') {
                    e.preventDefault();
                    var form = $('#formSku');
                    //var value = this.skuNameInput.val();
                    var url = this.options.url;
                    this.ajaxComplete(form, url,function () {
                        console.log("All is good");
                    });
                }
                else {
                    console.log("POST request");
                }
            }.bind(this));
        },

        ajaxComplete: function (form,url,callback) {
            var xhr = $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                showLoader: true,
                success: callback
            });

            $('#skuProduct').keyup(function (e) {
                if (typeof(xhr) != 'undefined') {
                    xhr.abort();
                }
            })
        },
    });

    return $.mage.ajaxSku;
});

