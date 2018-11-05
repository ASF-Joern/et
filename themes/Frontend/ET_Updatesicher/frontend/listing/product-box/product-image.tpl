{extends file='parent:frontend/listing/product-box/product-image.tpl'}

{block name='frontend_listing_box_article_image_picture_element'}
    <img srcset="{$sArticle.image.thumbnails[1].sourceSet}" src="{$sArticle.image.thumbnails[1].sourceSet}"
             alt="{$desc}"
             title="{$desc|truncate:160}" />
    <span title="{s name="articleImagePreview"}Artikelbild Vorschau{/s} {$sArticle.articleName}" class="product-image--zoom is--top-right" data-modalbox="true" data-content="<div class='product--image'><img src='{$sArticle.image.thumbnails[0].source}' srcset='{$sArticle.image.thumbnails[0].sourceSet}'></div>"><i class="icon--search"></i></span>

{/block}
