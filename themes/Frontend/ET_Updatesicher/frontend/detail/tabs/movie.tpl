{namespace name="frontend/detail/tabs/movie"}

<div class="buttons--off-canvas">
    <a class="close--off-canvas" href="#">
        <i class="icon--arrow-left"></i>
        Zurück
    </a>
</div>
<div class="content--description">
    {* Product description *}
    {block name='frontend_detail_description_text'}
        <div class="product--movie" itemprop="movie">
            <video controls poster="{s name='DetailTabsMovieThumbnail'}https://aa4a36e6c126bdc224b9-69081f7c36d6a19404413df830d8d367.ssl.cf3.rackcdn.com/578ce7bed95fe10007aeb3c4/covers/480_at_second_10.0.png{/s}" style="width:100%">
                <source src="{s name='DetailTabsMovieLink'}https://aa4a36e6c126bdc224b9-69081f7c36d6a19404413df830d8d367.ssl.cf3.rackcdn.com/578ce7bed95fe10007aeb3c4/720.mp4{/s}" type="video/mp4">
            </video>
        </div>
    {/block}
</div>