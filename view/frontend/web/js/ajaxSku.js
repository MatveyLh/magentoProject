define([
    'jquery',
    'mage/template',
    'Magento_Customer/js/customer-data',
    'jquery-ui-modules/widget',
],function($,mageTemplate,customerData){
    $.widget('mage.ajaxSku', {
        options: {
            url: '/checkout/cart/add',
            selectorSkuForm: 'formSku',
            selectorInputName: "skuProduct",
            searchUrl: '/matvey/search/search'
        },

        skuNameInput: null,

        _create : function () {
            if (this.options.selectorSkuForm.indexOf("#") === -1) {
                this.options.selectorSkuForm = "#" + this.options.selectorSkuForm;
            }
            this.minLength = 3;
            this.initDomBindings();
        },

        initDomBindings: function () {
            this.skuNameInput = $(("input[name=" + "'" +(this.options.selectorInputName) + "'" + "]"));
            $('#skuProduct').keyup(function (e) {
                e.preventDefault();

                var value = this.skuNameInput.val();
                var url = this.options.searchUrl;
                //var form = $(this);
                if (value.length >= this.minLength) {
                    //form = form.serialize();
                    this.ajaxSearch(value, url, function (data) {
                        var sections = ['cart'];
                        customerData.invalidate(sections);
                        customerData.reload(sections, true);
                        if (url === this.options.searchUrl) {
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

                            $('.product').on('click',function(event) {
                                value = event.currentTarget.children[2].innerText;
                                var input = $("input[name = 'skuProducts']");

                                $(input).val(value);
                                $(".products").hide('fast');
                            }.bind(this));
                        }
                    }.bind(this))
                }
            }.bind(this));

            $(this.options.selectorSkuForm).submit(function (e) {
                //edit selector to id and move to свойства обьекта
                var value = $('#checkbox');
                if (value.prop('checked')) {
                    e.preventDefault();
                    var form = $(this.options.selectorSkuForm);
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

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                showLoader: true,
                success: callback
            });
        },

        ajaxSearch: function (value,url,callback) {

            var xhr = $.ajax({
                type: "POST",
                url: url,
                data: {value},
                showLoader: true,
                success: callback
            });
            //TODO:: fix. move in init
            $('#skuProduct').keyup(function (e) {
                if (typeof(xhr) != 'undefined') {
                    xhr.abort();
                }
            })
        },
    });

    return $.mage.ajaxSku;
});
