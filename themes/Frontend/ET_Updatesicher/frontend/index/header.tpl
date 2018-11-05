{extends file="parent:frontend/index/header.tpl"}
{block name="frontend_index_header_css_screen" append}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<!--<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet">-->
{/block}

{block name="frontend_index_header_meta_tags_schema_webpage" append}
    <meta name="theme-color" content="#ffffff" />
{/block}

{block name="frontend_index_header_javascript_tracking" append}

{/block}

<!-- Facebook Pixel Code -->
{literal}
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1204919199542628');
        fbq('track', 'PageView');
        fbq('track', 'ViewContent');
    </script>
{/literal}
<noscript>
    <img height="1" width="1" style="display:none" alt="fb-pixel" src="https://www.facebook.com/tr?id=1204919199542628&ev=PageView&noscript=1">
</noscript>
<!-- End Facebook Pixel Code -->