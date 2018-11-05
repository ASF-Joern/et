<div class="set_profile--container">
    {* Big image-box *}
    <div class="img_left">
        {assign var="path" value="media/image/profil{$profileNr}.jpg"}
        <img src="{media path=$path}" class="set_profile_big" width="240px">
    </div>

    <div class="choose_profile">
        <div class="wleft set_profile_big--box-right">
            {foreach from=$profiles item=profile key=index}
                {assign var="profileText" value=":"|explode:$profile}
                <div class="profil_text {$profileText.0|lower} {if $profileNr == ($index+1)}is--active{else}is--hidden{/if}"><strong>{$profileText.0}:</strong>{$profileText.1}<br><br></div>
            {/foreach}
        </div>
        <div style="clear:both;"></div>
        <hr>
        <h4>Ihre aktuelle Auswahl</h4>
        <div class="wleft set_profile_set--box">
            {foreach from=$profiles item=profile key=index}
                {assign var="profileText" value=":"|explode:$profile}
                {assign var="path" value="media/image/profil{($index+1)}.jpg"}
                {assign var="iconPath" value="media/image/profil{($index+1)}-icon.jpg"}
                <div class="profil_container" >
                    <a title="Profil wählen" data-profile="{{$profileText.0|lower}}" class="{if $profileNr == ($index+1)}is--active{/if}" data-original="{media path=$path}" href="#" style="background-image: url({media path=$iconPath});" >{$profileText.0}</a>
                </div>
            {/foreach}
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.js--modal .content').css("padding", "0");
        $('.set_profile_set--box a').mouseenter(function() {

            $('.set_profile_set--box a').each(function(i,e) {

                if($(this).hasClass("is--active")) {
                    $(this).removeClass("is--active");
                }

            });

            var src = $(this).data("original");

            var profile = $(this).data("profile");

            $('.profil_text').each(function(i,e) {

                if($(this).hasClass("is--active")) {

                    $(this).removeClass("is--active");
                    $(this).addClass("is--hidden");

                }
            });

            $('.profil_text.'+profile).removeClass("is--hidden");
            $('.profil_text.'+profile).addClass("is--active");

            $('.set_profile_big').attr("src", src);

        });

        $('.set_profile_set--box a').click(function() {

            $('.call_profil_modalbox').removeClass("profil{$profileNr}");

            $('.article_profil').each(function(i,e) {

                if($(this).hasClass("is--active")) {
                    $(this).removeClass("is--active");
                    $(this).addClass("is--hidden");
                }

            });

            var profile = $(this).data("profile");
            $('.call_profil_modalbox').addClass("profil" + profile.substr(6));
            $('.call_profil_modalbox').attr("href", "{url module=widgets controller=AsfProfiles}" + "?profile=" + profile.substr(6) + "&articleID={$articleID}");
            $('.article_profil.profil{$profileNr}').removeClass("is--active");
            $('.article_profil.'+profile).removeClass("is--hidden");
            $('.article_profil.'+profile).addClass("is--active");

            $('.selected_profil').each(function(i,e) {
                if($(this).parent().next().text().toLowerCase().trim() === profile) {
                    $(this).prop("checked", true);
                }
            });


            $.modal.close();
            $.publish('plugin/profileChanger/changed', profile);

        });
    });
</script>