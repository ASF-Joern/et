;(function($) {
    'use strict';

    $.plugin('asfHiddenRadio', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;
            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfHiddenRadio/init', [ me ]);
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

            console.log("hiddenRadio:"+$('.no_stone input').data("save"));

            $('.asf_hidden_radio_switcher.is--active').removeClass("is--active");
            $el.addClass("is--active");
            $el.next().prop("checked", true);
            $el.trigger('change');

            if($el.text() === "Damenring") {

                $('.pair_price').addClass("is--hidden");
                $('fieldset.Herrenring').addClass("is--hidden");
                $('fieldset.Herrenring').removeClass("is--active");
                $('fieldset.Damenring').addClass("is--active");
                $('fieldset.calc_gravur_left').removeClass("is--hidden");
                $('fieldset.calc_gravur_left').addClass("is--active");
                $('fieldset.calc_gravur_left').css("width", "99%");
                $('fieldset.calc_gravur_right').removeClass("is--active");
                $('fieldset.calc_gravur_right').addClass("is--hidden");
                $('fieldset.Damenring').removeClass("is--hidden");
                $('.btn_with_stones').css("background-color","#fff");
                $('.btn_with_stones').removeAttr("disabled");

                var value = $('.no_stone input').data("save");

                $('.steinbesatz').each(function(i,e) {

                    if($('.btn_without_stones').hasClass("is--active")) {
                        return;
                    }

                    if(value === $(this).data("value").trim()) {
                        $('.no_stone input').data("save", "");
                        $(this).prop("checked", true);

                        $('#custom-products-option-12 .custom-products--radio-inline-label').each(function(i,e) {

                            if(value === $(this).text().trim()) {
                                $(this).prev().prev().prop("checked", true);
                            }

                        });
                    }

                    $(this).parent().parent().css("text-decoration", "none");
                    $(this).removeAttr("disabled");
                });

            } else if($el.text() === "Herrenring") {

                $('.pair_price').addClass("is--hidden");
                $('fieldset.Herrenring').addClass("is--active");
                $('fieldset.calc_gravur_right').addClass("is--active");
                $('fieldset.calc_gravur_right').removeClass("is--hidden");
                $('fieldset.calc_gravur_left').addClass("is--hidden");
                $('fieldset.calc_gravur_left').removeClass("is--active");
                $('fieldset.calc_gravur_right').css("width", "99%");
                $('fieldset.Herrenring').removeClass("is--hidden");
                $('fieldset.Damenring').addClass("is--hidden");
                $('fieldset.Damenring').removeClass("is--active");
                $('.btn_with_stones').removeClass("is--active");
                $('.btn_with_stones').css("background-color","#eee");
                $('.btn_without_stones').addClass("is--active");
                $('.btn_with_stones').attr("disabled", "disabled");

                $('.steinbesatz').each(function(i,e) {
                    if($(this).prop("checked")) {
                        $('.no_stone input').attr("data-save", $(this).data("value"));
                        $('#custom-products--radio-12-0').prop("checked", true);
                    }
                    $(this).parent().parent().css("text-decoration", "line-through");
                    $(this).attr("disabled", "disabled");
                });

                $('.no_stone input').prop("checked", true);
                $('.no_stone input').trigger('change');


            } else {

                $('.pair_price').removeClass("is--hidden");
                $('fieldset.calc_gravur_right').addClass("is--active");
                $('fieldset.calc_gravur_right').css("width", "48%");
                $('fieldset.calc_gravur_left').addClass("is--active");
                $('fieldset.calc_gravur_left').css("width", "48%");
                $('fieldset.calc_gravur_right').removeClass("is--hidden");
                $('fieldset.calc_gravur_left').removeClass("is--hidden");
                $('fieldset.Damenring').addClass("is--active");
                $('fieldset.Damenring').removeClass("is--hidden");
                $('fieldset.Herrenring').addClass("is--active");
                $('fieldset.Herrenring').removeClass("is--hidden");
                $('.btn_with_stones').css("background-color","#fff");
                $('.btn_with_stones').removeAttr("disabled");


                var value = $('.no_stone input').data("save");

                $('.steinbesatz').each(function(i,e) {

                    if($('.btn_without_stones').hasClass("is--active")) {
                        return;
                    }

                    if(value === $(this).data("value").trim()) {
                        $('.no_stone input').data("save", "");
                        $(this).prop("checked", true);

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

            $.publish('plugin/asfHiddenRadio/changed', [ this ]);

        },

        /**
         * Destroys the plugin.
         *
         * @returns void
         */
        destroy: function() {
            this._destroy();
        }
    });

    $(function() {
        StateManager.addPlugin('.asf_hidden_radio_switcher', 'asfHiddenRadio');
    });
})(jQuery);
