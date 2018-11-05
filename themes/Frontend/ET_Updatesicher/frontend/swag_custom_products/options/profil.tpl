<div id="custom-products-option-{$key}" class="wizard--input custom-products--validation-wrapper is--hidden" data-group-field="true"{if $option['required']} data-validate-group="true" data-validate-message="{s name='detail/validate/radio'}{/s}"{/if}>
    {foreach $option['values'] as $value}
        <div class="custom-products--radio-value">

            {* Output the actual field *}
            {block name="frontend_detail_swag_custom_products_options_radio_field"}
                <label class="custom-products--radio-label" for="custom-products--radio-{$key}-{$value@index}">
                        <span class="filter-panel--radio">
                            <input type="radio" id="custom-products--radio-{$key}-{$value@index}" class="selected_profil"
                                   name="custom-option-id--{$option['id']}" data-value="{$value['name']|substr:6:1}"
                                   value="{$value['id']}"
                                    {if $value['name'] == "Standard-Profil" && {$sArticle.attr5} == "0"} data-default-value="{$value['id']}"{/if}
                                    {if $value['name'] == "Profil{$sArticle.attr5}"} data-default-value="{$value['id']}"{/if}
                                    {if $value['name'] == "Profil{$sArticle.attr5}" || ($value['name'] == "Standard-Profil" && $sArticle.attr5 == "0")} checked="checked"{/if} />

                            <span class="radio--state">&nbsp;</span>
                        </span>

                    {* Label value *}
                    {block name="frontend_detail_swag_custom_products_options_radio_label_value"}
                        <span class="custom-products--radio-inline-label">
                                {$value['name']}
                            {block name="frontend_detail_swag_custom_products_options_radio_label_value_surcharge"}
                                {include file='frontend/swag_custom_products/options/surcharge/surcharge.tpl'}
                            {/block}
                             </span>
                    {/block}
                </label>
            {/block}
        </div>
    {foreachelse}

    {/foreach}
</div>