{extends file="parent:frontend/detail/data.tpl"}
{block name='frontend_detail_data_price_default'}
    <span class="price--content content--default">
        <meta itemprop="price" content="{$sArticle.price|replace:',':'.'}">
        {if $sArticle.priceStartingFrom}
            {s name='ListingBoxArticleStartsAt' namespace="frontend/listing/box_article"}{/s}
        {/if}
        {$sArticle.price|currency}*{if $asfTemplateFile !== "verlobungsringe.tpl" && $asfTemplateFile !== "memoire-ringe.tpl"}<span class="paarpreis">| Paarpreis</span>{/if}
    </span>
{/block}