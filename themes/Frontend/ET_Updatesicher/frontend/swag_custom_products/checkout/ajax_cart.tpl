{$IS_NON_CUSTOM_PRODUCT = 0}
{$IS_CUSTOM_PRODUCT_MAIN = 1}
{$IS_CUSTOM_PRODUCT_OPTION = 2}
{$IS_CUSTOM_PRODUCT_VALUE = 3}

{if $sBasketItem.customProductMode == $IS_NON_CUSTOM_PRODUCT || $sBasketItem.customProductMode == $IS_CUSTOM_PRODUCT_MAIN}
    <div class="custom-product--cart-item">
        {* Include the default template *}
        {include file="frontend/checkout/ajax_cart_item.tpl" basketItem=$sBasketItem}

        {* ...and include over custom product information *}
        {assign var="ring" value=" "|explode:$sBasketItem.articlename}
        {if $ring[0] == "Partnerringe" || $ring[1] == "Partnerringe" || $ring[2] == "Partnerringe"}
            {include file="frontend/swag_custom_products/checkout/product_custom_product_info_partnerringe.tpl"}
        {elseif $ring[0] == "Trauringe"}
            {* ...grouped as trauringe *}
            {include file="frontend/swag_custom_products/checkout/product_custom_product_info_trauringe.tpl"}
        {elseif $ring[0] == "Verlobungsring"}
            {include file="frontend/swag_custom_products/checkout/product_custom_product_info_verlobungsring.tpl"}
        {elseif $ring[0] == "Memoirering"}
            {include file="frontend/swag_custom_products/checkout/product_custom_product_info_memoirering.tpl"}
        {else}
            {include file="frontend/swag_custom_products/checkout/product_custom_product_info.tpl"}
        {/if}
    </div>
{/if}
