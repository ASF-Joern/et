{extends file='parent:frontend/blog/box.tpl'}

    {* Comments ausblenden *}
    {block name='frontend_blog_col_meta_data_comments'}

    {/block}

    {block name='frontend_blog_col_description_short'}
        <div class="blog--box-description-short">
            {$sArticle.description|truncate:300:"..."}
        </div>
    {/block}
	
                {* Article pictures *}
                {block name='frontend_blog_col_article_picture'}
                    {if $sArticle.media}
                        <div class="blog--box-picture">
                            <a href="{url controller=blog action=detail sCategory=$sArticle.categoryId blogArticle=$sArticle.id}"
                               class="blog--picture-main"
                               title="{$sArticle.title|escape}">
                                {if isset($sArticle.media.thumbnails)}
                                    <img srcset="{$sArticle.media.thumbnails[1].sourceSet}"
                                         alt="{$sArticle.title|escape}"
                                         title="{$sArticle.title|escape|truncate:160}" />
                                {else}
                                    <img src="{link file='frontend/_public/src/img/no-picture.jpg'}"
                                         alt="{$sArticle.title|escape}"
                                         title="{$sArticle.title|escape|truncate:160}" />
                                {/if}
                            </a>
                        </div>
                    {/if}
                {/block}