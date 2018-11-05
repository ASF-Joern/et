;(function($) {
    'use strict';

    var updateArticle = function updateArticle() {

        var stone = false;

        if($('.btn_with_stones').hasClass('is--active')) {
            stone = true;
        }

        var alloy = "";

        $('.legierung').each(function(i,e) {
            if($(this).prop("checked")) {
                alloy = String($(this).parent().parent().text()).trim();
            }
        });

        var ct = "";

        $('.steinbesatz').each(function(i,e) {
            if($(this).prop("checked")) {
                ct = String($(this).parent().parent().text()).trim();
            }
        });

        var ajaxArray = {

            "ArticleID" : $('.entry--sku meta').attr("content"),
            "Profil" : $('.article_profil.is--active strong').text(),
            "Ordernumber" : String($('.buybox-top li.entry--sku span').text()).trim(),
            "Ringwahl" : $('.asf_hidden_radio_switcher.is--active').text(),
            "Mit_Steinen" : stone,
            "Herrenring-Breite" : $('#custom-products-option-3').val(),
            "Herrenring-Stärke" : $('#custom-products-option-4').val(),
            "Damenring-Breite" : $('#custom-products-option-6').val(),
            "Damenring-Stärke" : $('#custom-products-option-7').val(),
            "Farbe" : $('.change_ring_color div.is--active .color_text').text(),
            "Legierung" : alloy,
            "Steinbesatz" : ct
        };

        $.ajax({
            url: location.protocol + "//" + window.location.hostname + "widgets/AsfAfterbuyPriceManager",
            data: ajaxArray,
            method: "post",
            dataType: 'json',
            success: function(data) {

                var en_price = number_format(data, 2, '.', ',');
                var de_price = number_format(data, 2, ',', '.');
                de_price = de_price.replace("#",".");

                var priceInfo = "";

                $('.asf_hidden_radio_switcher').each(function(i,e){
                    if($(this).text() === "Paarringe" && $(this).hasClass("is--active")) {
                        priceInfo = '<span class="paarpreis">| Paarpreis</span>';
                    }
                });

                $('.price--content.content--default').html('<meta itemprop="price" content="' + en_price + '">' + de_price + ' € ' + priceInfo);

            }
        });
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
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

    $.subscribe('plugin/asfAddAndSub/changed', updateArticle);
    $.subscribe('plugin/asfHiddenRadio/changed', updateArticle);
    $.subscribe('plugin/asfSetStones/changed', updateArticle);
    $.subscribe('plugin/asfSwitchAlloyOrStone/changed', updateArticle);
    $.subscribe('plugin/asfSwitchColor/changed', updateArticle);
    $.subscribe('plugin/asfHiddenRadio/changed', updateArticle);
    $.subscribe('plugin/profileChanger/changed', updateArticle);

    jQuery(window).load(function () {
        updateArticle();
    });

})(jQuery);

