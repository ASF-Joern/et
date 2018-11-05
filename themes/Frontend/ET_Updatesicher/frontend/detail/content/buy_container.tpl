{extends file="parent:frontend/detail/content/buy_container.tpl"}

{* Include buy button and quantity box *}
{block name="frontend_detail_index_buybox"}{/block}

{* Product actions *}
{block name="frontend_detail_index_actions"}{/block}

{* Product - Base information *}
{block name='frontend_detail_index_buy_container_base_info'}
    <ul class="product--base-info list--unstyled buybox-bottom">

        {* Product SKU *}
        {block name='frontend_detail_data_ordernumber'}
            <li class="base-info--entry entry--sku">

                {* Product SKU - Label *}
                {block name='frontend_detail_data_ordernumber_label'}
                    <strong class="entry--label">
                        {s name="DetailDataId" namespace="frontend/detail/data"}{/s}
                    </strong>
                {/block}

                {* Product SKU - Content *}
                {block name='frontend_detail_data_ordernumber_content'}
                    <meta itemprop="productID" content="{$sArticle.articleDetailsID}"/>
                    <span class="entry--content" itemprop="sku">
                                {$sArticle.ordernumber}
                            </span>
                {/block}
            </li>
        {/block}

        {* Product attributes fields *}
        {block name='frontend_detail_data_attributes'}

            {* Product attribute 1 *}
            {block name='frontend_detail_data_attributes_attr1'}
                {if $sArticle.attr1}
                    <li class="base-info--entry entry-attribute">
                        <strong class="entry--label">
                            {s name="DetailAttributeField1Label" namespace="frontend/detail/index"}{/s}:
                        </strong>

                        <span class="entry--content">
                                    {$sArticle.attr1|escape}
                                </span>
                    </li>
                {/if}
            {/block}

            {* Product attribute 2 *}
            {block name='frontend_detail_data_attributes_attr2'}
                {if $sArticle.attr2}
                    <li class="base-info--entry entry-attribute">
                        <strong class="entry--label">
                            {s name="DetailAttributeField2Label" namespace="frontend/detail/index"}{/s}:
                        </strong>

                        <span class="entry--content">
                                    {$sArticle.attr2|escape}
                                </span>
                    </li>
                {/if}
            {/block}
        {/block}
    </ul>
{/block}