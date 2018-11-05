{* Include the default template *}
{include file="frontend/checkout/items/product.tpl"}

{* ...and include over custom product information *}
{assign var="ring" value=" "|explode:$sBasketItem.articlename}
{if $ring[0] == "Partnerringe" || $ring[1] == "Partnerringe" || $ring[2] == "Partnerringe"}
    {include file="frontend/swag_custom_products/checkout/product_custom_product_info_partnerringe.tpl"}
{elseif $ring[0] == "Trauringe"}
    {* ...grouped as trauringe *}
    {include file="frontend/swag_custom_products/checkout/product_custom_product_info_trauringe.tpl"}
{elseif $ring[0] == "Verlobungsring"}
    {include file="frontend/swag_custom_products/checkout/product_custom_product_info_verlobungsring.tpl"}
{elseif $ring[0] == "Memoirenring"}
    {include file="frontend/swag_custom_products/checkout/product_custom_product_info_memoirenring.tpl"}
{else}
    {include file="frontend/swag_custom_products/checkout/product_custom_product_info.tpl"}
{/if}
