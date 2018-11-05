;(function($) {
    'use strict';

    $.plugin('asfChangeFonts', {

        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;

            me._on(me.$el, 'change', $.proxy(me.onClicked, me));

            $.publish('plugin/asfChangeFonts/init', [ me ]);
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
            $el.parent().parent().parent().siblings(':first-child').css("font-family", $el.val());
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
        StateManager.addPlugin('select.font_changer', 'asfChangeFonts');
    });
})(jQuery);
