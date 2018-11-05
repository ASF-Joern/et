{namespace name="frontend/detail/option"}

{* Output all fields *}
{block name="frontend_detail_swag_custom_products_options_radio_fields"}
    {if $option.name === "Profil"}
        {include file='frontend/swag_custom_products/options/profil.tpl' options=$option}

    {else}
        <div id="custom-products-option-{$key}" class="wizard--input custom-products--validation-wrapper"
             data-group-field="true"{if $option['required']} data-validate-group="true" data-validate-message="{s name='detail/validate/radio'}{/s}"{/if}>

            {foreach $option['values'] as $value}
                <div class="custom-products--radio-value">

                    {* Output the actual field *}
                    {block name="frontend_detail_swag_custom_products_options_radio_field"}
                        {* We need buttons here *}
                        {if $option['name'] == "Ringwahl"}
                            <button class="asf_hidden_radio_switcher {if $value@first}is--active{/if}" data-ident="{$key}-{$value@index}" type="button">{$value['name']}</button>
                        {/if}

                        <input class="asf_hidden_radio custom-option-id--{$option['id']} is--hidden" type="radio" id="custom-products--radio-{$key}-{$value@index}"
                               name="custom-option-id--{$option['id']}"
                               value="{$value['id']}"
                                {if $value['is_default_value']} data-default-value="{$value['id']}"{/if}
                                {if $value['is_default_value'] || $value.name === $sArticle.attr7 || $value.name === $sArticle.attr6} checked="checked"{/if} />
                        <span class="radio--state">&nbsp;</span>

                        {* Label value *}
                        {block name="frontend_detail_swag_custom_products_options_radio_label_value"}
                            <span class="custom-products--radio-inline-label is--hidden">
                                {$value['name']}
                                {block name="frontend_detail_swag_custom_products_options_radio_label_value_surcharge"}
                                    {include file='frontend/swag_custom_products/options/surcharge/surcharge.tpl'}
                                {/block}
                             </span>
                        {/block}

                    {/block}
                </div>
            {/foreach}
        </div>
        {if $option['name'] == "Ringwahl"}
            {assign var="profiles" value=";"|explode:$sArticle.attr4}
            {foreach from=$profiles item=profile key=index}
                {assign var="profileText" value=":"|explode:$profile}
                <div class="article_profil profil{($index+1)} {if $sArticle.attr5 != ($index+1)}is--hidden{else}is--active{/if}">
                    <strong>Profil{($index+1)}:</strong>{$profileText.1}
                </div>
            {/foreach}
        {/if}
    {/if}

{/block}
