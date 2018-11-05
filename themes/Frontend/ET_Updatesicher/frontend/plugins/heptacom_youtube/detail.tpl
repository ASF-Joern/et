{block name='frontend_detail_images_image_slider_item'}
    {if $image.heptacomYoutube}
        {$alt = $image.heptacomYoutube.title|escape}

        <div class="image--box image-slider--item heptacom-youtube">
            {block name='frontend_detail_images_image_element'}
                <span class="image--element" data-alt="{$alt}">
                    {block name='frontend_detail_images_image_media'}
                        {assign var="newVideo" value=$image.heptacomYoutube.html|replace:'width="480" height="270"':'width="640" height="360"'}
                        {$newVideo = $newVideo|replace:'?feature=oembed&rel=0':'?feature=oembed&rel=0&showinfo=0&modestbranding=0'}
                        {$newVideo|replace:'frameborder="0"':''}
                    {/block}
                </span>
            {/block}
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
