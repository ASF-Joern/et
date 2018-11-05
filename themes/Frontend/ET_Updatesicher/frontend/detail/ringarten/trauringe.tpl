{assign var="options" value=$swagCustomProductsTemplate.options}

<div class="change_ring_container">
    <div class="change_ring_color">
        <h4>Farbe/Material</h4>
        {assign var="classSwitcher" value=false}
        {assign var="subcategories" value=""}
        {foreach $sCategories as $cat}
            {if $cat.name == "Trauringe"}
                {$subcategories = $cat.subcategories}
                {break}
            {/if}
        {/foreach}
        {foreach $asfColorSwitcher as $color}

            {assign var="iconPath" value=""}
            {assign var="iconName" value=""}
            {foreach $subcategories as $category}
                {assign var="name" value=" "|explode:$category.name}
                {if $name.1 == $color.name}
                    {$iconName = $category.media.name}
                    {break}
                {/if}
            {/foreach}

            <div class="{if $classSwitcher}color_right{$classSwitcher = true}{else}color_left{$classSwitcher = false}{/if} {if $color.name == $sArticle.attr13}is--active{/if}">
                <span class="asf-sprite color-icon {$iconName|replace:"-icon":""}"></span>
                <span class="color_text">{$color.name}</span>
            </div>
        {/foreach}

    </div>

    {foreach from=$options key=key item=option}

        {if $option.name == "Legierung" || $option.name == "Steinbesatz"}
            <div id="asf_custom-products-option-{$key}" class="wizard--input custom-products--validation-wrapper" data-group-field="true" {if $option['required']} data-validate-group="true" data-validate-message="{s name='detail/validate/radio'}{/s}"{/if}>
                {if $option.name == "Steinbesatz" && $ring !== "zircon"}
                    <h4>Steinanzahl</h4>
                {else}
                    <h4>{$option.name}</h4>
                {/if}

                {foreach $option['values'] as $value}
                    {* Palladium: 585er,950er || Platin: 600er,950er*}
                    <div class="custom-products--radio-value {if $value['name'] == "Ohne Stein/e"}is--hidden no_stone {/if}
                        {if $option.name == "Legierung"}
                            {if $asfMaterial == "platin" && $value.name != "600er" && $value.name != "950er"} is--hidden{/if}
                            {if $asfMaterial == "palladium" && $value.name != "585er" && $value.name != "950er"} is--hidden{/if}
                            {if $asfMaterial == "gold" && $value.name != "333er" && $value.name != "585er" && $value.name != "750er"} is--hidden{/if}
                        {/if}
                        ">

                        {* Output the actual field *}
                        <label class="custom-products--radio-label" for="change_custom-products--radio-{$key}-{$value@index}">
                            {if $option.name == "Steinbesatz" && $ring !== "zircon"}
                                {$amountOfStones[$value.name]}
                            {else}
                                {$value.name}
                            {/if}
                            <span class="filter-panel--radio">
                                <input type="radio" id="change_custom-products--radio-{$key}-{$value@index}" class="{$option.name|lower}" data-value="{$value['name']}"
                                       name="change-custom-option-id--{$option['id']}"
                                       value="{$value['id']}"
                                        {if $value['is_default_value']} data-default-value="{$value['id']}"{/if}
                                        {if ($option.name == "Steinbesatz" && $value['name'] == $sArticle.attr6)
                                        || ($option.name == "Legierung" && $value['name'] == $sArticle.attr7)} checked="checked"{/if} form="swagArticleForm" />
                                <span class="radio--state">&nbsp;</span>
                            </span>
                        </label>
                    </div>
                {/foreach}
            </div>
        {/if}

        {if $option.name == "Steinbesatz" && $ring !== "zircon"}
            <div id="asf_custom-products-option-{$key+1}" class="wizard--input custom-products--validation-wrapper change_{$option.name|lower}" data-group-field="true"{if $option['required']} data-validate-group="true" data-validate-message="{s name='detail/validate/radio'}{/s}"{/if}>
                <h4>{$option.name} Damenring</h4>

                {foreach $option['values'] as $value}
                    <div class="custom-products--radio-value {if $value['name'] == "Ohne Stein/e"}is--hidden no_stone {/if}">
                        {if $value['name'] !== "Ohne Stein/e"}
                            {* Output the actual field *}
                            <label class="custom-products--radio-label {if $option.name == "Steinbesatz" && $value['name'] == $sArticle.attr6}is--active{else}is--hidden{/if}">
                                {$value.name}
                            </label>
                        {/if}
                    </div>
                {/foreach}
            </div>
        {/if}

    {/foreach}

</div>
<div class="ring-extra-info">
    <div class="etui-box-li">
        <fieldset class="etui">
            <legend>Kostenloses Ring-Etui</legend>
            <img src="{media path='media/image/trauringe-etui.jpg'}" alt="trauringe-etui-kostenlos" title="Ihr kostenloses Trauringe-Etui">
        </fieldset>
    </div>
    <div class="etui-box-re">
        <fieldset class="etui">
            <legend>Ringänderung gewünscht?</legend>
            Wir können nahezu alle Änderungen an diesem Modell vornehmen.<br>
            Dazu zählen:<br>
            <ul style="list-style-type:disc">
                <li>mehr/weniger Steine</li>
                <li>andere Fugen</li>
                <li>andere Polierung/Mattierung</li>
            </ul>
            Rufen Sie uns gerne an, um alles zu besprechen: <strong>06404 - 802 9020</strong>
        </fieldset>
    </div>
</div>