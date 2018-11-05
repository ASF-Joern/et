;(function($) {

    if($('#custom-products-option-2').length === 1) {
        var sorted = [];
        $('#custom-products-option-2 option').each(function(){
            if($(this).val() === "") {
            } else {
                sorted[parseInt($(this).val())] = [];
                sorted[parseInt($(this).val())][0] = parseInt($(this).val());
                sorted[parseInt($(this).val())][1] = $(this).text();
            }
            $(this).remove();
        });
        sorted.sort();

        $('#custom-products-option-2').append('<option disabled="disabled" value="" selected="selected">Bitte wählen...</option>');
        for(var i in sorted) {
            $('#custom-products-option-2').append('<option value="'+sorted[i][0]+'">'+sorted[i][1]+'</option>');
        }

        sorted = [];
        $('#custom-products-option-5 option').each(function(){
            if($(this).val() === "") {
            } else {
                sorted[parseInt($(this).val())] = [];
                sorted[parseInt($(this).val())][0] = parseInt($(this).val());
                sorted[parseInt($(this).val())][1] = $(this).text();
            }
            $(this).remove();
        });
        sorted.sort();

        $('#custom-products-option-5').append('<option disabled="disabled" value="" selected="selected">Bitte wählen...</option>');
        for(var i in sorted) {
            $('#custom-products-option-5').append('<option value="'+sorted[i][0]+'">'+sorted[i][1]+'</option>');
        }
    }

    $.subscribe('plugin/swListingActions/onRegisterEvents', function(event, me) {
        me.openFilterPanel();
        $.loadingIndicator.close();
    });
    $.subscribe('plugin/swListingActions/onGetPropertyFieldNames', function(me, properties) {
        $.each(properties.$filterComponents, function(i,component) {
            $(this).addClass('is--collapsed');
        });
    });
    $.subscribe('plugin/profileChanger/changed', function(me){

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
        };

        var womanWidth = $('#custom-products-option-3').val(), manWidth = $('#custom-products-option-6').val(),
            womanThickness = $('#custom-products-option-4').val(), manThickness = $('#custom-products-option-7').val(),
            withStones = $('.btn_with_stones').hasClass('is--active'), stone = $('.steinbesatz:checked').data('value'),
            alloy = $('.legierung:checked').data('value'), color = $('.change_ring_color .is--active').find('span').text(), ringQuantity = 1,
            profile = $('#custom-products-option-0 input:checked').data('value'), articleID = $('.buybox-top .entry--content').prev().attr('content'),
            area = 0;

        if($('.asf_hidden_radio_switcher.is--active').text() === "Paarringe") {

            ringQuantity = 2;
            womanWidth = womanWidth.substring(0,womanWidth.length-2);
            womanThickness = womanThickness.substring(0,womanThickness.length-2);
            manWidth = manWidth.substring(0,manWidth.length-2);
            manThickness = manThickness.substring(0,manThickness.length-2);

            area = parseFloat(womanWidth) * parseFloat(womanThickness) + parseFloat(manWidth) * parseFloat(manThickness);

        }

        if($('.asf_hidden_radio_switcher.is--active').text() === "Damenring") {

            womanWidth = womanWidth.substring(0,womanWidth.length-2);
            womanThickness = womanThickness.substring(0,womanThickness.length-2);
            area = parseFloat(womanWidth) * parseFloat(womanThickness);

        }

        if($('.asf_hidden_radio_switcher.is--active').text() === "Herrenring") {

            manWidth = manWidth.substring(0,manWidth.length-2);
            manThickness = manThickness.substring(0,manThickness.length-2);
            area = parseFloat(manWidth) * parseFloat(manThickness);

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
                "articleID": articleID
            },
            method: "post",
            dataType: 'json',
            success: function (data) {
                $('.price--content.content--default').html('<meta itemprop="price" content="'+number_format(data,2,".",",")+'">'+number_format(data,2,",",".")+' € <span class="paarpreis">| Paarpreis</span>');
                $('#zertPrice').html(number_format(data,2,",",".") + ' €');
                $('#custom-products--radio-12-0').trigger('change');
            }
        });

		$('html,body').animate({scrollTop: $('.product--buybox.block').offset().top},'slow');

    });
    $.overridePlugin('swListingActions', {

        init: function() {
            $.loadingIndicator.open();
            var me = this;

            me.superclass.init.apply(this, arguments);
        },

        /**
         * Closes all filter panels if the user clicks anywhere else.
         *
         * @param {Event} event
         */
        onBodyClick: function (event) {

        },

    });

    $.overridePlugin('swAjaxWishlist', {

        /**
         * Animates the element when the AJAX request was successful.
         *
         * @param {object} $target - The associated element
         */
        animateElement: function ($target) {
            var me = this,
                $icon = $target.find('i'),
                originalIcon = $icon[0].className,
                $text = $target.find('.action--text');
            
            $target.addClass(me.opts.savedCls);
            $text.html($target.attr('data-text') || me.opts.text);
            $icon.removeClass(originalIcon).addClass(me.opts.iconCls);

            $.publish('plugin/swAjaxWishlist/onAnimateElement', [me, $target]);
        },

    });

    $('a.thumbnail--link').click(function(){
        console.log($(this).attr('title'));
        if($(this).attr('title') === "Vorschau: Imagefilm - EwigeTrauringe.de") {

            $('iframe.image--media').attr('src',$('iframe.image--media').attr('src') + "&autoplay=1");
        }
    });

function scrb64d(r){var e,n,a,t,f,d,h,i="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",o="",c=0;for(r=r.replace(/[^A-Za-z0-9\+\/\=]/g,"");c<r.length;)t=i.indexOf(r.charAt(c++)),f=i.indexOf(r.charAt(c++)),d=i.indexOf(r.charAt(c++)),h=i.indexOf(r.charAt(c++)),e=t<<2|f>>4,n=(15&f)<<4|d>>2,a=(3&d)<<6|h,o+=String.fromCharCode(e),64!=d&&(o+=String.fromCharCode(n)),64!=h&&(o+=String.fromCharCode(a));return o=o}
var scrttze = function (_sid,_script){

    var container = document.createElement("div");
    container.innerHTML = scrb64d(_script);
    if(document.getElementById(_sid))
        document.getElementById(_sid).parentNode.appendChild(container);
    else
        document.body.appendChild(container);
    if(document.getElementById('lz_r_scr_'+_sid)!=null)
        eval(document.getElementById('lz_r_scr_'+_sid).innerHTML);
    //comp
    else if(document.getElementById('lz_r_scr')!=null)
        eval(document.getElementById('lz_r_scr').innerHTML);

    if(document.getElementById('lz_textlink')!=null){
        var newScript = document.createElement("script");
        newScript.src = document.getElementById('lz_textlink').src;
        newScript.async = true;
        document.head.appendChild(newScript);
    }
    var links = document.getElementsByClassName('lz_text_link');
    for(var i=0;i<links.length;i++)
        if(links[i].className == 'lz_text_link'){
            var newScript = document.createElement("script");
            newScript.src = links[i].src;
            newScript.async = true;
            if(document.getElementById('es_'+links[i].id)==null)
            {
                newScript.id = 'es_'+links[i].id;
                document.head.appendChild(newScript);
            }
        }
};
function ssc(sid,script)
{
    if(window.addEventListener)
        window.addEventListener('load',function() {scrttze(sid,script);});
    else
        window.attachEvent('onload',function() {scrttze(sid,script);});
}
ssc('a4709c38c4d40dd7f64c9d755bf5668a','PCEtLSBsaXZlemlsbGEubmV0IFBMQUNFIFNPTUVXSEVSRSBJTiBCT0RZIC0tPgo8ZGl2IGlkPSJsdnp0cl83NTQiIHN0eWxlPSJkaXNwbGF5Om5vbmUiPjwvZGl2PjxzY3JpcHQgaWQ9Imx6X3Jfc2NyX2E0NzA5YzM4YzRkNDBkZDdmNjRjOWQ3NTViZjU2NjhhIiB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPmx6X292bGVsID0gW3t0eXBlOiJ3bSIsaWNvbjoiY29tbWVudGluZyJ9LHt0eXBlOiJjaGF0IixpY29uOiJjb21tZW50cyIsY291bnRlcjp0cnVlfSx7dHlwZToidGlja2V0IixpY29uOiJlbnZlbG9wZSJ9XTtsel9vdmxlbF9jbGFzc2ljID0gdHJ1ZTtsel9vdmxlbF9ydF9vbmwgPSAnVEdsMlpTQkRhR0YwJztsel9vdmxlbF9ydF9vZmwgPSAnUzI5dWRHRnJkQT09Jztsel9vdmxlbF9yaSA9ICdlbnZlbG9wZSc7bHpfb3ZsZWMgPSBudWxsO2x6X2NvZGVfaWQ9ImE0NzA5YzM4YzRkNDBkZDdmNjRjOWQ3NTViZjU2NjhhIjt2YXIgc2NyaXB0ID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgic2NyaXB0Iik7c2NyaXB0LmFzeW5jPXRydWU7c2NyaXB0LnR5cGU9InRleHQvamF2YXNjcmlwdCI7dmFyIHNyYyA9ICJodHRwczovL3d3dy5ld2lnZXRyYXVyaW5nZS5kZS9saXZlemlsbGEvc2VydmVyLnBocD9ycXN0PXRyYWNrJm91dHB1dD1qY3JwdCZvdmx2PWRqSV8mb3ZsdHdvPU1RX18mb3ZsYz1NUV9fJmVzYz1Jemt6TWpreVlnX18mZXBjPUkyRmlNek16TXdfXyZvdmx0cz1NQV9fJm92bG1iPU1BX18mb3ZsYXBvPU1RX18mbnNlPSIrTWF0aC5yYW5kb20oKTtzY3JpcHQuc3JjPXNyYztkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnbHZ6dHJfNzU0JykuYXBwZW5kQ2hpbGQoc2NyaXB0KTs8L3NjcmlwdD4KPCEtLSBsaXZlemlsbGEubmV0IFBMQUNFIFNPTUVXSEVSRSBJTiBCT0RZIC0tPg==');
	
})(jQuery);