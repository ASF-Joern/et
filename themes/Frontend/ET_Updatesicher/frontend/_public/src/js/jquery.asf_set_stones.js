;(function($) {
    'use strict';

    $.plugin('asfSetStones', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;
            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfSetStones/init', [ me ]);
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

            console.log("setStones:" +$('.no_stone input').data("save"));
            var $el = this.$el;

            if($el.hasClass("is--active") || $('.asf_hidden_radio_switcher.is--active').text() === "Herrenring") {
                return;
            }

            $('.conf_stones div button.is--active').removeClass("is--active");
            $el.addClass("is--active");

            if($el.hasClass("btn_without_stones")) {
                $('.steinbesatz').each(function(i,e) {
                    if($(this).prop("checked")) {
                        $('.no_stone input').data("save", $(this).data("value"));
                        $('#custom-products--radio-12-0').prop("checked", true);
                        $('#zertStein').text("Ohne Stein/e");
                    }
                    $(this).parent().parent().css("text-decoration", "line-through");
                    $(this).attr("disabled", "disabled");
                });
                $('.no_stone input').prop("checked", true);
                $('.no_stone input').trigger('change');
            } else {

                var value = $('.no_stone input').data("save");

                $('.steinbesatz').each(function(i,e) {

                    if(value === $(this).data("value").trim()) {

                        $('.no_stone input').data("save", "");
                        $(this).prop("checked", true);
                        $('#zertStein').text($(this).data("value").replace("Brillant", "TwSi"));

                        $('#custom-products-option-12 .custom-products--radio-inline-label').each(function(i,e) {

                            if(value === $(this).text().trim()) {
                                $(this).prev().prev().prop("checked", true);
                            }

                        });
                    }

                    $(this).parent().parent().css("text-decoration", "none");
                    $(this).removeAttr("disabled");
                });

            }

            $.publish('plugin/asfSetStones/changed', [ this ]);

        },

        /**
         * Destroys the plugin.
         *
         * @returns void
         */
        destroy: function() {
            this._destroy();
        },

        number_format: function(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    });

    $(function() {
        StateManager.addPlugin('.conf_stones div button', 'asfSetStones');
    });
})(jQuery);
