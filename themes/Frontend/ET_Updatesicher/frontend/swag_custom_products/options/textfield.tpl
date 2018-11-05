{namespace name="frontend/detail/option"}

{* Field *}
{block name="frontend_detail_swag_custom_products_options_textfield_field"}
    <input class="wizard--input" type="text" name="custom-option-id--{$option['id']}" style="font-family: ArialLaser;"
        id="custom-products-option-{$key}"
        data-field="true"
        {if $option['default_value']} data-default-value="{$option['default_value']}"{/if}
        {if $option['placeholder']}placeholder="{$option['placeholder']}"{/if}
        {if $option['default_value']}value="{$option['default_value']}"{/if}
        {if $option['required']} data-validate="true" data-validate-message="{s name='detail/validate/textfield'}{/s}"{/if}
        {if $option['max_text_length']}maxlength="{$option['max_text_length']}"{/if}
    />
    {if $option.name == "Damenring-Gravur" || $option.name == "Herrenring-Gravur" || $option.name == "Ring-Gravur"}
        <div class="add_symbols">
            <div class="mobilefix"><span class="symbole_text">Symbole:</span>
                <span class="single_heart" style="background-image: url({media path='media/image/herz.jpg'});">&nbsp;</span>
                <span class="double_heart" style="background-image: url({media path='media/image/doppelherz.jpg'})">&nbsp;</span>
                <span class="double_ring" style="background-image: url({media path='media/image/doppelringe.jpg'})">&nbsp;</span>
                <span class="infinity" style="background-image: url({media path='media/image/unendlich.jpg'})">&nbsp;</span>
            </div>
        </div>
    {/if}
{/block}
