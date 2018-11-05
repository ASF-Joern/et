{extends file='parent:frontend/blog/listing_sidebar.tpl'}

{* Blog listing sidebar right *}
{block name='frontend_index_content_right'}
    <div class="blog--filter-options off-canvas">

        {* Filter container *}
        {block name='frontend_listing_actions_filter_container'}

            {block name='frontend_listing_actions_filter_closebtn'}
                <a href="#" title="{"{s name="ListingActionsCloseFilter"}{/s}"|escape}" class="blog--filter-close-btn">{s namespace='frontend/listing/listing_actions' name='ListingActionsCloseFilter'}{/s} <i class="icon--arrow-right"></i></a>
            {/block}

            <div class="filter--container">

                {* Filter headline *}
                {block name="frontend_listing_actions_filter_container_inner"}
                    <div class="filter--headline">{s name='FilterHeadline'}{/s}</div>
                {/block}

                <div class="blog--sidebar">

                    {* Blog navigation *}
                    {block name="frontend_blog_index_navigation"}
                        <div class="blog--navigation block-group">
	
<div class="blog--filter blog--filter-search has--border is--rounded filter--group block">

			{* Filter headline *}
			{block name="frontend_blog_filter_search_headline"}
				<div class="blog--filter-headline blog--sidebar-title collapse--header blog-filter--trigger">
					{s name="BlogHeaderFilterSearch"}Suche{/s}<span class="filter--expand-collapse collapse--toggler"></span>
				</div>
			{/block}

			{* Filter content *}
			{block name="frontend_blog_filter_search_content"}

				{block name="frontend_blog_filter_search_content_form"}
					<div class="blog--filter-content blog--sidebar-body collapse--content">
						<form class="filtersearch--form" action="#" method="get">

							{block name="frontend_blog_filter_search_content_form_field"}
								<input type="text" name="sFilterSearch" class="filtersearch--field" placeholder="{s name="IndexSearchFieldSubmit"}Suchbegriff{/s}" value="{if !empty($sFilterSearch)}{$sFilterSearch}{/if}" />
							{/block}

                            {if $sFormFilterDate}
								<input type="hidden" name="sFilterDate" value="{$sFormFilterDate}" />
                            {/if}

                            {if $sFormFilterTags}
								<input type="hidden" name="sFilterTags" value="{$sFormFilterTags}" />
                            {/if}

                            {if $sFormFilterAuthor}
								<input type="hidden" name="sFilterAuthor" value="{$sFormFilterAuthor}" />
                            {/if}

                            {if $sFormFilterPage}
								<input type="hidden" name="p" value="{$sFormFilterPage}" />
                            {/if}

							{block name="frontend_blog_filter_search_content_form_submit"}
								<button type="submit" class="main-search--button">
									<i class="icon--search"></i>
								</button>
							{/block}

						</form>

						{if !empty($sFilterSearch)}
							<ul>
								<li class="filter--entry">
									<a href="{$sCategoryContent.sSelfCanonical}" class="filter--entry-link"
									   title="{"{s name='FilterLinkDefault' namespace='frontend/listing/filter_search'}Suche zurücksetzen{/s}"|escape}">
										<i class="icon--cross"></i>
										{s name='FilterLinkDefault' namespace='frontend/listing/filter_search'}Suche zurücksetzen{/s}
									</a>
								</li>
							</ul>
						{/if}

					</div>
				{/block}
			{/block}

		</div>
	
                            {* KATEGORIEN*}
                            {block name='frontend_blog_index_subscribe'}
                                <div class="blog--subscribe has--border is--rounded filter--group block">

                                    {* Ratgeber headline *}
                                    {block name="frontend_blog_index_subscribe_headline"}
                                        <div class="blog--subscribe-headline blog--sidebar-title collapse--header blog-filter--trigger">
                                            <span>Kategorien</span>
                                        </div>
                                    {/block}

                                    {* Ratgeber Content *}
                                    {block name="frontend_blog_index_subscribe_content"}
                                        <div class="blog--subscribe-content blog--sidebar-body collapse--content">
                                            {foreach from=$sCategories key=key item=main}
                                                {if $main.blog}
                                                    <ul>
                                                    {foreach from=$main.subcategories item=sub}
                                                        <li>
                                                            <a href="{url controller=blog sCategory=$sub.id}">{$sub.name}</a>
                                                        </li>
                                                    {/foreach}
                                                    </ul>
                                                {/if}
                                            {/foreach}
                                        </div>
                                    {/block}
                                </div>
                            {/block}

                            {* RATGEBER *}
                            {block name='frontend_blog_index_subscribe'}
                                <div class="blog--subscribe has--border is--rounded filter--group block">

                                    {* Ratgeber headline *}
                                    {block name="frontend_blog_index_subscribe_headline"}
                                        <div class="blog--subscribe-headline blog--sidebar-title collapse--header blog-filter--trigger">
                                            <span>Ratgeber</span>
                                        </div>
                                    {/block}

                                    {* Ratgeber Content *}
                                    {block name="frontend_blog_index_subscribe_content"}
                                        <div class="blog--subscribe-content blog--sidebar-body collapse--content">
											<a href="https://www.ewigetrauringe.de/ratgeber?p=1&sFilterTags=hochzeit" title="Zum Hochzeitsratgeber">
												<img src="https://www.ewigetrauringe.de/themes/Frontend/ET_Updatesicher/frontend/images/hochzeitsblog-ratgeber.png"
												alt="hochzeitsratgeber-blog-anschauen">
												<div class="ratgeber-bild-links">&raquo; Hochzeits<span>ratgeber</span></div>
											</a>
											<a href="https://www.ewigetrauringe.de/ratgeber?p=1&sFilterTags=ringe" title="Zum Ringe-Ratgeber">
												<img src="https://www.ewigetrauringe.de/themes/Frontend/ET_Updatesicher/frontend/images/hochzeitsblog-ratgeber.png"
												alt="hochzeitsratgeber-blog-anschauen">
												<div class="ratgeber-bild-links">&raquo; Ringe<span>ratgeber</span></div>
											</a>
                                        </div>
                                    {/block}
                                </div>
                            {/block}
							
                            {* WIR STELLEN UNS VOR *}
                            {block name='frontend_blog_index_subscribe'}
                                <div class="blog--subscribe has--border is--rounded filter--group block">

                                    {* Ratgeber headline *}
                                    {block name="frontend_blog_index_subscribe_headline"}
                                        <div class="blog--subscribe-headline blog--sidebar-title collapse--header blog-filter--trigger">
                                            <span>Wir stellen uns vor</span>
                                        </div>
                                    {/block}

                                    {* Ratgeber Content *}
                                    {block name="frontend_blog_index_subscribe_content"}
                                        <div class="blog--subscribe-content blog--sidebar-body collapse--content">
											<p class="modal--size-table" style="margin: 0rem 1rem 1rem 1rem;" data-content="" 
												data-modalbox="true" data-targetselector="a" data-width="660" data-height="500" data-mode="ajax"><a href="https://www.ewigetrauringe.de/imagefilm-von-ewigetrauringe" 
												title="Zum Ewigetrauringe Video"> <img title="Video abspielen: Eheringe von Ewigetrauringe" 
												src="https://www.ewigetrauringe.de/themes/Frontend/ET_Updatesicher/frontend/images/ewigetrauringe-video-abspielen.png" alt="Imagefilm - Ewigetrauringe"></a> 
											</p>
                                        </div>
                                    {/block}
                                </div>
                            {/block}

                            {* Blog filter 
                            {block name='frontend_blog_index_filter'}
                                {include file="frontend/blog/filter.tpl"}
                            {/block} *}
                        </div>
                    {/block}

                </div>
            </div>

        {/block}
    </div>
{/block}
