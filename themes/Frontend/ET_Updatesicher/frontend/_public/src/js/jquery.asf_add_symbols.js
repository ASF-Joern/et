;(function($) {
    'use strict';

    $.plugin('asfAddSymbols', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;

            me._on(me.$el, 'click', $.proxy(me.onClicked, me));

            $.publish('plugin/asfAddSymbols/init', [ me ]);
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

            console.log(this.$el);

            var $el = this.$el;
            var $input = $el.parent().parent().siblings(':first-child');
            var code = 0;

            console.log($input);

            if($el.hasClass("infinity")) {
                code = "}";
            }

            if($el.hasClass("single_heart")) {
                code = "{";
            }

            if($el.hasClass("double_heart")) {
                code = "[";
            }

            if($el.hasClass("double_ring")) {
                code = "]";
            }

            $input.val($input.val() + code);
            $input.focus();
            $input.trigger('change');

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
        StateManager.addPlugin('.infinity', 'asfAddSymbols');
        StateManager.addPlugin('.single_heart', 'asfAddSymbols');
        StateManager.addPlugin('.double_heart', 'asfAddSymbols');
        StateManager.addPlugin('.double_ring', 'asfAddSymbols');
    });
})(jQuery);
