{extends file="parent:frontend/plugins/index/delivery_informations.tpl"}
{block name='frontend_widgets_delivery_infos' append}
{if {controllerName|lower} !== "note"}
    <div class="buybox-top">
        {include file="frontend/detail/buy.tpl"}
        <nav class="product--actions">
            {include file="frontend/detail/actions.tpl"}
            <div class="product--delivery" style="display:block;">
                <link itemprop="availability" href="http://schema.org/LimitedAvailability" />
                <p class="delivery--information" style="display:block;">
                    <span class="delivery--text delivery--text-more-is-coming">
                        <i class="delivery--status-icon icon--truck"></i>
                        {s name="DetailDataShippingtime"}{/s} {$sArticle.shippingtime} {s name="DetailDataShippingDays"}{/s}
                    </span>
                </p>
            </div>
        </nav>

        <ul class="product--base-info list--unstyled">
            <li class="base-info--entry entry--sku">
                <strong class="entry--label">
                    {s name="DetailDataId" namespace="frontend/detail/data"}{/s}
                </strong>

                <meta itemprop="productID" content="{$sArticle.articleDetailsID}"/>
                <span class="entry--content" itemprop="sku">
                    {$sArticle.ordernumber}
                </span>
            </li>
        </ul>
    </div>
{/if}
{/block}