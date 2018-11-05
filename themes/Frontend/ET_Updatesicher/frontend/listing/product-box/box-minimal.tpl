{extends file="frontend/listing/product-box/box-basic.tpl"}

{namespace name="frontend/listing/box_article"}

{block name='frontend_listing_box_article_description'}{/block}

{block name='frontend_listing_box_article_actions'}{/block}

{block name='frontend_listing_box_article_price'}
    <div class="product--price-outer">
        <div class="product--price">

            {* Discount price *}
            {block name='frontend_listing_box_article_price_discount'}
                {if $sArticle.has_pseudoprice}
                    <span class="price--pseudo">

                        {block name='frontend_listing_box_article_price_discount_before'}
                            {s name="priceDiscountLabel" namespace="frontend/detail/data"}{/s}
                        {/block}

                        <span class="price--discount is--nowrap">
                            {$sArticle.pseudoprice|currency}
                            {if $sArticle.description|substr:0:9 === "Trauringe" || $sArticle.description|substr:0:12 === "Partnerringe" || $sArticle.description|substr:0:3 === "ASF"}
                                {s name="Paarpreis"}<span class="paarpreis">| Paarpreis</span>{/s}
                            {/if}
                        </span>

                        {block name='frontend_listing_box_article_price_discount_after'}
                            {s name="priceDiscountInfo" namespace="frontend/detail/data"}{/s}
                        {/block}
                    </span>
                {/if}
            {/block}

            {* Default price angepasst *}
            {block name='frontend_listing_box_article_price_default'}
                <span class="price--default is--nowrap{if $sArticle.has_pseudoprice} is--discount{/if}">
                    {if $sArticle.priceStartingFrom && !$sArticle.liveshoppingData}{s name='ListingBoxArticleStartsAt'}{/s} {/if}
                    {if $smarty.get.model == 1}ab {/if}
                    {$sArticle.price|currency}
                    {if $sArticle.description|substr:0:9 === "Trauringe" || $sArticle.description|substr:0:12 === "Partnerringe" || $sArticle.description|substr:0:3 === "ASF"}
                        {s name="Paarpreis"}<span class="paarpreis">| Paarpreis</span>{/s}
                    {/if}
                </span>
            {/block}

            {block name='frontend_listing_box_article_actions_save'}
                {if !$sArticle.attributes.AsfAfterbuyIsMarked}
                    <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber _seo=false}" method="post">
                        <button type="submit"
                                title="{"{s name='DetailLinkNotepad' namespace='frontend/detail/actions'}{/s}"|escape}"
                                class="product--action action--note"
                                data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber _seo=false}"
                                data-text="{s name="DetailNotepadMarked"}{/s}">
                            <i class="icon--heart"></i> <span class="action--text">{s name="DetailLinkNotepadShort" namespace="frontend/detail/actions"}{/s}</span>
                        </button>
                    </form>
                {else}
                    <form action="{url controller='note'}" method="post">
                        <button type="submit"
                                title="{"{s name='DetailNotepadMarkedTitle' namespace='frontend/detail/actions'}Jetzt Merkzettel ansehen{/s}"|escape}"
                                class="product--action action--note js--is-saved">
                            <i class="icon--check"></i> <span class="action--text">{s name="DetailNotepadMarked"}{/s}</span>
                        </button>
                    </form>
                {/if}
            {/block}
        </div>
    </div>
{/block}

