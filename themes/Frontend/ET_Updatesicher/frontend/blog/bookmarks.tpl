{extends file="parent:frontend/blog/bookmarks.tpl"}

{if !$sArticle.sBookmarks}
    {block name='frontend_blog_bookmarks_bookmarks'}
        <div class="blog--bookmarks block">
            <div class="blog--bookmarks-icons">

				{* Eigene Share Buttons einblenden *}
				
					<a href="whatsapp://send?text={$sArticle.title|escape:'url'}"
						title="Empfehle diesen Artikel über Whatsapp"
						class="{if $set_default_style == 1}fa fa-whatsapp fa-2x{else}fa fa-whatsapp icon--whatsapp-custom fa-3x{/if}"
						rel="nofollow"
						target="_blank">
					</a>
				
					<a href="https://plus.google.com/share?url={url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}&amp;title={$sArticle.title|escape:'url'}"  
						title="Empfehle diesen Artikel bei Google+"
						class="{if $set_default_style == 1}fa fa-google-plus-square fa-2x{else}blog--bookmark icon--googleplus2{/if}"
						rel="nofollow"
						target="_blank">
					</a>
					
					<a href="http://pinterest.com/pin/create/button/?url={url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}&amp;title={$sArticle.title|escape:'url'}&description={$sArticle.title|escape:'url'}" 
						title="pinne diesen Artikel bei Pinterest"
						class="{if $set_default_style == 1}fa fa-pinterest fa-2x{else}blog--bookmark icon--pinterest2{/if}"
						rel="nofollow"
						target="_blank">
					</a>
			
                {* Twitter *}
                {block name='frontend_blog_bookmarks_twitter'}
                    <a href="http://twitter.com/home?status={$sArticle.title|escape:'url'}+-+{url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}"
                        title="{"{s name='BookmarkTwitterShare'}{/s}"|escape}"
                        class="blog--bookmark icon--twitter2"
                        rel="nofollow"
                        target="_blank">
                    </a>
                {/block}

                {* Facebook *}
                {block name='frontend_blog_bookmarks_facebook'}
                    <a href="http://www.facebook.com/share.php?v=4&amp;src=bm&amp;u={url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}&amp;t={$sArticle.title|escape:'url'}"
                        title="{"{s name='BookmarkFacebookShare'}{/s}"|escape}"
                        class="blog--bookmark icon--facebook2"
                        rel="nofollow"
                        target="_blank">
                    </a>
                {/block}

                {* Del.icio.us *}
                {block name='frontend_blog_bookmarks_delicious'}
                    <a href="http://del.icio.us/post?url={url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}&amp;title={$sArticle.title|escape:'url'}"
                        title="{"{s name='BookmarkDeliciousShare'}{/s}"|escape}"
                        class="blog--bookmark icon--delicious"
                        rel="nofollow"
                        target="_blank">
                    </a>
                {/block}

                {* Digg *}
                {block name='frontend_blog_bookmarks_digg'}
                    <a href="http://digg.com/submit?phase=2&amp;url={url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}&amp;title={$sArticle.title|escape:'url'}"
                        title="{"{s name='BookmarkDiggitShare'}{/s}"|escape}"
                        class="blog--bookmark icon--digg"
                        rel="nofollow"
                        target="_blank">
                    </a>
                {/block}
            </div>
        </div>
    {/block}
{/if}