{extends file='parent:frontend/blog/detail.tpl'}

		{* Main content including right sidebar *}
		{block name='frontend_index_content'}
		  <div class="blog--content block-group">
			  {* Blog Sidebar *}
			  {block name='frontend_blog_listing_sidebar'}
				{include file='frontend/blog/listing_sidebar.tpl'}
				{$smarty.block.parent}
			  {/block}
		  </div>
		{/block}

        {* Comments ausblenden *}
        {block name='frontend_blog_detail_comments_count'}

        {/block}

        {* Comments ausblenden *}
        {block name='frontend_blog_detail_comments_list'}

        {/block}