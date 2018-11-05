;(function($) {
    'use strict';

    $.plugin('asfSwitchColor', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;

            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfSwitchColor/init', [ me ]);
        },

        /**
         * Event listener which will be fired when the user presses a button when the element is focused.
         *
         * The method checks if the entered keycode is in our blacklist {@link blockedKeys}
         *
         * @param {jQuery.Event} e
         * @returns {boolean}
         */
        onClicked: function(e) {

            var $el = this.$el;
            var colorName = $el.text().trim();

            if(colorName === "Palladium") {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "585er") {
                        $(this).prop("checked", true);
                    }

                    if(value === "600er" || value === "333er" || value === "750er") {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    } else {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    }
                });

            }

            if(colorName === "Platin") {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "600er") {
                        $(this).prop("checked", true);
                    }

                    if(value === "585er" || value === "333er" || value === "750er") {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    } else {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    }
                });

            }

            if(colorName.match(/gold/g) && !$('.change_ring_color div.is--active .color_text').text().match(/gold/g)) {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "333er") {
                        $(this).prop("checked", true);
                    }

                    if(value === "585er" || value === "333er" || value === "750er") {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    } else {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    }
                });

            }

            $('.change_ring_color div.is--active').removeClass("is--active");
            $el.addClass("is--active");
/*
            $('.pdimg').attr("src", $el.data("image_url_certificate"));
            var small = $el.data("image_url_small");
            var big = $el.data("image_url_big");
            var big_srcset = $el.data("image_url_big").split('.jpg')[0] + "@2x.jpg";

            // change lense image, data-img-large is used to display image in modalbox
            $('.product--image-container .image--element').attr("data-alt", $el.data('article-name'));
            $('.product--image-container .image--element').attr("data-img-small", small);
            $('.product--image-container .image--element').attr("data-img-large", big);
            $('.product--image-container .image--element').attr("data-img-original", url);

            // change product image
            $('.product--image-container .image--element .image--media img').attr("src", big);
            $('.product--image-container .image--element .image--media img').attr("srcset", big+','+big_srcset+' 2x');

            $('meta[itemprop="productID"]').attr("content", $el.data('productid'));
            $('.entry--content').text($el.data("ordernumber"));
            $('input[name="sAdd"]').val($el.data("ordernumber"));

            var catName = String($('.breadcrumb--entry.is--active a span').text()).split(' ');
            $('.breadcrumb--entry.is--active a span').text(catName[0] + " " + colorName);
            $('.breadcrumb--entry.is--active a link').attr("href",$el.data('cat-url'));
            $('.breadcrumb--entry.is--active a').attr("href", $el.data('cat-url'));

            $('h1.product--title').text($el.data('article-name'));
            window.history.replaceState('', $el.data('article-name'), $el.data('link') + "#" + window.location.href.split("#")[1]);
            */
            $.publish('plugin/asfSwitchColor/changed', [ this ]);

        },

        /**
         * Destroys the plugin.
         *
         * @returns void
         */
        destroy: function() {
            this._destroy();
        },

    });

    $(function() {

        //StateManager.addPlugin('.color_left', 'asfSwitchColor');
        //StateManager.addPlugin('.color_right', 'asfSwitchColor');
        //StateManager.addPlugin('.js--img-zoom--lens', 'asfSwitchColor');
        //StateManager.addPlugin('.image--media', 'asfSwitchColor');

        //$(document).on("click", '.js--img-zoom--lens', function(event) {
        //    $('.js--modal .content .image--element').prop('src', $('.image-slider--slide span.image--element').attr('data-img-large'));
        //});

    });
})(jQuery);
