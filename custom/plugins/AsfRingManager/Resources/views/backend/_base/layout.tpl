<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{link file="backend/_resources/css/bootstrap.min.css"}">
</head>
<body role="document">
<div class="container-full theme-showcase" role="main">
    {block name="content/main"}{/block}
    <div class="afterbuy-connection">
        <span>Schnittstellen Verbindung zu Afterbuy
            {if $response->CallStatus == "Success"}
                <i class="fa fa-check text-success"></i>
            {else}
                <i class="fa fa-minus text-danger"></i>
            {/if}
        </span>
    </div>
</div> <!-- /container -->

<script type="text/javascript" src="{link file="backend/base/frame/postmessage-api.js"}"></script>
<script type="text/javascript" src="{link file="backend/_resources/js/jquery-2.1.4.min.js"}"></script>
<script type="text/javascript" src="{link file="backend/_resources/js/bootstrap.min.js"}"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

{block name="content/layout/javascript"}
<script type="text/javascript">

</script>
{/block}
{block name="content/javascript"}
<script>

</script>
{/block}
</body>
</html>