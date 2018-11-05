{extends file="parent:frontend/listing/listing.tpl"}
{* Listing wrapper *}
{block name="frontend_listing_listing_wrapper"}
    {if $showListing}

        {$listingCssClass = "listing--wrapper"}

        {foreach $showListingDevices as $device}
            {$listingCssClass = "{$listingCssClass} visible--{$emotionViewports[$device]}"}
        {/foreach}

        {if $theme.sidebarFilter}
            {$listingCssClass = "{$listingCssClass} has--sidebar-filter"}
        {/if}

        <div class="{$listingCssClass} {$sBreadcrumb[0].name|lower}{if $sBreadcrumb[1].id != 0}-unterkategorie{/if}">

            {* Sorting and changing layout *}
            {block name="frontend_listing_top_actions"}
                {include file='frontend/listing/listing_actions.tpl'}
            {/block}

            {block name="frontend_listing_listing_container"}
                <div class="listing--container">

                    {block name="frontend_listing_no_filter_result"}
                        <div class="listing-no-filter-result">
                            {include file="frontend/_includes/messages.tpl" type="info" content="{s name=noFilterResult}Für die Filterung wurden keine Ergebnisse gefunden!{/s}" visible=false}
                        </div>
                    {/block}

                    {block name="frontend_listing_listing_content"}
                        <div class="listing"
                             data-ajax-wishlist="true"
                             data-compare-ajax="true"
                                {if $theme.infiniteScrolling}
                            data-infinite-scrolling="true"
                            data-loadPreviousSnippet="{s name="ListingActionsLoadPrevious"}{/s}"
                            data-loadMoreSnippet="{s name="ListingActionsLoadMore"}{/s}"
                            data-categoryId="{$sCategoryContent.id}"
                            data-pages="{$pages}"
                            data-threshold="{$theme.infiniteThreshold}"
                                {/if}>

                            {* Actual listing *}
                            {block name="frontend_listing_list_inline"}
                                {foreach $sArticles as $sArticle}
                                    {include file="frontend/listing/box_article.tpl"}
                                {/foreach}
                            {/block}
                        </div>
                    {/block}
                </div>
            {/block}

            {* Paging *}
            {block name="frontend_listing_bottom_paging"}
                <div class="listing--bottom-paging">
                    {include file="frontend/listing/actions/action-pagination.tpl"}
                </div>
            {/block}
        </div>
    {/if}
{/block}