{extends file="parent:frontend/blog/images.tpl"}

{* Main Image *}
{block name='frontend_blog_images_main_image'}

    {$alt = $sArticle.title|escape}

    {if $sArticle.preview.description}
        {$alt = $sArticle.preview.description|escape}
    {/if}

    <div class="blog--detail-images block">
        <a href="{$sArticle.preview.source}"
           data-lightbox="true"
           title="{$alt}"
           class="link--blog-image">

            <img srcset="{$sArticle.preview.thumbnails[1].sourceSet}"
                 src="{$sArticle.preview.thumbnails[1].source}"
                 class="blog--image panel has--border is--rounded"
                 alt="{$alt}"
                 title="{$alt|truncate:160}"
                 itemprop="image" />
        </a>
        <div class="bildunterschrift">
			&copy {if !empty($sArticle.media.0.attributes.media->get('copyright'))}{$sArticle.media.0.attributes.media->get('copyright')}{else}Eigenes Bild{/if}
		</div>
    </div>
{/block}