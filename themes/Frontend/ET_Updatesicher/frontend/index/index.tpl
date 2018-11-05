{extends file="parent:frontend/index/index.tpl"}

{block name='frontend_index_container_ajax_cart' append}
    <div id="mobile-service">
		<ul>
			<li><span>✔</span> Echtheitszertifikat</li>
			<li><span>✔</span> 1 Monat Widerrufsrecht</li>
			<li><span>✔</span> Kostenlose Gravur</li>
			<li><span>✔</span> Kostenloser Versand</li>
			<li><span>✔</span> Made in Germany</li>
			<li><span>✔</span> Lebenslange Garantie</li>
		</ul>								
	</div>
{/block}

{block name='frontend_index_content_main' prepend}
    {* Breadcrumb *}
    {block name='frontend_index_breadcrumb'}
        {if count($sBreadcrumb)}
			
				<nav class="content--breadcrumb block">
				<div class="container">
					{block name='frontend_index_breadcrumb_inner'}
						{include file='frontend/index/breadcrumb.tpl'}
					{/block}
				</div>
				</nav>
        {/if}
    {/block}
{/block}

{block name='frontend_index_content_main'}
	<section class="{block name="frontend_index_content_main_classes"}content-main container block-group{/block}">

        {* Content top container *}
        {block name="frontend_index_content_top"}{/block}

		<div class="content-main--inner">
            {* Sidebar left *}
            {block name='frontend_index_content_left'}
                {include file='frontend/index/sidebar.tpl'}
            {/block}

            {* Main content *}
            {block name='frontend_index_content_wrapper'}
				<div class="content--wrapper">
                    {block name='frontend_index_content'}{/block}
				</div>
            {/block}

            {* Sidebar right *}
            {block name='frontend_index_content_right'}{/block}
			
		</div>
	</section>
{/block}

{block name="frontend_index_footer" prepend}
	{block name='frontend_index_left_last_articles'}
		{if $sLastArticlesShow && !$isEmotionLandingPage}
			{* Last seen products *}

				<div class="last-seen-products is--hidden" data-last-seen-products="true">
							<div class="last-seen-products--title">
							{s namespace="frontend/plugins/index/viewlast" name='WidgetsRecentlyViewedHeadline'}{/s}
						</div>
					<div class="container">
						
						<div class="last-seen-products--slider product-slider" data-product-slider="true">
							<div class="last-seen-products--container product-slider--container"></div>
						</div>
					</div>
				</div>
		{/if}
	{/block}
{/block}