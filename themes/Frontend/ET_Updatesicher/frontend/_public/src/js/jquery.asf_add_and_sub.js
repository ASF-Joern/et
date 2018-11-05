;(function($) {
    'use strict';

    $.plugin('asfAddAndSub', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;
            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfAddAndSub/init', [ me ]);
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

            var elem = e.currentTarget;
            var id = elem.dataset.value;
            var $el = $('#custom-products-option-'+id);
            var text = $el.val();
            var number = parseFloat(text.replace("mm", "")) * 10;

            var regex = new RegExp('minus');

            var step = parseFloat($el.attr("step")) * 10;
            var min = parseFloat($el.data("min")) * 10;
            var max = parseFloat($el.data("max")) * 10;

            if(!regex.test(elem.className)) {

                if((number + step) > max) {
                    return;
                }

                number = number + step;

            } else {

                if((number - step) < min) {
                    return;
                }

                number = number - step;

            }

            number = number / 10;

            text = number + "mm";

            $el.val(text);
            $el.trigger('change');

            $.publish('plugin/asfAddAndSub/changed', [ this ]);

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
        StateManager.addPlugin('.fa-plus-square', 'asfAddAndSub');
        StateManager.addPlugin('.fa-minus-square', 'asfAddAndSub');
    });
})(jQuery);
