{namespace name="frontend/listing/listing_actions"}

{block name="frontend_listing_filter_facet_multi_selection"}

    <div class="{$asfDesignClass}filter-panel filter--multi-selection filter-facet--{$filterType} facet--{$facet->getFacetName()|escape:'htmlall'}"
         data-filter-type="{$filterType}"
         data-facet-name="{$facet->getFacetName()}"
         data-field-name="{$facet->getFieldName()|escape:'htmlall'}">

        {block name="frontend_listing_filter_facet_multi_selection_flyout"}
            <div class="{$asfDesignClass}filter-panel--flyout">

                {block name="frontend_listing_filter_facet_multi_selection_title"}
                    <label class="{$asfDesignClass}filter-panel--title" for="{$facet->getFieldName()|escape:'htmlall'}">
                        {$facet->getLabel()|escape}
                    </label>
                {/block}

                {block name="frontend_listing_filter_facet_multi_selection_icon"}
                    <span class="{$asfDesignClass}filter-panel--icon"></span>
                {/block}

                {block name="frontend_listing_filter_facet_multi_selection_content"}
                    {$inputType = 'checkbox'}

                    {if $filterType == 'radio'}
                        {$inputType = 'radio'}
                    {/if}

                    {$indicator = $inputType}

                    {$isMediaFacet = false}
                    {if $facet|is_a:'\Shopware\Bundle\SearchBundle\FacetResult\MediaListFacetResult'}
                        {$isMediaFacet = true}

                        {$indicator = 'media'}
                    {/if}

                    <div class="filter-panel--content input-type--{$indicator}">

                        {block name="frontend_listing_filter_facet_multi_selection_list"}
                            <ul class="filter-panel--option-list">

                                {if $sCategories[$sCategoryContent.id].path == "|3|"}
                                    {assign var="categories" value=$sCategories[$sCategoryContent.id].subcategories}
                                {/if}

                                {if $categories && $facet->getFieldName()|escape:'htmlall' == "material"}
                                    {assign var="sorting" value=["Gelbgold", "Weißgold", "Gelb-/Weißgold", "Rot-/Weißgold",
                                    "Rotgold", "Roségold","Platin","Palladium","Tricolorgold"]}
                                {/if}
                                {if $facet->getFieldName()|escape:'htmlall' == "legierung"}
                                    {assign var="sorting" value=["333er","585er","750er","600er","925er","950er"]}
                                {/if}

                                    {foreach $facet->getValues() as $option}

                                        {block name="frontend_listing_filter_facet_multi_selection_option"}
                                            <li class="filter-panel--option{if $categories} asf-filter{/if}{if $facet->getFieldName()|escape:'htmlall' == "legierung"}-alloy{/if}">

                                                {block name="frontend_listing_filter_facet_multi_selection_option_container"}
                                                    <div class="option--container">

                                                        {block name="frontend_listing_filter_facet_multi_selection_input"}
                                                            <span class="filter-panel--input filter-panel--{$inputType}{if $inputType == "checkbox"} asf-filter{/if}{if $option@first} icons{/if}
                                                                {if !empty($smarty.get['material']) && $facet->getFieldName()|escape:'htmlall' == "legierung" && empty($sBreadcrumb[1])}is--disabled{/if}">

                                                                {assign var="found" value=false}

                                                                {if $categories || ($facet->getFieldName()|escape:'htmlall' == "material" && !empty($sBreadcrumb[1]))}
                                                                    {foreach $categories as $category}
                                                                        {assign var="cat" value=" "|explode:$category.name}
                                                                        {if $category.media && $cat.1|escape:'htmlall' == $option->getId()|escape:'htmlall'}
                                                                            {$found = true}
                                                                            
                                                                            <img class="asf_category_icon" src="{$category.media.path}" title="Zu {$category.name} wechseln" alt="{$category.name|lower}-icon">
                                                                        {/if}
                                                                    {foreachelse}
                                                                        {$found = true}
                                                                        <img class="asf_category_icon" src="{$sCategoryContent.media.source}" title="{$sCategoryContent.name}" alt="{$sCategoryContent.name|lower}-icon">
                                                                    {/foreach}
                                                                {/if}
                                                                {$name = "__{$facet->getFieldName()|escape:'htmlall'}__{$option->getId()|escape:'htmlall'}"}
                                                                {if $filterType == 'radio'}
                                                                    {$name = {$facet->getFieldName()|escape:'htmlall'} }
                                                                {/if}

                                                                <input type="{$inputType}"
                                                                       {if !empty($smarty.get['material']) && $facet->getFieldName()|escape:'htmlall' == "legierung"
                                                                       && empty($sBreadcrumb[1])}disabled=""{/if}
                                                                       id="__{$facet->getFieldName()|escape:'htmlall'}__{$option->getId()|escape:'htmlall'}"
                                                                       name="{$name}"
                                                                       value="{$option->getId()|escape:'htmlall'}"
                                                                       class="{if !empty($smarty.get['material']) && $facet->getFieldName()|escape:'htmlall' == "legierung" && empty($sBreadcrumb[1])}is--disabled{/if}"
                                                                        {if $option->isActive() || ($facet->getFieldName()|escape:'htmlall' == "material"
                                                                        && !empty($sBreadcrumb[1]))}checked="checked" {/if}
                                                                {if $facet->getFieldName()|escape:'htmlall' == "material" && !empty($sBreadcrumb[1])}
                                                                    onclick="document.location.href = String(window.location.pathname).split('-')[0] + '/'; return false;"{/if}/>

                                                                {if !$found}
                                                                    <span class="input--state {$inputType}--state">&nbsp;</span>
                                                                {/if}

                                                            </span>
                                                        {/block}

                                                        {block name="frontend_listing_filter_facet_multi_selection_label"}
                                                            <label class="filter-panel--label{if $categories} asf-filter{/if}"
                                                                   for="__{$facet->getFieldName()|escape:'htmlall'}__{$option->getId()|escape:'htmlall'}">

                                                                {if $facet|is_a:'\Shopware\Bundle\SearchBundle\FacetResult\MediaListFacetResult'}
                                                                    {$mediaFile = {link file='frontend/_public/src/img/no-picture.jpg'}}
                                                                    {if $option->getMedia()}
                                                                        {$mediaFile = $option->getMedia()->getFile()}
                                                                    {/if}

                                                                    <img class="filter-panel--media-image" src="{$mediaFile}" alt="{$option->getLabel()|escape:'htmlall'}" />
                                                                {else}
                                                                    {$option->getLabel()|escape}
                                                                {/if}
                                                            </label>
                                                        {/block}
                                                    </div>
                                                {/block}
                                            </li>
                                        {/block}
                                    {/foreach}

                            </ul>
                        {/block}
                    </div>
                {/block}
            </div>
        {/block}
    </div>
{/block}
