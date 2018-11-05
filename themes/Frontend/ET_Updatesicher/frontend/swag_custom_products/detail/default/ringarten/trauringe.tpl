{* Index file for the options. This file will load the associated options *}
{*
 * IMPORTANT: the numbers are for the regulation from the different options, the sorting can be seen in the backend
*}
{block name="frontend_detail_swag_custom_products_options_index"}
    {$customProducts = $swagCustomProductsTemplate}
    {$options = $customProducts['options']}

    {* Options container *}
    {block name="frontend_detail_swag_custom_products_options"}
        {* Do we have to show a notice for required fields? *}
        {$displayRequiredInfo = false}

        {* Loads the template file by the option name *}
        <div class="custom-products--options trauringe">
            <input type="hidden" name="template-id" value="{$customProducts['id']}">

            {foreach $options as $option}

                {if $option.name == "Notiz"}
                    <div class="viewlast"></div>
                    <fieldset class="font_changer_container" style="display:none">
                        <legend>Schriftart</legend>
                        <div class="mobilefix">
                            <select class="font_changer" name="engraving_font">
                                <option value="ArialLaser" data-value="Schrift1" selected="selected">Schrift1</option>
                                <option value="MVBoli" data-value="Schrift2">Schrift2</option>
                            </select>
                        </div>
                    </fieldset>
                {/if}

                {if $option.name == "Damenring-Gravur"}
                    <div id="ringmasskonf">
                        <span class="asf-sprite massband"></span>
                        Sie kennen ihre Ringgröße nicht?
                        <br>
                        <a href="{url controller=index}ringmass-kostenlos-anfordern" title="Zum Ringmaßband für Trauringe">» Ringmaß kostenlos bestellen</a>.
                    </div>
                {/if}

                {$path="frontend/swag_custom_products/options/{$option['type']}.tpl"}

                {assign var="nameParts" value="-"|explode:$option['name']}

                {* Is needed for grouping woman, man and engraving *}
                {if $option@iteration == 3 || $option@iteration == 6 || $option@iteration == 9 || $option@iteration == 10 || $option@iteration == 11}
                    {if $option@iteration == 3}
                        <div class="conf_stones" data-save="btn_with_stones">
                            <div class="conf_stone_left">
                                <button type="button" class="btn_with_stones is--active">
                                    <span class="asf-sprite color-icon with_stones"></span>
                                    Mit Stein/en
								</button>
                            </div>
                            <div class="conf_stone_right">
                                <button type="button" class="btn_without_stones">
                                    <span class="asf-sprite color-icon without_stones"></span>
                                    Ohne Stein/e
								</button>
                            </div>
                        </div>
                    {/if}
                    {if $option.name == "Notiz"}
                        <div class="tooltip tooltip-calc">[?]
                            <div class="tooltiptext">
                                <div class="tooltip-header">
                                    <h4 class="tooltip-title">Weitere Notizen</h4>
                                </div>
                                <div class="tooltip-content">
                                    1. Änderungen, falls gewünscht.<br>
                                    2. Änderungen an der Oberfläche.<br>
                                    <img src="https://www.ewigetrauringe.de/themes/Frontend/ET_Updatesicher/frontend/images/trauringe-mattierungen.png" alt="trauringe-mattierungen" title="Wählen Sie Ihre Mattierung">
                                    <strong>Ohne Angaben bleibt der Ring wie im Vorschaubild.</strong><br>
                                    <i>Die Änderungen sind kostenlos.</i>
                                </div>
                            </div>
                        </div>
                    {/if}
                    <fieldset class="{if $option@iteration == 3 || $option@iteration == 6}ring_group {$nameParts.0}{/if}{if $option@iteration == 9}calc_gravur_left{/if}{if $option@iteration == 10}calc_gravur_right{/if}{if $option@iteration == 11}note{/if}">

                    <legend>{if $option@iteration == 3 || $option@iteration == 6}{$nameParts[0]}{else}{$option['name']}
					 {/if}</legend>
                {/if}

                {if $path|template_exists}
                    {if $option@iteration == 4 || $option@iteration == 7}
                        <div class="conf_rl">
                    {/if}
                    {if $option@iteration == 5 || $option@iteration == 8}
                        <div class="conf_rr">
                    {/if}
                    <div class="custom-products--option{if $option@first} is--first{/if}{if $option@iteration == 12 || $option@iteration == 13 || $option@iteration == 14 || $option@iteration == 15} is--hidden{/if}{if $option@iteration == 2} is--second{/if}{if $option@last} is--last{/if}{if $option['required']} is--active{/if}"{if $option['required']} data-swag-custom-products-required="true"{/if}>

                        {* Label *}
                        {block name="frontend_detail_swag_custom_products_options_label"}

                        {* Is needed for grouping the properties in the ring_group container *}
                        {if $option@iteration >= 3 && $option@iteration <= 6}
                            <div class="{if $option@iteration == 3 || $option@iteration == 6}conf_left{/if}">
                        {/if}

                            {if $option@iteration >= 3 && ($option@iteration !== 10 && $option@iteration !== 11 && $option@iteration !== 12 && $option@iteration !== 13 && $option@iteration !== 14 && $option@iteration !== 15)}
                                <label for="custom-products-option-{$option@index}" class="custom-products--label" data-custom-products-collapse-panel="true" data-label="{$option['name']}">
                                    {if count($nameParts) > 1}{$nameParts.1}{else}{$option['name']}{/if}{if $option['required']}&nbsp;**{/if}

                                    {$surcharge = $option['surcharge']}
                                    {if $surcharge != 0.00}
                                        {$optionPercentage = "{if $option['prices'][0]['is_percentage_surcharge']}{$option['prices'][0]['percentage']}%{/if}"}

                                        {* Once price for the option *}
                                        {block name="frontend_detail_swag_custom_products_options_once_price"}
                                            {if $option['is_once_surcharge']}
                                                (+ {if $optionPercentage}{$optionPercentage}{else}{$surcharge|currency}{/if}&nbsp;{s name="detail/index/once_price"}{/s}{s name="Star" namespace="frontend/listing/box_article"}{/s})
                                            {/if}
                                        {/block}

                                        {block name="frontend_detail_swag_custom_products_options_surcharges_price"}
                                            {if !$option['is_once_surcharge']}
                                                {$packUnit = $sArticle.packunit}

                                                {if !$packUnit}
                                                    {$packUnit= "{s name='detail/index/surcharge_price_unit'}{/s}"}
                                                {/if}

                                                (+ {if $optionPercentage}{$optionPercentage}{else}{$surcharge|currency}{/if} / {$packUnit}{s name="Star" namespace="frontend/listing/box_article"}{/s})
                                            {/if}
                                        {/block}
                                    {/if}

                                    <a href="#" class="custom-products--toggle-btn">
                                        <i class="icon--arrow-down" data-expanded="icon--arrow-up" data-collapsed="icon--arrow-down"></i>
                                    </a>
                                </label>
                            {/if}

                            {* Shows the profil modalbox *}
                            {if $option@iteration == 1}
                                <div {if $sArticle.attr5 != "0"}class="profil_container" data-modalbox="true" data-width="800px" data-height="350px" data-targetSelector="a" data-content="" data-mode="ajax"{else} style="width:90px; height:90px"{/if}>
                                    <a id="profileContainer" title="Profil auswählen" href="{url module=widgets controller=AsfProfiles}?profile={$sArticle.attr5}&articleID={$sArticle.articleID}" class="call_profil_modalbox {if $sArticle.attr5 != "0"}asf-sprite profil{$sArticle.attr5}{/if}"></a>
                                </div>
                            {/if}

                            {/block}

                            {* Include the actual option template file *}
                            <div class="custom-product--option-wrapper custom-products--{$option['type']|lower}">
                                {include file=$path key=$option@index}

                                <div class="custom-product--interactive-bar">
                                    {* Option actions *}
                                    {block name="frontend_detail_swag_custom_products_options_actions"}
                                        <div class="custom-products--option-actions">

                                            {block name="frontend_detail_swag_custom_products_options_reset_action"}
                                                <span class="custom-products--option-reset filter--active" data-custom-products-reset="true">
                                                <span class="filter--active-icon"></span>
                                                    {s name="detail/index/reset_values"}reset{/s}
                                            </span>
                                            {/block}
                                        </div>
                                    {/block}

                                    {* add the description for each option *}
                                    {block name="frontend_detail_swag_custom_products_options_description"}
                                        {if $option['description']}
                                            {block name="frontend_detail_swag_custom_products_options_description_link"}
                                                <div class="is--hidden custom-product--modal-content{$option['id']}">
                                                    {$option['description']}
                                                </div>
                                                <div class="custom-products--option-description-link" data-description-plugin="true"
                                                     data-title="{s name='detail/index/btn/read/description'}More information{/s}"
                                                     data-content-selector="custom-product--modal-content{$option['id']}">

                                                    <span>{s name="detail/index/btn/read/description"}More information{/s}&nbsp;</span>
                                                    <i class="icon--service"></i>
                                                </div>
                                            {/block}
                                        {/if}
                                    {/block}
                                </div>
                            </div>

                            {* Closing conf_left container *}
                            {if $option@iteration >= 3 && $option@iteration <= 6}
                                </div>
                            {/if}

                    </div>
                    {if $option@iteration == 4 || $option@iteration == 5 || $option@iteration == 7 || $option@iteration == 8}
                        </div>
                    {/if}
                {/if}

                {* Closing ring_group container *}
                {if $option@iteration == 5 || $option@iteration == 8 || $option@iteration == 9 || $option@iteration == 10 || $option@iteration == 11}
                    </fieldset>
                {/if}

            {/foreach}

            {* Global form actions *}
            {block name="frontend_detail_custom_products_actions"}
                <div class="custom-products--option-reset-all">
                    <span class="custom-products--global-reset filter--active">
                        <span class="filter--active-icon"></span>
                        {s name="detail/index/reset_configuration"}Reset configuration{/s}
                    </span>
                </div>
            {/block}

            {* Do we have to show a notice for required fields? *}
            {block name="frontend_detail_custom_products_required_info"}
                {if $displayRequiredInfo}
                    <div class="custom-products--required-field-info">
                        **&nbsp;{s name="detail/option/index/required_field_info"}Required fields{/s}
                    </div>
                {/if}
            {/block}
        </div>
    {/block}
{/block}