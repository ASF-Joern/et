{namespace name="frontend/detail/option"}

{* Field *}
{block name="frontend_detail_swag_custom_products_options_numberfield_field"}
    <i class="fa fa-minus-square fa-2x conf_minus" data-value="{$key}"></i>
    <input class="wizard--input asf_number conf_mm" type="text" name="custom-option-id--{$option['id']}"
           id="custom-products-option-{$key}"
           {if $option['placeholder']}placeholder="{$option['placeholder']}"{/if}
           data-field="true"
        {if $option['default_value']}value="{$option['default_value'|replace:",":"."]}mm"{/if}
        {if $option['default_value']} data-default-value="{$option['default_value']}mm"{/if}
        {if $option['required']} data-validate="true" data-validate-message="{s name='detail/validate/numberfield'}{/s}"{/if}
        {if $option['min_value']} data-min="{if $option.name == "Damenring-Breite"}{$sArticle.attr20}{elseif $option.name == "Damenring-Stärke"}{$sArticle.attr22}{else}{$option['min_value']}{/if}
        " data-validate-message-min="{s name='detail/validate/numberfield/min'}{/s}"{/if}
        {if $option['max_value']} data-max="{if $option.name == "Damenring-Breite"}{$sArticle.attr21}{elseif $option.name == "Damenring-Stärke"}{$sArticle.attr23}{else}{$option['max_value']}{/if}
        " data-validate-message-max="{s name='detail/validate/numberfield/max'}{/s}"{/if}
        data-step="{if $option['interval']}{$option['interval']}{else}1{/if}" data-validate-message-step="{s name='detail/validate/numberfield/step'}{/s}"
        disabled
    />
    <i class="fa fa-plus-square fa-2x conf_plus" data-value="{$key}"></i>
{/block}
