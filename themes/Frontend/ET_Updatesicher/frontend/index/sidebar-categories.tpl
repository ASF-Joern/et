{* Maincategories left *}
{function name=categories level=0}
    <ul class="sidebar--navigation categories--navigation navigation--list{if !$level} is--drop-down{/if} is--level{$level}{if $level >= 1 && (empty($sBreadcrumb[1]) && ($sBreadcrumb[0].name == "Trauringe" || $sBreadcrumb[0].name == "Verlobungsringe"))} navigation--level-high is--hidden{/if} is--rounded" role="menu">
        {* @deprecated The block "frontend_index_categories_left_ul" will be removed in further versions, please use "frontend_index_categories_left_before" *}
        {block name="frontend_index_categories_left_ul"}{/block}

        {block name="frontend_index_categories_left_before"}{/block}
        {foreach $categories as $category}
            {block name="frontend_index_categories_left_entry"}

                {if $category.description === "Ringe"}
                    {continue}
                {/if}

                <li class="navigation--entry{if $category.flag} is--active{/if}{if $category.media.path && $category.path != "|3|"} asf_category{/if}{if $category.subcategories} has--sub-categories{/if}{if $category.childrenCount} has--sub-children{/if}" role="menuitem">
                    {if $category.media.path}
                        <img class="asf_category_icon" src="{$category.media.path}" alt="{$category.description}">
                    {/if}
                    <a class="{if $category.media.path && $category.path != "|3|"} asf_category{/if} navigation--link{if $category.flag} is--active{/if}{if $category.subcategories} has--sub-categories{/if}{if $category.childrenCount} link--go-forward{/if}"
                       href="{$category.link}"
                       data-categoryId="{$category.id}"
                       data-fetchUrl="{url module=widgets controller=listing action=getCategory categoryId={$category.id}}"
                       title="{$category.description|escape}"
                       {if $category.external && $category.externalTarget}target="{$category.externalTarget}"{/if}>

                        {assign var=catName value=" "|explode:$category.description}
                        {if $category.path != "|3|"}
                            {if $catName.1 == "925er"}
                                {$catName.1} {$catName.2}
                            {else}
                                {$catName.1}
                            {/if}
                        {else}
                            {$category.description}
                        {/if}
                        {if $category.childrenCount}
                            <span class="is--icon-right">
                                <i class="icon--arrow-right"></i>
                            </span>
                        {/if}
                    </a>
                    {block name="frontend_index_categories_left_entry_subcategories"}
                        {if $category.subcategories}
                            {call name=categories categories=$category.subcategories level=$level+1}
                        {/if}
                    {/block}
                </li>

            {/block}
        {/foreach}
        {block name="frontend_index_categories_left_after"}{/block}
    </ul>
{/function}

{function name=allowedCategory cat=""}
    {if $cat != ""}
        {if $cat != "Carbon" && $cat != "925er" && $cat != "Edelstahl" && $cat != "Titanium" && $cat != "Keramik"}
            is--hidden
        {/if}
    {/if}
{/function}

{if $sCategories}
    {call name=categories categories=$sCategories}
{elseif $sMainCategories}
    {call name=categories categories=$sMainCategories}
{/if}