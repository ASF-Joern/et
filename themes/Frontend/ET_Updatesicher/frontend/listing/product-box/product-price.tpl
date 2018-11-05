{namespace name="frontend/listing/box_article"}

<div class="product--price">

    {* Default price *}
    {block name='frontend_listing_box_article_price_default'}
        <span class="price--default is--nowrap{if $sArticle.has_pseudoprice} is--discount{/if}">
            {if $sArticle.priceStartingFrom}{s name='ListingBoxArticleStartsAt'}{/s} {/if}
            {$sArticle.price|currency}
            {if $sArticle.description|substr:0:9 === "Trauringe" || $sArticle.description|substr:0:12 === "Partnerringe" || $sArticle.description|substr:0:3 === "ASF"}
                {s name="Paarpreis"}<span class="paarpreis">| Paarpreis</span>{/s}
            {/if}
            {s name="Star"}{/s}
        </span>
    {/block}

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
                    {s name="Star"}{/s}
                </span>

                {block name='frontend_listing_box_article_price_discount_after'}
                    {s name="priceDiscountInfo" namespace="frontend/detail/data"}{/s}
                {/block}
            </span>
        {/if}
    {/block}
</div>