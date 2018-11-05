;(function($, window) {
    'use strict';

    $.plugin('asfRingManager', {

        //<editor-fold desc="Defaults">
        /** @object Default plugin settings */
        defaults: {

            /** @string */
            currentColor: '.change_ring_color .is--active',

            /** @string */
            colorSelector: '.change_ring_color div .color_text',

            /** @string */
            currentAlloy: '.legierung:checked',

            /** @string */
            trVisibleAlloySelector: '#asf_custom-products-option-11 label',

            /** @string */
            vrVisibleAlloySelector: '#asf_custom-products-option-3 label',

            /** @string */
            currentStone: '.steinbesatz:checked',

            /** @string */
            trVisibleStoneSelector: '#asf_custom-products-option-12 label',

            /** @string */
            trVisibleStoneList: '#asf_custom-products-option-13 label',

            /** @string */
            trCurrentStoneList: '#asf_custom-products-option-13 label.is--ative',

            /** @string */
            vrVisibleStoneSelector: '#asf_custom-products-option-4 label',

            /** @string */
            mrVisibleAlloySelector: '#asf_custom-products-option-4 label',

            /** @string */
            mrVisibleStoneSelector: '#asf_custom-products-option-5 label',

            /** @string */
            mrVisibleClaritySelector: '#asf_custom-products-option-7 label',

            /** @string */
            mrNotVisibleStoneSelector: '#custom-products-option-5',

            /** @string */
            mrNotVisibleClaritySelector: '#custom-products-option-7',

            /** @string */
            mrVisibleSizeSelector: '#custom-products-option-1',

            /** @string */
            mrProfile: '.memprofil',

            /** @string */
            currentClarity: '.reinheit:checked',

            /** @string */
            vrVisibleClaritySelector: '#asf_custom-products-option-6 label',

            /** @string */
            trNotVisibleAlloySelector: '#custom-products-option-11',

            /** @string */
            vrNotVisibleAlloySelector: '#custom-products-option-3',

            /** @string */
            trNotVisibleStoneSelector: '#custom-products-option-12',

            /** @string */
            vrNotVisibleStoneSelector: '#custom-products-option-4',

            /** @string */
            vrNotVisibleClaritySelector: '#custom-products-option-6',

            /** @string */
            visibleLeftSymbolesToAdd: '.calc_gravur_left .add_symbols:nth-child(2) span',

            /** @string */
            visibleRightSymbolesToAdd: '.calc_gravur_right .add_symbols:nth-child(2) span',

            /** @string */
            visibleLeftFontChanger: '.calc_gravur_left .select-field.font_changer select',

            /** @string */
            visibleRightFontChanger: '.calc_gravur_right .select-field.font_changer select',

            /** @string */
            trNotVisibleLeftFontChanger: '#custom-products-option-13',

            /** @string */
            trNotVisibleRightFontChanger: '#custom-products-option-14',

            /** @string */
            addition: '.conf_plus',

            /** @string */
            substraction: '.conf_minus',

            /** @string */
            saveStone: '.no_stone input',

            /** @string */
            withStones: '.btn_with_stones',

            /** @string */
            withoutStones: '.btn_without_stones',

            /** @string */
            ringChoice: '.asf_hidden_radio_switcher',

            /** @string */
            currentRingChoice: '.asf_hidden_radio_switcher.is--active',

            /** @string */
            trWomanSize: '#custom-products-option-2',

            /** @string */
            trCurrentWomanSize: '#custom-products-option-2 option:selected',

            /** @string */
            trCurrentWomanWidth: '#custom-products-option-3',

            /** @string */
            trCurrentWomanThickness: '#custom-products-option-4',

            /** @string */
            trManSize: '#custom-products-option-5',

            /** @string */
            trCurrentManSize: '#custom-products-option-5 option:selected',

            /** @string */
            trCurrentManWidth: '#custom-products-option-6',

            /** @string */
            trCurrentManThickness: '#custom-products-option-7',

            /** @string */
            trCurrentProfile: '#custom-products-option-0 input:checked',

            /** @string */
            vrCurrentSize: '#custom-products-option-0',

            /** @string */
            currentArticleID: '.buybox-top .entry--content',
            
            /** @string */
            buyButton: '.buybox--button',

            /** @string */
            vrVisibleRightSymbolesToAdd: '.verlobungsringe .add_symbols span',

            /** @string */
            prWomanSize: '.partnerringe-detail #custom-products-option-0 option:selected',

            /** @string */
            prManSize: '.partnerringe-detail #custom-products-option-2 option:selected',

            /** @string */
            price: '.price--content.content--default',

            /** @string */
            method: '',


        },

        //</editor-fold>

        //<editor-fold desc="Init">
        /**
         * Initializes the plugin and applies the necessary event listeners.
         *
         * @returns void
         */
        init: function() {
            var me = this;

            me.applyDataAttributes();

            me.$colorSelection = $(me.opts.colorSelector);
            me.$trVisibleAlloySelection = $(me.opts.trVisibleAlloySelector);
            me.$trVisibleStoneSelection = $(me.opts.trVisibleStoneSelector);
            me.$vrVisibleAlloySelection = $(me.opts.vrVisibleAlloySelector);
            me.$vrVisibleStoneSelection = $(me.opts.vrVisibleStoneSelector);
            me.$vrVisibleClaritySelection = $(me.opts.vrVisibleClaritySelector);
            me.$visibleLeftSymbolesToAdd = $(me.opts.visibleLeftSymbolesToAdd);
            me.$visibleRightSymbolesToAdd = $(me.opts.visibleRightSymbolesToAdd);
            me.$visibleLeftFontChanging = $(me.opts.visibleLeftFontChanger);
            me.$visibleRightFontChanging = $(me.opts.visibleRightFontChanger);
            me.$vrVisibleRightSymbolesToAdd = $(me.opts.vrVisibleRightSymbolesToAdd);
            me.$mrVisibleAlloySelection = $(me.opts.mrVisibleAlloySelector);
            me.$mrVisibleStoneSelection = $(me.opts.mrVisibleStoneSelector);
            me.$mrVisibleClaritySelection = $(me.opts.mrVisibleClaritySelector);
            me.$mrVisibleSizeSelection = $(me.opts.mrVisibleSizeSelector);
            me.$mrProfile = $(me.opts.mrProfile);
            // Logic merged from PriceManager
            me.$addition = $(me.opts.addition);
            me.$substraction = $(me.opts.substraction);
            me.$enableStones = $(me.opts.withStones);
            me.$disableStones = $(me.opts.withoutStones);
            me.$ringChoiceChanging = $(me.opts.ringChoice);
            me.$buyBotton = $(me.opts.buyButton);
            me.$manSize = $(me.opts.trManSize);
            me.$womanSize = $(me.opts.trWomanSize);

            me._on(me.$colorSelection, 'click', $.proxy(me.changeColor, me));
            // The reason we must use click instead of change is the ability to change the alloy over the label
            me._on(me.$trVisibleAlloySelection, 'click', $.proxy(me.changeAlloy, me));
            me._on(me.$trVisibleStoneSelection, 'click', $.proxy(me.changeStone, me));
            me._on(me.$vrVisibleAlloySelection, 'click', $.proxy(me.changeAlloy, me));

            if(String($('h1.product--title').text()).split(" ")[0].trim() === "Memoirering") {
                me._on(me.$mrVisibleAlloySelection, 'click', $.proxy(me.changeAlloy, me));
                me._on(me.$mrVisibleSizeSelection, 'change', $.proxy(me.changeSize, me));
            } else {
                me._on(me.$vrVisibleStoneSelection, 'click', $.proxy(me.changeStone, me));
            }

            me._on(me.$mrProfile, 'click', $.proxy(me.changeProfile, me));

            me._on(me.$mrVisibleStoneSelection, 'click', $.proxy(me.changeStone, me));
            me._on(me.$mrVisibleClaritySelection, 'click', $.proxy(me.changeClarity, me));
            me._on(me.$vrVisibleClaritySelection, 'click', $.proxy(me.changeClarity, me));
            me._on(me.$visibleLeftSymbolesToAdd, 'click', $.proxy(me.addSymbols, me));
            me._on(me.$visibleRightSymbolesToAdd, 'click', $.proxy(me.addSymbols, me));
            me._on(me.$visibleLeftFontChanging, 'change', $.proxy(me.changeFont, me));
            me._on(me.$visibleRightFontChanging, 'change', $.proxy(me.changeFont, me));
            me._on(me.$vrVisibleRightSymbolesToAdd, 'click', $.proxy(me.addSymbols, me));

            // Events for the PriceManager Logic
            me._on(me.$addition, 'click', $.proxy(me.add, me));
            me._on(me.$substraction, 'click', $.proxy(me.sub, me));
            me._on(me.$enableStones, 'click', $.proxy(me.enableStones, me));
            me._on(me.$disableStones, 'click', $.proxy(me.disableStones, me));
            me._on(me.$ringChoiceChanging, 'click', $.proxy(me.changeRingChoice, me));
            me._on(me.$buyBotton, 'click', $.proxy(me.addArticle, me));

            // For Error handling
            me._on(me.$manSize, 'change', $.proxy(me.errorHandling, me));
            me._on(me.$womanSize, 'change', $.proxy(me.errorHandling, me));
            me._on($(me.opts.vrCurrentSize), 'change', $.proxy(me.errorHandling,me));

            $.publish('plugin/asfRingManager/init', [ me ]);

            if(String($('h1.product--title').text()).split(" ")[0] !== "ASF" && String($('h1.product--title').text()).split(" ")[0] === "Partnerringe") {
                me.getNewRing(me);
            }

            me.getNewPrice(me);
        },

        //</editor-fold>

        //<editor-fold desc="RingManager">

        /**
         * Event listener which will be fired when the user click on a profile button in memoire rings.
         *
         * The method switch the article if it is needed and publish the event: article/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeProfile: function(e) {

            var me = this, $el = $(e.target);
            console.log("triggered");
            if($el.hasClass("p3")) {
                $el.addClass('is--active');
                $('.memprofil.p4').removeClass('is--active');
            }

            if($el.hasClass("p4")) {
                $el.addClass('is--active');
                $('.memprofil.p3').removeClass('is--active');
            }

            $.publish('plugin/asfRingManager/article/changed', [ me ]);
            me.getNewRing(me);

            return true;

        },

        /**
         * Event listener which will be fired when the user click on a ring color/material.
         *
         * The method switch the color if it is needed and publish the event: color/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeColor: function(e) {
            var me = this, $el = $(e.target), oldColorName = $(me.opts.currentColor + " span").text();

            me.opts.method = 'changeColor';

            $(me.opts.currentColor).removeClass('is--active');
            $el.parent().addClass('is--active');

            // ignore click on the same color
            if(oldColorName === $el.text()) {
                return false;
            }

            if($el.text() === "Palladium") {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "585er") {
                        $(this).prop("checked", true);
                        $.publish('plugin/asfRingManager/alloy/changed', [ me ]);
                    }

                    if(value === "600er" || value === "333er" || value === "750er" || value === "925er") {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    } else {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    }
                });

            }

            if($el.text() === "Platin") {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "600er") {
                        $(this).prop("checked", true);
                        $.publish('plugin/asfRingManager/alloy/changed', [ me ]);
                    }

                    if(value === "585er" || value === "333er" || value === "750er" || value === "925er") {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    } else {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    }
                });

            }

            if($el.text().match(/gold/g) && !oldColorName.match(/gold/g)) {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "333er") {
                        $(this).prop("checked", true);
                        $.publish('plugin/asfRingManager/alloy/changed', [ me ]);
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

            if($el.text() === "Silber") {

                $('.legierung').each(function(i,e) {
                    var value = $(this).data('value');
                    var $parent = $(this).parent().parent().parent();

                    if(value === "925er") {
                        $(this).prop("checked", true);
                        $.publish('plugin/asfRingManager/alloy/changed', [ me ]);
                    }

                    $('#change_custom-products--radio-7-0').prop('checked',true);

                    if(value === "585er" || value === "333er" || value === "750er" || value === "600er" || value === "950er") {
                        $parent.removeClass("is--active");
                        $parent.addClass("is--hidden");
                    } else {
                        $parent.addClass("is--active");
                        $parent.removeClass("is--hidden");
                    }
                });

            }

            $.publish('plugin/asfRingManager/color/changed', [ me ]);
            me.getNewRing(me);


            return true;

        },

        /**
         * Event listener which will be fired when the user click on a ring alloy.
         *
         * The method switch the alloy and publish the event: alloy/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeAlloy: function(e) {

            var me = this, $el = $(e.target), oldAlloyName = $(me.opts.currentAlloy).data('value'), ring = String($('h1.product--title').text()).split(" "),
            changed = false;

            me.opts.method = 'changeAlloy';

            if(ring[0] === "Trauringe") {
                var notVisibleAlloySelector = me.opts.trNotVisibleAlloySelector + ' div';
            }
            if(ring[0] === "Verlobungsring") {
                var notVisibleAlloySelector = me.opts.vrNotVisibleAlloySelector + ' div';
            }

            // If the user clicks directly on the input field
            if($el.hasClass('legierung')) {
                $(notVisibleAlloySelector).each(function(i,e){
                    if($(this).find(':last-child').text().trim() === $el.data('value')) {
                        $(this).find(':first-child').prop('checked', true);
                    }
                });
            }

            var newAlloyName = $el.find('input').data('value');

            // ignore click on the same alloy
            if(oldAlloyName === newAlloyName) {
                return false;
            }

            $el.find('input').prop('checked', true);

            $(notVisibleAlloySelector).each(function(i,e){
                 if($(this).find(':last-child').text() === newAlloyName) {
                     $(this).find(':first-child').prop('checked', true);
                 }
            });

            $.publish('plugin/asfRingManager/alloy/changed', [ me ]);
            me.getNewRing(me);
            return true;

        },

        /**
         * Event listener which will be fired when the user click on a ring stone.
         *
         * The method switch the stone and publish the event: stone/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeStone: function(e) {
            var me = this, $el = $(e.target), oldStoneName = $(me.opts.currentStone).data('value'), ring = String($('h1.product--title').text()).trim().split(" "),
            changeAllowed = $(me.opts.withStones).hasClass('is--active');



            me.opts.method = 'changeStone';

            if(ring[0].trim() === "Trauringe") {
                var notVisibleStoneSelector = me.opts.trNotVisibleStoneSelector + ' div';
                console.log(changeAllowed);
                if(!changeAllowed) {
                    return false;
                }
            }

            if(ring[0].trim() === "Verlobungsring") {
                var notVisibleStoneSelector = me.opts.vrNotVisibleStoneSelector + ' div';
            }

            if(ring[0].trim() === "Memoirering") {
                var notVisibleStoneSelector = me.opts.mrNotVisibleStoneSelector + ' div';
            }

            $(me.opts.trVisibleStoneList).each(function(i,e) {

                if($(this).text().trim() === $el.data('value') || $(this).text().trim() === $el.find('input').data('value')) {
                    $(this).addClass("is--active");
                    $(this).removeClass("is--hidden");
                    $('#table_stone').text($(this).text().replace("1 x ",""));
                } else {
                    $(this).removeClass("is--active");
                    $(this).addClass("is--hidden");
                }
            });

            // If the user clicks directly on the input field
            if($el.hasClass('steinbesatz')) {

                $(notVisibleStoneSelector).each(function(i,e){

                    if($(this).find(':last-child').text().trim() === $el.data('value')) {
                        $(this).find(':first-child').prop('checked', true);
                        $(this).trigger('change');
                    }

                });

                $.publish('plugin/asfRingManager/stone/changed', [ me ]);
                me.getNewRing(me);
                return true;

            }

            var newStoneName = $el.find('input').data('value');

            // ignore click on the same stone
            if(oldStoneName === newStoneName) {
                return false;
            }

            $('#table_stone').text(newStoneName.replace("1 x ",""));

            $el.find('input').prop('checked', true);

            $(notVisibleStoneSelector).each(function(i,e){
                if($(this).find(':last-child').text().trim() === newStoneName) {
                    $(this).find(':first-child').prop('checked', true);
                    $(this).trigger('change');
                }
            });

            $.publish('plugin/asfRingManager/stone/changed', [ me ]);
            me.getNewRing(me);

        },

        /**
         * Event listener which will be fired when the user click on a clarity.
         *
         * The method switch the stone and publish the event: stone/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeClarity: function(e) {
            var me = this, $el = $(e.target), oldClarityName = $(me.opts.currentClarity).data('value'), ring = String($('h1.product--title').text()).trim().split(" ");

            me.opts.method = 'changeClarity';

            if(ring[0].trim() === "Verlobungsring" || ring[0].trim() === "Memoirering") {
                if(ring[0].trim() === "Memoirering") {
                    var notVisibleClaritySelector = me.opts.mrNotVisibleClaritySelector + ' div';
                } else {
                    var notVisibleClaritySelector = me.opts.vrNotVisibleClaritySelector + ' div';
                }

            } else {
                return false;
            }

            if($el.hasClass("tooltip")) {
                $el = $el.parent();
            }

            // If the user clicks directly on the input field
            if($el.hasClass('reinheit')) {
                $(notVisibleClaritySelector).each(function(i,e){
                    if($(this).find(':last-child').text().trim() === $el.data('value')) {
                        $(this).find(':first-child').prop('checked', true);
                        $(this).trigger('change');
                        $('#zertQuality').text($el.data('value'));

                        if($el.data('value').trim() === "Zirkonia") {
                            $('#table_color').html('weiß <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4> </div><div class="tooltip-content">Alle unsere verwendeten Schmucksteine sind in feinem weiß.</div></div></div>');
                            $('#table_clarity').html('Zirkonia <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Zirkonia</h4> </div><div class="tooltip-content">Zirkoniasteine sind künstlich hergestellte Schmucksteine. Sie sind kaum von echten Diamanten zu unterscheiden und strahlen ebenso wunderschön.</div></div></div>');
                            $.publish('plugin/asfRingManager/clarity/changed', [ this ]);
                            me.getNewPrice(me);
                            return true;
                        } else {
                            $('#table_color').html(String($el.data('value')).split("/")[0] + ' ' + ' <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4> </div><div class="tooltip-content">Alle unsere verwendeten Schmucksteine sind in feinem weiß.</div></div></div>');
                            $('#table_clarity').html(String($el.data('value')).split("/")[1] + ' ' + ' <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Reinheit</h4> </div><div class="tooltip-content">Die Reinheit bezieht sich auf die Klarheit des Edelsteins. Dabei redet man von SI (kleine Einschlüsse), VS (sehr kleine Einschlüsse)und IF (lupenrein), welches die hochwertigste Reinheit ist.</div></div></div>');
                            $.publish('plugin/asfRingManager/clarity/changed', [ this ]);
                            me.getNewPrice(me);
                            return true;
                        }

                    }
                });
                $.publish('plugin/asfRingManager/clarity/changed', [ this ]);
                me.getNewPrice(me);
                return true;
            }

            var newClarityName = $el.find('input').data('value');

            // ignore click on the same clarity
            if(oldClarityName === newClarityName) {
                return false;
            }

            $el.find('input').prop('checked', true);

            $(notVisibleClaritySelector).each(function(i,e){
                if($(this).find(':last-child').text() === newClarityName) {
                    $(this).find(':first-child').prop('checked', true);
                    $(this).trigger('change');
                }
            });

            if($el.find('input').data('value').trim() === "Zirkonia") {
                $('#table_color').html('weiß <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4> </div><div class="tooltip-content">Alle unsere verwendeten Schmucksteine sind in feinem weiß.</div></div></div>');
                $('#table_clarity').html('Zirkonia <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Zirkonia</h4> </div><div class="tooltip-content">Zirkoniasteine sind künstlich hergestellte Schmucksteine. Sie sind kaum von echten Diamanten zu unterscheiden und strahlen ebenso wunderschön.</div></div></div>');
                $.publish('plugin/asfRingManager/clarity/changed', [ this ]);
                me.getNewPrice(me);
                return true;
            } else {
                $('#table_color').html(String($el.data('value')).split("/")[0] + ' ' + ' <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4> </div><div class="tooltip-content">Alle unsere verwendeten Schmucksteine sind in feinem weiß.</div></div></div>');
                $('#table_clarity').html(String($el.data('value')).split("/")[1] + ' ' + ' <div class="tooltip">[?]<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Reinheit</h4> </div><div class="tooltip-content">Die Reinheit bezieht sich auf die Klarheit des Edelsteins. Dabei redet man von SI (kleine Einschlüsse), VS (sehr kleine Einschlüsse)und IF (lupenrein), welches die hochwertigste Reinheit ist.</div></div></div>');
                $.publish('plugin/asfRingManager/clarity/changed', [ this ]);
                me.getNewPrice(me);
                return true;
            }

        },

        /**
         * Event listener which will be fired when the user click on a engraving symbol.
         *
         * The method switch the stone and publish the event: engraving/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        addSymbols: function(e) {
            var $el = $(e.target), $input = $el.parent().parent().prev();

            if($el.hasClass('single_heart')) {
                $input.val($input.val() + "{");
            } else if($el.hasClass('double_heart')) {
                $input.val($input.val() + "[");
            } else if($el.hasClass('double_ring')) {
                $input.val($input.val() + "]");
            } else if($el.hasClass('infinity')) {
                $input.val($input.val() + "}");
            } else {
                return false;
            }

            $input.trigger('change');
            $.publish('plugin/asfRingManager/engraving/changed', [ this ]);

            return true;

        },

        /**
         * Event listener which will be fired when the user change the font.
         *
         * The method switch the stone and publish the event: engraving/changed
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeFont: function(e) {
            var me = this, $el = $(e.target), $input = $el.parent().parent().parent().prev().prev(), ring = String($('h1.product--title').text()).split(" ");
            $input.css('font-family',$el.children(':selected').val());

            if(ring[0].trim() === "Partnerringe" || ring[2] === "Partnerringe") {

            } else if(ring[0].trim() === "Verlobungsring") {

            } else if(ring[0].trim() === "Trauringe") {
                if($input.attr('id') === "custom-products-option-8") {
                    var $hiddenRadio = $(me.opts.trNotVisibleLeftFontChanger + ' input');
                } else {
                    var $hiddenRadio = $(me.opts.trNotVisibleRightFontChanger + ' input');
                }
            } else if(ring[0].trim() === "Memoirenring") {

            } else {
                return false;
            }

            $hiddenRadio.each(function(i,e){
                if($(this).next().next().text().trim() === $el.children(':selected').data('value').trim()) {
                    $(this).prop('checked', true);
                }
            });

            $.publish('plugin/asfRingManager/font/changed', [ me ]);

            return true;

        },

        /**
         * Event listener which will be fired when the event is called by color,stone/changed
         *
         * The method switch the article pictures and publish the event: newRing/required
         *
         * @param {Event} me(this)
         * @returns {boolean}
         */
        getNewRing: function(me) {

            var ring = String($('h1.product--title').text()).trim().split(" "), kranz = "", profile = "";

            if(ring[0].trim() === "Partnerringe" || ring[2] === "Partnerringe") {

            } else if(ring[0].trim() === "Verlobungsring") {
                var articleName = ring[0].trim() + " " + ring[1] + " " + $(me.opts.currentAlloy).data('value') + " " +
                    $(me.opts.currentColor + " span").text();
                var stone = $(me.opts.currentStone).data('value');
                if(stone === "Ohne Stein/e") {
                    stone = $('.no_stone input').data("save");
                }
            } else if(ring[0].trim() === "Trauringe") {
                if(ring.length === 6) {
                    var articleName = ring[0].trim() + " " + ring[1] + " " + $(me.opts.currentAlloy).data('value') + " " +
                        $(me.opts.currentColor + " span").text();
                }
                if(ring.length === 7) {
                    var articleName = ring[0].trim() + " " + ring[1] + " " + ring[2] + " " + $(me.opts.currentAlloy).data('value') + " " +
                        $(me.opts.currentColor + " span").text();
                }
                var stone = $(me.opts.currentStone).data('value');
                if(stone === "Ohne Stein/e") {
                    stone = $('.no_stone input').data("save");
                }
            } else if(ring[0].trim() === "Memoirering") {
                var articleName = ring[0].trim() + " " + ring[1] + " " + $(me.opts.currentAlloy).data('value') + " " +
                    $(me.opts.currentColor + " span").text();
                var stone = $(me.opts.currentStone).data('value');
                kranz = $(me.opts.currentRingChoice).find('span').text();
                if($(me.opts.mrProfile + ".is--active").hasClass("p3")) {
                    profile = 3;
                }
                if($(me.opts.mrProfile + ".is--active").hasClass("p4")) {
                    profile = 4;
                }
            } else {
                return false;
            }

            console.log("Neuer Ring angefordert von: " + me.opts.method);

            $.ajax({
                url: location.protocol + "//" + window.location.hostname + "/widgets/AsfRingManager",
                data: {"articleName" : articleName, "stone" : stone, "kranz" : kranz, "profile": profile,"hash": window.location.hash.substring(1)},
                method: "post",
                dataType: 'json',
                success: function(data) {
                    var big_srcset = data.big.split('.jpg')[0] + "@2x.jpg", big_srcset2 = data.big.split('.jpg')[0] + "@2x.jpg",
                        articleParts = String(data.articleName).replace("ss","ß").split(" ");

                    if(data.categoryUrl === "") {

                        // Change lense image, data-img-large is used to display image in modalbox
                        $('.product--image-container .image--element').attr("data-img-small", data.articleUrl);
                        $('.product--image-container .image--element').attr("data-img-large", data.articleUrl);
                        $('.product--image-container .image--element').attr("data-img-original", data.articleUrl);

                        $('.image-slider--thumbnails-slide a img').first().attr("srcset",data.articleUrl);
                        $('.image-slider--thumbnails-slide a img').first().attr("src",data.articleUrl);
                        $('.js--modal.sizing--auto .content .image-slider--thumbnails-slide a img').first().attr("srcset",data.articleUrl);

                        // Change product image
                        $('.product--image-container .image--element .image--media img').attr("src", data.articleUrl);
                        $('.product--image-container .image--element .image--media img').attr("srcset", data.big+','+big_srcset2+' 2x');

                        return false;
                    }

                    setTimeout(function(){
                        var title = $('title').text().split("|")[1];
                        $('title').text(data.articleName + " | " + title);
                        window.history.replaceState('',
                            document.title,
                            data.articleUrl + "#" + window.location.href.split("#")[1]
                        );
                    },350);

                    // If we are in a subcategory the breadcrumb must be change too
                    if($('.breadcrumb--entry').length == 3) {
                        $('.breadcrumb--entry.is--active a span').text(articleParts[0] + " " + articleParts[3]);
                        $('.breadcrumb--entry.is--active a link').attr("href",data.categoryUrl);
                        $('.breadcrumb--entry.is--active a').attr("href", data.categoryUrl);
                    }

                    $('h1.product--title').text(data.articleName);
                    $('.product--properties.desc_box_table h2.article_name').text(data.articleName + " Details");
                    $('.pdimg').attr('src', data.certificate);

                    if(articleParts[0].trim() === "Verlobungsring") {

                        // VR details table
                        $('#table_leg').text(articleParts[2]);
                        $('#table_mat').text(articleParts[3]);
                        $('.articleName').text(String(data.articleName).replace("ss","ß"));
                        $('#table_width').html(data.width + "mm " + String($('#table_width').html()).split("mm")[1]);
                        $('#table_weight').html("ca. " + me.number_format(data.weight,2,",",".") + "g" + String($('#table_weight').html()).split("g")[1]);
                    }

                    if(articleParts[0].trim() === "Memoirering") {

                        // VR details table
                        $('#table_leg').text(articleParts[2]);
                        $('#table_mat').text(articleParts[3]);
                        $('.articleName').text(String(data.articleName).replace("ss","ß"));
                        $('#table_width').html(data.width + "mm " + String($('#table_width').html()).split("mm")[1]);
                        $('#table_height').html(data.height + "mm " + String($('#table_height').html()).split("mm")[1]);
                    }

                    // Change lense image, data-img-large is used to display image in modalbox
                    $('.product--image-container .image--element').attr("data-alt", data.articleName);
                    $('.product--image-container .image--element').attr("data-img-small", data.original);
                    $('.product--image-container .image--element').attr("data-img-large", data.original);
                    $('.product--image-container .image--element').attr("data-img-original", data.original);
                    //$('.image-slider--thumbnails-slide a img').first().attr("title","Vorschau:" + String(data.articleName).toLowerCase().replace(" ","-"));
                    $('.image-slider--thumbnails-slide a img').first().attr("srcset",data.original);
                    $('.image-slider--thumbnails-slide a img').first().attr("src",data.original);
                    $('.js--modal.sizing--auto .content .image-slider--thumbnails-slide a img').first().attr("srcset",data.original);

                    // Change product image
                    $('.product--image-container .image--element .image--media img').attr("src", data.original);
                    $('.product--image-container .image--element .image--media img').attr("srcset", data.original);

                    if(articleParts[0] === "Memoirering") {
                        $('meta[itemprop="productID"]').attr("content", data.dID);
                    } else {
                        $('meta[itemprop="productID"]').attr("content", data.articleID);
                    }

                    $('.entry--content').text(data.ordernumber);
                    $('input[name="sAdd"]').val(data.ordernumber);

                    // Certificate
                    if(articleParts.length === 7) {
                        $('#zertMaterial').text(articleParts[3] + " " + articleParts[4]);
                        $('#table_matleg').text(articleParts[3] + " " + articleParts[4]);
                    } else {
                        $('#zertMaterial').text(articleParts[2] + " " + articleParts[3]);
                        $('#table_matleg').text(articleParts[2] + " " + articleParts[3]);
                    }

                    // Add new min max values for width and thickness also check if we need to change the current configuration
                    $('#custom-products-option-3').attr('min', data.minWidth);
                    $('#custom-products-option-3').attr('max', data.maxWidth);
                    $('#custom-products-option-4').attr('min', data.minThickness);
                    $('#custom-products-option-4').attr('max', data.maxThickness);

                    var currentWidth = String($('#custom-products-option-3').val()).trim(), currentThickness = String($('#custom-products-option-4').val()).trim();
                    var fWidth = parseFloat(currentWidth.substring(0,currentWidth.trim().length-2));
                    var fThickness = parseFloat(currentThickness.substring(0,currentThickness.trim().length-2));

                    if(fWidth < parseFloat(data.minWidth)) {
                        $('#custom-products-option-3').val(data.minWidth + "mm");
                    }
                    if(fWidth > parseFloat(data.maxWidth)) {
                        $('#custom-products-option-3').val(data.maxWidth + "mm");
                    }

                    if(fThickness < parseFloat(data.minThickness)) {
                        $('#custom-products-option-4').val(data.minThickness + "mm");
                    }
                    if(fThickness > parseFloat(data.maxThickness)) {
                        $('#custom-products-option-4').val(data.maxThickness + "mm");
                    }

                    $('#zertWeight').text(me.number_format(data.ct.replace(",",".").replace("ct.",""),2,",",".") + "ct.");

                    if(data.netCt >= 0.3) {
                        $('.gia-zertifikat').removeClass('is--hidden');
                    } else {
                        $('.gia-zertifikat').addClass('is--hidden');
                    }

                    me.getNewPrice(me);
                }
            });



        },

        /**
         * Event listener which will be fired when the size is changed
         *
         * The method remove the class has--error
         *
         * @param {Event} e
         * @returns {void}
         */
        errorHandling: function(e) {
            var me = this, $el = $(e.target);
            $el.removeClass("has--error");
        },
        //</editor-fold>

        //<editor-fold desc="PriceManager">
        /**
         * Event listener which will be fired when the user click on a addition icon.
         *
         * The method add over attribute fields min, max and step the possible result
         *
         * @hint A workaround is needed to protect for rounding failure
         * @param {Event} e
         * @returns {boolean}
         */
        add: function(e) {
            var me = this, $el = $(e.target), $input = $el.prev(), step = String($input.data("step")), max = String($input.data('max')),
                value = $input.val();

            value = parseFloat(value.substring(0,value.length-2)) * 10;
            step = parseFloat(step.trim()) * 10;
            max = parseFloat(max.trim()) * 10;

            if((value-step) > max) {
                return false;
            }

            $input.val(((value + step) / 10) + "mm");
            $input.trigger('change');

            $.publish('plugin/asfRingManager/' + $input.attr('id') + '/addition', [ me ]);

            me.getNewPrice(me);

            return true

        },

        /**
         * Event listener which will be fired when the user click on a substraction icon.
         *
         * The method substract over attribute fields min, max and step the possible result
         *
         * @hint A workaround is needed to protect for rounding failure
         * @param {Event} e
         * @returns {boolean}
         */
        sub: function(e) {
            var me = this, $el = $(e.target), $input = $el.next(), min = String($input.data('min')), step = String($input.data("step")),
                value = $input.val();

            value = parseFloat(value.substring(0,value.length-2)) * 10;
            min = parseFloat(min.trim()) * 10;
            step = parseFloat(step.trim()) * 10;

            if((value-step) < min) {
                return false;
            }

            $input.val(((value - step) / 10) + "mm");
            $input.trigger('change');

            $.publish('plugin/asfRingManager/' + $input.attr('id') + '/substraction', [ me ]);

            me.getNewPrice(me);

            return true

        },

        /**
         * Event listener which will be fired when the user click on the with stones button.
         *
         * The method get restore the saved stone if "Paarringe" is active
         *
         * @param {Event} e
         * @returns {boolean}
         */
        enableStones: function(e) {
            var me = this, $el = $(e.target), save = $(me.opts.saveStone).data('save'), stoneParts = save.split(' ');

            me.opts.method = 'enableStones';

            if($el.hasClass('is--active')) {
                return false;
            }

            $el.addClass('is--active');
            $(me.opts.withoutStones).removeClass('is--active');

            $(me.opts.trVisibleStoneSelector + ' input').each(function(i,e){
                if($(this).data('value') === save) {
                    $(this).prop('checked', true);
                }
                $(this).removeAttr('disabled');
                $(this).parent().parent().css('text-decoration','none');
            });
            $('#table_stone').css('text-decoration','none');

            $('#zertWeight').text((parseInt(stoneParts[0]) * parseFloat(String(stoneParts[2].replace(",",".")).replace("ct."))) + "ct.");
            $('#zertRefinement').text(stoneParts[3]);
            $('#zertStone').text("Diamant");
            $('#zertQuality').text("G/Si");

            $(me.opts.trNotVisibleStoneSelector + ' div').each(function(i,e){
                if($(this).find(':last-child').text().trim() === save.trim()) {
                    $(this).find(':first-child').prop('checked', true);
                    $(this).trigger('change');
                }
            });

            $.publish('plugin/asfRingManager/stones/enable', [ me ]);

            me.getNewPrice(me);

            return true

        },

        /**
         * Event listener which will be fired when the user click on the without stones button.
         *
         * The method save the current stone and set no stone if "Paarringe" or "Damenring" is active
         *
         * @param {Event} e
         * @returns {boolean}
         */
        disableStones: function(e) {
            var me = this, $el = $(e.target), $save = $(me.opts.saveStone), current = $(me.opts.currentStone).data('value');

            me.opts.method = 'disableStones';

            if($el.hasClass('is--active')) {
                return false;
            }

            $el.addClass('is--active');
            $(me.opts.withStones).removeClass('is--active');

            $save.prop('checked', true);
            $save.data('save',current);

            $(me.opts.trVisibleStoneSelector + ' input').each(function(i,e){
                if($(this).data('value') === $save.data('value')) {
                    $(this).prop('checked', true);
                }
                $(this).attr('disabled', 'disabled');
                $(this).parent().parent().css('text-decoration','line-through');
            });

            $('#table_stone').css('text-decoration','line-through');

            $('#zertWeight').text("-");
            $('#zertRefinement').text("-");
            $('#zertStone').text("-");
            $('#zertQuality').text("-");

            $("#custom-products--radio-12-0").prop("checked",true);

            $(me.opts.trNotVisibleStoneSelector + ' div').each(function(i,e){
                if($(this).find(':last-child').text() === $save.data('value')) {
                    $(this).find(':first-child').prop('checked', true);
                    $(this).trigger('change');
                }
            });

            $.publish('plugin/asfRingManager/stones/disable', [ me ]);

            $('#custom-products-option-10').trigger('change');
            me.getNewPrice(me);

            return true

        },

        /**
         * Event listener which will be fired when the user click on "Paarringe","Damenring" or "Herrenring.
         *
         * The method regulate the hidden radios which say both rings or one of them
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeRingChoice: function(e) {
            var me = this, $el = $(e.target), $current = $(me.opts.currentRingChoice);

            if($current.text() === $el.text()) {
                return false;
            }

            me.opts.method = 'changeRingChoice';

            if(String($('h1.product--title').text()).trim().split(" ")[0].trim() === "Memoirering") {
                var txt = $el.find('span').text();

                if($el.hasClass("memprofil")) {
                    return false;
                }

                $current.removeClass('is--active');
                $el.addClass('is--active');
                me.getNewRing(me);

            } else {

                if($el.text() === "Herrenring") {

                    $('.conf_stones').fadeOut('slow');
                    $('.ring_group.Damenring').fadeOut('slow');
                    $(me.opts.trCurrentWomanSize).parent().val("");
                    $('.ring_group.Herrenring').fadeIn('slow');
                    $('.calc_gravur_left').fadeOut('slow');
                    $('.calc_gravur_right').fadeIn('slow');
                    $('.calc_gravur_right').css('width','99%');

                    $(me.opts.withStones).css('background-color','#eee');
                    me.disableStones({target: $(me.opts.withoutStones)});
                }

                if(($el.text() === "Damenring" || $el.text() === "Paarringe")) {

                    $('.conf_stones').fadeIn('slow');
                    $('.ring_group.Damenring').fadeIn('slow');
                    $('.calc_gravur_left').fadeIn('slow');

                    if($el.text() === "Damenring") {

                        $('.calc_gravur_left').css('width','99%');
                        $('.calc_gravur_right').fadeOut('slow');
                        $(me.opts.trCurrentManSize).parent().val("");
                        $('.ring_group.Herrenring').fadeOut('slow');
                    }
                    if($el.text() === "Paarringe") {

                        $('.calc_gravur_left').css('width','48%');
                        $('.calc_gravur_right').css('width','48%');
                        $('.calc_gravur_right').fadeIn('slow');
                        $('.conf_stones').fadeIn('slow');
                        $('.ring_group.Herrenring').fadeIn('slow');

                    }

                    if($(me.opts.saveStone).data('save') !== undefined) {
                        $(me.opts.withStones).css('background-color','#fff');
                        $('.btn_with_stones').addClass("is--active");
                        $('.btn_without_stones').removeClass("is--active");
                        me.enableStones(me);
                    }

                }

                $el.next().prop('checked', true);
                $el.next().trigger('change');
                $el.addClass('is--active');
                $current.removeClass('is--active');

                $.publish('plugin/asfRingManager/ringChoice/made', [ me ]);

            }

            me.getNewPrice(me);

            return true;

        },

        /**
         * Event listener which will be fired when the user change the ring size
         *
         * @param {Event} e
         * @returns {boolean}
         */
        changeSize: function(e) {
            var me = this;
            me.getNewPrice(me);
        },

        /**
         * Event listener which will be fired when the user click on the buy button.
         *
         * The method check if all required fields are filled
         *
         * @param {Event} e
         * @returns {boolean}
         */
        addArticle: function(e) {

            var me = this, $el = $(e.target), $current = $(me.opts.currentRingChoice), $wSize = $(me.opts.trCurrentWomanSize),
                $mSize = $(me.opts.trCurrentManSize), $wSelect = $(me.opts.trWomanSize), $mSelect = $(me.opts.trManSize),
                ring = String($('h1.product--title').text()).trim().split(" ")[0];
            e.preventDefault();


            if(ring === "Verlobungsring") {
                if($(me.opts.vrCurrentSize + ' option:selected').val() === "") {
                    $(me.opts.vrCurrentSize).addClass("has--error");
                    $(me.opts.vrCurrentSize).focus();
                    return false;
                }

                $el.submit();

            }

            if(ring === "ASF" || ring === "Partnerringe") {
                if($(me.opts.prWomanSize).val() === "" && $(me.opts.ManSize).val() === "") {
                    $(me.opts.prWomanSize).parent().addClass("has--error");
                    $(me.opts.prManSize).parent().addClass("has--error");
                    $(me.opts.prWomanSize).parent().focus();
                    return false;
                }

                if($(me.opts.prWomanSize).val() === "") {
                    $(me.opts.prWomanSize).parent().addClass("has--error");
                    $(me.opts.prWomanSize).parent().focus();
                    return false;
                }

                if($(me.opts.prManSize).val() === "") {
                    $(me.opts.ManSize).parent().addClass("has--error");
                    $(me.opts.prManSize).parent().focus();
                    return false;
                }

                $el.submit();

            }

            if($current.text() === "Paarringe") {

                if($wSize.val() === "") {
                    $wSelect.addClass("has--error");
                    $wSelect.focus();
                } else {
                    $wSelect.removeClass("has--error");
                }

                if($mSize.val() === "") {
                    $mSelect.addClass("has--error");
                    $mSelect.focus();
                } else {
                    $mSelect.removeClass("has--error");
                }

                if($wSize.val() === "" || $mSize.val() === "") {
                    return false;
                }

            }

            if($current.text() === "Damenring") {

                if($wSize.val() === "") {
                    $wSelect.addClass("has--error");
                    $wSelect.focus();
                    return false;
                } else {
                    $wSelect.removeClass("has--error");
                }

            }

            if($current.text() === "Herrenring") {

                if($mSize.val() === "") {
                    $mSelect.addClass("has--error");
                    $mSelect.focus();
                    return false;
                } else {
                    $mSelect.removeClass("has--error");
                }

            }

            $el.submit();

        },

        /**
         * Event listener which will be fired when the event is called by color,stone/changed
         *
         * The method will set a new price
         *
         * @param {Event} me(this)
         * @returns {boolean}
         */
        getNewPrice: function(me) {

            var womanWidth = $(me.opts.trCurrentWomanWidth).val(), manWidth = $(me.opts.trCurrentManWidth).val(),
                womanThickness = $(me.opts.trCurrentWomanThickness).val(), manThickness = $(me.opts.trCurrentManThickness).val(),
                withStones = $(me.opts.withStones).hasClass('is--active'), stone = $(me.opts.currentStone).data('value'),
                alloy = $(me.opts.currentAlloy).data('value'), color = $(me.opts.currentColor).find('span').text(), ringQuantity = 2,
                profile = $(me.opts.trCurrentProfile).data('value'), articleID = $(me.opts.currentArticleID).prev().attr('content'),
                area = 0, currentClarity = $(me.opts.currentClarity).data('value'), verlobungsring = "false", memoirering = "false", size = "";

            if($(me.opts.currentRingChoice).text() === "Paarringe") {

                ringQuantity = 2;
                womanWidth = womanWidth.substring(0,womanWidth.length-2);
                womanThickness = womanThickness.substring(0,womanThickness.length-2);
                manWidth = manWidth.substring(0,manWidth.length-2);
                manThickness = manThickness.substring(0,manThickness.length-2);

                area = parseFloat(womanWidth) * parseFloat(womanThickness) + parseFloat(manWidth) * parseFloat(manThickness);

            }

            if($(me.opts.currentRingChoice).text() === "Damenring") {

                ringQuantity = 1;
                womanWidth = womanWidth.substring(0,womanWidth.length-2);
                womanThickness = womanThickness.substring(0,womanThickness.length-2);
                area = parseFloat(womanWidth) * parseFloat(womanThickness);

            }

            if($(me.opts.currentRingChoice).text() === "Herrenring") {

                ringQuantity = 1;
                manWidth = manWidth.substring(0,manWidth.length-2);
                manThickness = manThickness.substring(0,manThickness.length-2);
                area = parseFloat(manWidth) * parseFloat(manThickness);

            }



            if(String($('h1.product--title').text()).trim().split(" ")[0].trim() === "Verlobungsring") {
                verlobungsring = "true";

                ringQuantity = 1;
                switch(currentClarity) {
                    case 'G/SI':
                        currentClarity = 'g-si';
                        break;
                    case 'G/VS':
                        currentClarity = 'g-vs';
                        break;
                    case 'E/IF':
                        currentClarity = 'e-if';
                        break;
                }


            } else {

                if(String($('h1.product--title').text()).trim().split(" ")[0].trim() === "Memoirering") {
                    console.log($('h1.product--title').text());
                    memoirering = "true";

                    ringQuantity = 1;
                    var $profile = $('.memprofil.is--active');

                    if($profile.hasClass('p4')) {
                        profile = 4;
                    } else {
                        profile = 3;
                    }

                    size = $('#custom-products-option-1 option:selected').text().split("(")[0];

                    switch(currentClarity) {
                        case 'G/SI':
                            currentClarity = 'g-si';
                            break;
                        case 'G/VS':
                            currentClarity = 'g-vs';
                            break;
                        case 'E/IF':
                            currentClarity = 'e-if';
                            break;
                    }


                } else {
                    currentClarity = "";
                }

            }

            console.log("Neuer Preis angefordert von: " + me.opts.method);

            console.log(ringQuantity,withStones);

            if(me.opts.method === "disableStones") {
                withStones = false;
            }

            $.ajax({
                url: location.protocol + "//" + window.location.hostname + "/widgets/AsfRingManager/price",
                data: {
                    "area" : area,
                    "withStones": String(withStones),
                    "stone": stone,
                    "alloy": alloy,
                    "color": color,
                    "ringQuantity": ringQuantity,
                    "profile": profile,
                    "articleID": articleID,
                    "isVerlobungsring": verlobungsring,
                    "isMemoirering" : memoirering,
                    "size" : size,
                    "clarity": currentClarity

                },
                method: "post",
                dataType: 'json',
                success: function (data) {

                    var info = ' €*<span class="paarpreis">| Paarpreis</span>';
                    if(verlobungsring === "true" || memoirering === "true") {
                            info = ' €*';
                    }

                    if(memoirering === "true") {
                        $('.stone_quantity').html("<span>" + data.stones + "</span>");
                        $('#table_quantity').text(data.stones);
                        $('#table_weight').text(me.number_format(data.ct.replace(",","."),2,",",".") + "ct.");
                        $(me.opts.price).html('<meta itemprop="price" content="'+me.number_format(data.price,2,".",",")+'">'+me.number_format(data.price,2,",",".")+info);
                        $('#zertPrice').html(me.number_format(data.price,2,",",".") + ' €');
                    } else {
                        $(me.opts.price).html('<meta itemprop="price" content="'+me.number_format(data,2,".",",")+'">'+me.number_format(data,2,",",".")+info);
                        $('#zertPrice').html(me.number_format(data,2,",",".") + ' €');
                    }

                }
            });
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
        },
        //</editor-fold>


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
        var RingManager = $('.content.product--details').asfRingManager();
        // desktop
        $(document).on("click", '.js--img-zoom--lens', function(event) {
            $('.js--modal .content .image--element').prop('src', $('.image-slider--slide span.image--element').attr('data-img-large'));
            $('.js--modal .content .thumbnail--image').first().attr('src', $('.image-slider--slide span.image--element').attr('data-img-small'));
            $('.js--modal .content .thumbnail--image').first().attr('srcset', $('.image-slider--slide span.image--element').attr('data-img-small'));
        });
        // mobile
        $(document).on("click", '.image-slider--container', function(event) {
            $('.js--modal .content .image--element').prop('src', $('.image-slider--slide span.image--element').attr('data-img-large'));
            $('.js--modal .content .thumbnail--image').first().attr('src', $('.image-slider--slide span.image--element').attr('data-img-small'));
            $('.js--modal .content .thumbnail--image').first().attr('srcset', $('.image-slider--slide span.image--element').attr('data-img-small'));
        });

    });
})(jQuery, window);