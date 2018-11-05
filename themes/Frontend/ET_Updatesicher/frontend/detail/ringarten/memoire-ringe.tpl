{assign var="options" value=$swagCustomProductsTemplate.options}

<div class="change_ring_container">
    <div class="change_ring_color">
        <h4>Material</h4>
        {assign var="classSwitcher" value=false}
        {assign var="subcategories" value=""}
        {foreach $sCategories as $cat}
            {if $cat.name == "Memoire Ringe"}
                {$subcategories = $cat.subcategories}
                {break}
            {/if}
        {/foreach}
        {foreach $asfColorSwitcher as $color}

            {assign var="categoryID" value=""}
            {assign var="iconPath" value=""}
            {assign var="iconName" value=""}
            {foreach $subcategories as $category}
                {assign var="name" value=" "|explode:$category.name}
                {if $name.1 == $color.name}
                    {$categoryID = $category.id}
                    {$iconPath = $category.media.path}
                    {$iconName = $category.media.name}
                    {break}
                {/if}
            {/foreach}

            <div class="{if $classSwitcher}color_right{$classSwitcher = true}{else}color_left{$classSwitcher = false}{/if} {if $color.name == $sArticle.attr13}is--active{/if}">
                <img src="{$iconPath}" alt="{$iconName}">
                <span class="color_text">{$color.name}</span>
            </div>
        {/foreach}

    </div>
    {foreach from=$options key=key item=option}

        {if $option.name == "Legierung" || $option.name == "Steinbesatz" || $option.name == "Reinheit"}
            <div id="asf_custom-products-option-{$key}" class="wizard--input custom-products--validation-wrapper change_{$option.name|lower}" data-group-field="true"{if $option['required']} data-validate-group="true" data-validate-message="{s name='detail/validate/radio'}{/s}"{/if}>
                {if $option.name == "Reinheit"}
					<h4>Steinanzahl</h4>
                        <div class="stone_quantity" style="display:inline-block">
							<span>{$sArticle.attr11}</span> 
						</div>
						<div class="tooltip"> [?]
							<div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Aktueller Steinbesatz</h4>
								</div>
								<div class="tooltip-content">
									Die Anzahl der Steine richtet sich nach der ausgewählten Ringgröße.
								</div>
							</div>
						</div>
				{/if}
				{if $option.name == "Steinbesatz"}
					<h4>Steingr&ouml;&szlig;e</h4>
				{else}
					{if $option.name === "Reinheit"}
                        <h4 style="margin-top: 5px; margin-bottom: 0px;">{$option.name}</h4>
                    {else}
                        <h4>{$option.name}</h4>
                    {/if}
				{/if}
                {foreach $option['values'] as $value}
                    {* Palladium: 585er,950er || Platin: 600er,950er*}
                    <div class="custom-products--radio-value {if $value['name'] == "Ohne Stein/e"}is--hidden no_stone {/if}
                        {if $option.name == "Legierung"}
                            {if $asfMaterial == "silber" && $value.name != "925er"} is--hidden{/if}
                            {if $asfMaterial == "platin" && $value.name != "600er" && $value.name != "950er"} is--hidden{/if}
                            {if $asfMaterial == "palladium" && $value.name != "585er" && $value.name != "950er"} is--hidden{/if}
                            {if $asfMaterial == "gold" && $value.name != "333er" && $value.name != "585er" && $value.name != "750er"} is--hidden{/if}
                        {/if}
                        ">

                        {* Output the actual field *}
                        <label class="custom-products--radio-label" for="change_custom-products--radio-{$key}-{$value@index}">
                            {if $option.name === "Steinbesatz"}
                                {assign var="part" value="/"|explode:$value.name}
                                {$part.0}
                            {else}
                                {$value.name}
                            {/if}
                            <span class="filter-panel--radio">
                                <input type="radio" id="change_custom-products--radio-{$key}-{$value@index}" class="{$option.name|lower}" data-value="{$value['name']}"
                                       name="change-custom-option-id--{$option['id']}"
                                       value="{$value['id']}"
                                        {if $value['is_default_value']} data-default-value="{$value['id']}"{/if}
                                        {if ($option.name == "Steinbesatz" && $value['name'] == $sArticle.attr6)
                                        || ($option.name == "Legierung" && $value['name'] == $sArticle.attr7) || ($sArticle.attr7 === "925er" && $value['name'] == "Zirkonia")
                                        || ($sArticle.attr7 !== "925er" && $value['name'] == "G/SI")} checked="checked"{/if} form="swagArticleForm" />
                                <span class="radio--state">&nbsp;</span>
                            </span>
                        </label>
						
                        {if $option.name == "Reinheit"}
                            {if $value['name'] == "Zirkonia"}
                                <div class="tooltip">[?]
                                    <div class="tooltiptext"> <div class="tooltip-header">
                                            <h4 class="tooltip-title">Zirkonia</h4>
                                        </div>
                                        <div class="tooltip-content">
                                            Zirkoniasteine sind künstlich hergestellte Schmucksteine. Sie sind kaum von echten Diamanten zu unterscheiden und strahlen ebenso wundersch&ouml;n.
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $value['name'] == "G/SI"}
                                <div class="tooltip">[?]
                                    <div class="tooltiptext"> <div class="tooltip-header">
                                            <h4 class="tooltip-title">G/SI Diamant</h4>
                                        </div>
                                        <div class="tooltip-content">
                                            <strong>G</strong> - Feines Weiß<hr>
                                            <strong>SI</strong> - Kleine Einschlüsse (<strong>S</strong>mall <strong>I</strong>nclusions)
                                            <img src="/themes/Frontend/ET_Updatesicher/frontend/images/tooltips/diamant-kleine-einschluesse-si.jpg" alt="kleine-einschluesse-si-diamant">
                                            Der Diamant hat - von einem Fachmann mit 10-facher Vergrößerung begutachtet - kleine Einschlüsse, die leicht zu erkennen sind.
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $value['name'] == "G/VS"}
                                <div class="tooltip">[?]
                                    <div class="tooltiptext"> <div class="tooltip-header">
                                            <h4 class="tooltip-title">G/VS Diamant</h4>
                                        </div>
                                        <div class="tooltip-content">
                                            <strong>G</strong> - Feines Weiß<hr>
                                            <strong>VS</strong> - Sehr kleine Einschlüsse (<strong>V</strong>ery <strong>S</strong>mall Inclusions)
                                            <img src="/themes/Frontend/ET_Updatesicher/frontend/images/tooltips/diamant-sehr-kleine-einschluesse-vs.jpg" alt="sehr-kleine-einschluesse-vs-diamant">
                                            Der Diamant hat - von einem Fachmann mit 10-facher Vergrößerung begutachtet - sehr kleine Einschlüsse, die kaum zu erkennen sind.
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            {if $value['name'] == "E/IF"}
                                <div class="tooltip">[?]
                                    <div class="tooltiptext"> <div class="tooltip-header">
                                            <h4 class="tooltip-title">E/IF Diamant</h4>
                                        </div>
                                        <div class="tooltip-content">
                                            <strong>E</strong> - Hochfeines Weiß<hr>
                                            <strong>IF</strong> - Lupenrein (<strong>I</strong>nternally <strong>F</strong>lawless)
                                            <img src="/themes/Frontend/ET_Updatesicher/frontend/images/tooltips/diamant-lupenrein-if.jpg" alt="lupenrein-if-diamant">
                                            Der Diamant hat - von einem Fachmann mit 10-facher Vergrößerung begutachtet - keine Einschlüsse. Diese Art von Diamanten ist extrem selten und somit auch am teuersten.
                                        </div>
                                    </div>
                                </div>
                            {/if}
                        {/if}						
                    </div>
                {/foreach}
            </div>
        {/if}

    {/foreach}

</div>