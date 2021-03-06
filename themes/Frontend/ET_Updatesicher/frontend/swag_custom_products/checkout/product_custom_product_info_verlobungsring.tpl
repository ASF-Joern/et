{namespace name="frontend/detail/option"}

{$IS_NON_CUSTOM_PRODUCT = 0}
{$IS_CUSTOM_PRODUCT_MAIN = 1}
{$IS_CUSTOM_PRODUCT_OPTION = 2}
{$IS_CUSTOM_PRODUCT_VALUE = 3}

{* Check if we're dealing with a custom product *}
{if $sBasketItem.customProductMode == $IS_CUSTOM_PRODUCT_MAIN}
    {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges"}

        <div class="custom-products--basket-overview">
            {* Surcharges headline *}
            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_title"}
                <h4 class="custom-product--overview-title">
                    {s name="basket/surcharges"}Surcharges{/s}:

                    {strip}<span class="custom-product--price-surcharges">{$sBasketItem.custom_product_prices.surchargesTotal|currency}
                        {if !$isCheckoutConfirm}{s name="Star" namespace="frontend/listing/box_article"}{/s}{/if}</span>{/strip}
                </h4>
            {/block}

            {* Option list *}
            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_list"}
                {assign var="note" value=""}
                {foreach $sBasketItem.custom_product_adds as $option}

                    {if $option.name === "Legierung"}
                        {continue}
                    {/if}

                    {* Option *}
                    {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_list_item"}
                        <li class="custom-product--overview-list-item {if $option.name === "Notiz"}is--hidden{/if}">

                            {* Option name *}
                            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_item_name"}
                                {if $option.name != "Notiz"}
                                    <span class="custom-product--overview-option-name" style="display:inline-block; width:30%">
                                    <span class="overview-option-name--name">
                                        {if $option.name === "Damenring-Größe" || $option.name === "Damenring-Gravur"}
                                            {assign var="newOption" value="-"|explode:$option.name}
                                            {$newOption[1]}:
                                        {else}
                                            {$option.name}:
                                        {/if}
                                    </span>

                                        {if $option.could_contain_values}
                                            {* Option price *}
                                            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_option_price"}
                                                {include file="frontend/swag_custom_products/checkout/checkout_price.tpl"
                                                price = $option.surcharge
                                                is_once_surcharge = $option.is_once_surcharge
                                                isTaxFreeDelivery = $option.isTaxFreeDelivery
                                                isCheckoutConfirm = $isCheckoutConfirm
                                                sUserData = $sUserData
                                                tax = $option.tax
                                                }
                                            {/block}
                                        {/if}
                                </span>
                                {/if}
                            {/block}

                            {* Option value *}
                            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_item_value"}

                                <span class="custom-product--overview-option-value" {if $option.name === "Damenring-Gravur"}style="font-family:ArialLaser"{/if}>
                                    {if $option.could_contain_values}
                                        {foreach $option.values as $value}
                                            {if $value.path}<i class="icon--paperclip"></i>&nbsp;{/if}{$value.name}

                                            {* Option price *}
                                            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_values_price"}
                                                {include file="frontend/swag_custom_products/checkout/checkout_price.tpl"
                                                price = $value.surcharge
                                                is_once_surcharge = $value.is_once_surcharge
                                                isTaxFreeDelivery = $value.isTaxFreeDelivery
                                                isCheckoutConfirm = $isCheckoutConfirm
                                                sUserData = $sUserData
                                                tax = $value.tax
                                                }
                                            {/block}
                                        {/foreach}
                                    {else}
                                        {if $option.type === 'date'}
                                            {$option.selectedValue.0|date:DATE_MEDIUM}
                                        {else}
                                            {if $option.name === "Notiz"}
                                                {$note = $option.selectedValue.0}
                                            {else}
                                                {$option.selectedValue.0|truncate}
                                            {/if}
                                        {/if}

                                        {* Option price *}
                                        {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_value_price"}
                                            {include file="frontend/swag_custom_products/checkout/checkout_price.tpl"
                                            price = $option.surcharge
                                            is_once_surcharge = $option.is_once_surcharge
                                            isTaxFreeDelivery = $option.isTaxFreeDelivery
                                            isCheckoutConfirm = $isCheckoutConfirm
                                            sUserData = $sUserData
                                            tax = $option.tax
                                            }
                                        {/block}
                                    {/if}
                                </span>

                            {/block}
                        </li>
                    {/block}

                    {if $option@last && !empty($note)}
                        <li class="custom-product--overview-list-item">
                            <span class="custom-product--overview-option-name" style="display:inline-block; width:30%">
                            <span class="overview-option-name--name">
                                Notiz:
                            </span>
                            </span>
                            <span class="custom-product--overview-option-value">{$note}</span>
                        </li>
                    {/if}

                {/foreach}
            {/block}

            {block name="frontend_checkout_cart_item_details_inline_swag_custom_products_surcharges_total"}
                <div class="block-group">
                    {if {controllerAction|lower} == 'cart' || {controllerAction|lower} == 'confirm'}
                        {if $sBasketItem.additional_details.sConfigurator}
                            {$detailLink={url controller=detail sArticle=$sBasketItem.articleID number=$sBasketItem.ordernumber}}
                        {else}
                            {$detailLink = {url controller=detail sArticle=$sBasketItem.articleID}}
                        {/if}
                        <div class="block custom-product--action-open-config">
                            <a href="{$detailLink}#{$sBasketItem.customProductHash}" title="{s name="basket/open_configuration"}{/s}" class="custom-product--action-open-config-link">
                                {s name="basket/open_configuration"}{/s} <i class="icon--arrow-right"></i>
                            </a>
                        </div>
                    {/if}

                    <div class="custom-products--surcharges-total block">
                        {s name="basket/total_sum"}Total sum{/s}:&nbsp;
                        <span class="surcharges-total--display">
                            {$sBasketItem.custom_product_prices.total|currency}{if {controllerAction|lower} !== 'confirm'}{/if}{strip}
                                {if !$isCheckoutConfirm}
                                    {s name="Star" namespace="frontend/listing/box_article"}{/s}
                                {/if}{/strip}
                        </span>
                    </div>
                </div>
            {/block}
        </div>
    {/block}
{/if}
