;(function($) {
    'use strict';

    $.plugin('asfSwitchAlloyOrStone', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;
            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfSwitchAlloyOrStone/init', [ me ]);
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

            if($el.hasClass("custom-products--radio-label")) {
                $el = $el.find(':first-child').find(':first-child');
                $el.prop("checked", true);
            }

            var value = $el.data("value");

            $('.custom-products--radio-inline-label').each(function(i,e) {
                if($(this).text().trim() === value.trim()) {
                    $(this).prev().prev().prop("checked", true);
                    $(this).prev().prev().trigger('change');
                }
            });
/*
            if($el.hasClass("steinbesatz")) {
/*
                name[5] = String($el.data("stone-ordernumber")).substr(String($el.data("alloy-ordernumber")).length - 4);

                var small = $el.data("stone-image-small");
                var big = $el.data("stone-image-big");
                var big_srcset = $el.data("stone-image-original").split('.jpg')[0] + "@2x.jpg";
                var url = $el.data("stone-image-original");

                $('.pdimg').attr("src", $el.data("stone-image-certificate"));
                $('.product--image-container .image--element').data("img-small", small);
                $('.product--image-container .image--element').data("img-original", url);

                $('.product--image-container .image--element .image--media img').attr("src", big);
                $('.product--image-container .image--element .image--media img').attr("srcset", big+','+big_srcset+' 2x');

                $('meta[itemprop="productID"]').attr("content", $el.data('productid'));
                $('.entry--content').text($el.data("stone-ordernumber"));
                $('input[name="sAdd"]').val($el.data("stone-ordernumber"));
                $('.js--img-zoom--flyout').css("background", "rgb(255, 255, 255) url('" + url + "') no-repeat scroll 0px 0px");

                $.publish('plugin/asfSwitchAlloyOrStone/stoneChanged', [ this ]);

            } else {
/*
                name[2] = $el.data('value');
                name[5] = String($el.data("alloy-ordernumber")).substr(String($el.data("alloy-ordernumber")).length - 4);

                $('meta[itemprop="productID"]').attr("content", $el.data('productid'));
                $('.entry--content').text($el.data("alloy-ordernumber"));
                $('input[name="sAdd"]').val($el.data("alloy-ordernumber"));

                $.publish('plugin/asfSwitchAlloyOrStone/alloyChanged', [ this ]);

            }
/*
            $('h1.product--title').text(name.join(" "));

            var title = String($('title')).split('|');
            title[0] = name.join(" ");
            $('title').text(title.join('|'))

            window.history.replaceState('', $el.data('article-name'), $el.data('link') + "#" + window.location.href.split("#")[1]);
*/
            $.publish('plugin/asfSwitchAlloyOrStone/changed', [ this ]);

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
        StateManager.addPlugin('.legierung', 'asfSwitchAlloyOrStone');
        StateManager.addPlugin('.steinbesatz', 'asfSwitchAlloyOrStone');
        StateManager.addPlugin('#asf_custom-products-option-11 .custom-products--radio-label', 'asfSwitchAlloyOrStone');
        StateManager.addPlugin('#asf_custom-products-option-12 .custom-products--radio-label', 'asfSwitchAlloyOrStone');

    });
})(jQuery);
