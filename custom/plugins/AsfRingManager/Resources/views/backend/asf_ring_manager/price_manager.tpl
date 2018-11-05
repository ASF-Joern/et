{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
<form action="{url controller=AsfAfterbuy action=priceManagerSave}" method="post">
    {assign var="globalNames" value=','|explode:"Gold,Palladium,Platin,Diamant,je Fassung,Zirkonia,333er Gold,585er Gold,750er Gold,585er Palladium,950er Palladium,600er Platin,950er Platin,Gelbweiß,Rotweiß,Tricolor,Gelb,Rot,Rosé,Weiß,Palladium,Platin,Gold,Palladium,Platin,Steinbesatz"}
    {assign var="globalHeadlines" value=','|explode:"Börsenpreise,Steinbesatz,Bearbeitungsgebühren,Aufschläge,Kalkulationsfaktoren"}
    {assign var="alloyHeadlines" value=','|explode:"Gold,Palladium,Platin"}
    <div class="row price_manager">
        <div class="col-lg-12">
            <div class="col-lg-8">
                <div class="panel panel-info">
                    <div class="panel-heading">Profile</div>
                    <div class="panel-body">

                        <div class="col-lg-6">
                            <div class="form-group">
                                <fieldset>
                                    <legend>Gold</legend>
                                    <div class="input-group">
                                        <ul class="list-inline">
                                            <li class="list-inline-item" style="font-size:14px; margin-right:4px;"><b>Legierung/Farbe</b></li>
                                            {foreach from=$profiles item=profile}
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>Profil{$profile.number}</b></li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    {foreach from=$table key=key item=entries}
                                        <div class="input-group">
                                            <ul class="list-inline">
                                                <li class="list-inline-item" style="min-width: 131px">{$entries.alloy} {$entries.material}</li>
                                                {foreach from=$entries key=subkey item=entry}
                                                    {if $entry@iteration > 3 && $entry@iteration < 9}
                                                        <input type="text" name="PriceManager[entries][{$entries.alloy}_{$entries.material}_{$subkey}]" value="{$entry|replace:".":","}" style="width:60px"/>
                                                    {/if}
                                                {/foreach}
                                            </ul>
                                        </div>
                                        {if $entries@iteration == 12}
                                            {break}
                                        {/if}
                                    {/foreach}
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <fieldset>
                                    <legend>Palladium</legend>
                                    <div class="input-group">
                                        <ul class="list-inline">
                                            <li class="list-inline-item" style="font-size:14px; margin-right:4px;"><b>Legierung/Farbe</b></li>
                                            {foreach from=$profiles item=profile}
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>Profil{$profile.number}</b></li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    {foreach from=$table key=key item=entries}
                                        {if $entries@iteration > 12 && $entries@iteration <= 14}
                                            <div class="input-group">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item" style="min-width: 131px">{$entries.alloy} {$entries.material}</li>
                                                    {foreach from=$entries key=subkey item=entry}
                                                        {if $entry@iteration > 3 && $entry@iteration < 9}
                                                            <input type="text" name="PriceManager[entries][{$entries.alloy}_{$entries.material}_{$subkey}]" value="{$entry|replace:".":","}" style="width:60px"/>
                                                        {/if}
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <fieldset>
                                    <legend>Platin</legend>
                                    <div class="input-group">
                                        <ul class="list-inline">
                                            <li class="list-inline-item" style="font-size:14px; margin-right:4px;"><b>Legierung/Farbe</b></li>
                                            {foreach from=$profiles item=profile}
                                                <li class="list-inline-item" style="font-size:14px; width:60px;"><b>Profil{$profile.number}</b></li>
                                            {/foreach}
                                        </ul>
                                    </div>
                                    {foreach from=$table key=key item=entries}
                                        {if $entries@iteration > 14 && $entries@iteration <= 16}
                                            <div class="input-group">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item" style="min-width: 131px">{$entries.alloy} {$entries.material}</li>
                                                    {foreach from=$entries key=subkey item=entry}
                                                        {if $entry@iteration > 3 && $entry@iteration < 9}
                                                            <input type="text" name="PriceManager[entries][{$entries.alloy}_{$entries.material}_{$subkey}]" value="{$entry|replace:".":","}" style="width:60px"/>
                                                        {/if}
                                                    {/foreach}
                                                </ul>
                                            </div>
                                        {/if}
                                    {/foreach}
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <button type="submit" name="PriceManager[price_manager_action]" value="saveAndUpdate" class="btn btn-primary">Speichern & Aktualisieren</button>
                                <button type="submit" name="PriceManager[price_manager_action]" value="synch" class="btn btn-primary">Synchronisieren</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-info text-center">
                    <div class="panel-heading">Globale Einstellung</div>
                    <div class="panel-body">
                        {debug}
                        {assign var="counter" value=0}
                        {foreach from=$globals key=key item=global name="globals"}
                            {if $global@last || $global@iteration == 27}
                                {if $global@last || $global@iteration == 27}
                                    {if $global@iteration == 27}
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Ring Anzahl in {$catName}</label>
                                                <select class="form-control" name="PriceManager[globals][ring_quantity]">
                                                    <option {if $global.value == 1}selected{/if}>1</option>
                                                    <option {if $global.value == 2}selected{/if}>2</option>
                                                </select>
                                            </div>
                                            {else}
                                            <input type="hidden" name="PriceManager[cat]" value="{$global.value}">
                                            <div class="form-group">
                                                <button type="submit" name="PriceManager[price_manager_action]" value="saveAndUpdate" class="btn btn-primary">Speichern & Aktualisieren</button>
                                            </div>
                                        </div>
                                    {/if}
                                {/if}
                            {else}
                                {if $global@iteration == 1 || $global@iteration == 4 || $global@iteration == 7 || $global@iteration == 14 || $global@iteration == 23}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>{$globalHeadlines.$counter}</legend>
                                                {$counter = $counter + 1}
                                {/if}
                                <div class="input-group">
                                    <span class="input-group-addon" style="min-width:126px;float:left;">{$globalNames.$key}</span>
                                    <input type="text" value="{$global.value|replace:".":","}" name="PriceManager[globals][{$global.name}]" style="max-width:60px">
                                </div>
                                {if $global@iteration == 3 || $global@iteration == 6 || $global@iteration == 13 || $global@iteration == 22}
                                            </fieldset>
                                        </div>
                                    </div>
                                {/if}
                            {/if}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
{/block}

{block name="content/javascript" append}
    <script>
        function simpleAjax($url, $data) {

            var info = '';

            $.ajax({
                url: $url,
                data: $data,
                method: "get",
                async: false,
                beforeSend: function(xhr) {
                    $('#statePanel .progress-bar').css("width","1%");
                    $('#statePanel .panel-footer').text("in Bearbeitung");
                },
                success: function(data) {

                    info = data;
                    $('#statePanel .progress-bar').css("width","100%");
                    $('#statePanel .panel-footer').text("Erfolgreich!");

                }
            }).always(function() {
                setTimeout(function() {

                    if(info === "reset") {
                        $('#statePanel .progress-bar').removeClass("progress-bar-success");
                        $('#statePanel .progress-bar').addClass("progress-bar-info");
                        $('#statePanel .progress-bar').css("width","100%");
                        $('#statePanel .panel-footer').text("Seite lädt neu");
                        setTimeout(function() {
                            location.reload(true);
                        }, 1000);
                    } else {
                        $('#statePanel .progress-bar').css("width","0%");
                        $('#statePanel .panel-footer').text("Wartet...");
                    }

                }, 1000);

            });

        };

        $(document).ready(function() {

            // Set Afterbuy fields
            $('.saveAfterbuyFields').click(function() {

                var $data = { };
                if($(this).attr("name") === "reset") {
                    $data = { reset : true };
                }
                simpleAjax("{url controller=AsfAfterbuy action=setAfterbuyFields}", $data);

            });

            // Rename afterbuy field
            $('#ab_name_property').click(function() {

                var option = $('#ab_properties_name option:selected');
                var label = $('#ab_properties_label').val();

                var value = option.val();
                var filter = $('#is_filter').attr("checked") ? 'no' : 'yes';

                option.attr("data-label", label);
                option.attr("data-filter", filter);
                var $data = { type: "afterbuy", name: value, label: label, is_filter: filter };

                simpleAjax("{url controller=AsfAfterbuy action=saveProperyMapping}", $data);

            });

            // Set the label into the input field
            $('#ab_properties_name').change(function() {
                $('#ab_properties_label').val($('#ab_properties_name option:selected').attr("data-label"));
                if($('#ab_properties_name option:selected').attr("data-filter") === "yes") {

                    $('#is_filter').prop("checked", true);
                } else {
                    $('#is_filter').prop("checked", false);
                }
            });

            // Rename shopware field
            $('#sw_name_property').click(function() {

                var option = $('#sw_properties_name option:selected');
                var label = $('#sw_properties_label').val();

                var value = option.val();

                option.attr("data-label", label);
                var $data = { type: "shopware", name: value, label: label }

                simpleAjax("{url controller=AsfAfterbuy action=saveProperyMapping}", $data);

            });

            // Set the label into the input field
            $('#sw_properties_name').change(function() {
                $('#sw_properties_label').val($('#sw_properties_name option:selected').attr("data-label"));
            });

        });
    </script>


{/block}