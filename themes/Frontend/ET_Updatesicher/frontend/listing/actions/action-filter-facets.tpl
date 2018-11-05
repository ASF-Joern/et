{**
 * Iteration for the different filter facets.
 * The file is called recursive for deeper structured facet groups.
 *}
{foreach $facets as $facet}
    {if $facet->getTemplate() !== null}
        {if $sBreadcrumb[0].name == "Trauringe"}
            {if $facet@iteration == 1 || $facet@iteration == 2 || $facet@iteration == 4}
                <div class="filter-col-{$facet@iteration}">
            {/if}
            {include file=$facet->getTemplate() facet=$facet}
            {if $facet@iteration == 1 || $facet@iteration == 3 || $facet@iteration == 6}
                </div>
            {/if}
        {else}
            {include file=$facet->getTemplate() facet=$facet}
        {/if}
    {/if}
{/foreach}