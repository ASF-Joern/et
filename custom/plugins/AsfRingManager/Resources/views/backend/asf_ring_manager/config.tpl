{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-2">
                <div class="panel panel-info text-center">
                    <div class="panel-heading">Artikelfelder aus Afterbuy</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <button type="button" class="btn btn-default saveAfterbuyFields">Aktualisieren</button>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-danger saveAfterbuyFields" name="reset">Zurücksetzen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">Attributspflege Afterbuy</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="ab_propierties_name">Afterbuy Eigenschaft</label>
                            <select class="form-control" id="ab_properties_name">
                                {foreach from=$ab_fields item=field}
                                    <option value="{$field.name}" data-label="{$field.label}" data-filter="{$field.is_filter}">{$field.name} {if $field.label}({$field.label}){/if}</option>
                                {/foreach}
                            </select>
                            <br>
                            <input type="text" class="form-control" placeholder="Bezeichnung" id="ab_properties_label" value="{$label}">
                            <br>
                            <div class="checkbox">
                                <label><input type="checkbox" id="is_filter" value="">Artikel-Eigenschaft?</label>
                            </div>
                            <button type="button" id="ab_name_property" class="btn btn-primary">Hinzufügen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">Attributspflege Shopware</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="sw_propierties_name">Shopware Eigenschaft</label>
                            <select class="form-control" id="sw_properties_name">
                                {foreach from=$sw_articles key=key item=fields}
                                    <option value="s_articles.{$key}">s_articles.{$key}</option>
                                {/foreach}
                                {foreach from=$sw_details key=key item=fields}
                                    <option value="s_articles_details.{$key}">s_articles_details.{$key}</option>
                                {/foreach}
                                {foreach from=$sw_prices key=key item=fields}
                                    <option value="s_articles_prices.{$key}">s_articles_prices.{$key}</option>
                                {/foreach}
                            </select>
                            <br>
                            <input type="text" class="form-control" placeholder="Bezeichnung" id="sw_properties_label" value="{$label}">
                            <br>
                            <button type="button" id="sw_name_property" class="btn btn-primary">Hinzufügen</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">Attributsmapping</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="sel1">Kategorie</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$cats item=cat}
                                    <option value="{$cat.ID}">{$cat.name}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Afterbuy Eigenschaft</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$ab_fields item=field}
                                    <option value="basic.{$field}">{$field}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Shopware Eigenschaft</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$shopware_fields_basic key=key item=fields}
                                    <option value="basic.{$key}">s_articles.{$key}</option>
                                {/foreach}
                                {foreach from=$shopware_fields_details key=key item=fields}
                                    <option value="details.{$key}">s_articles_details.{$key}</option>
                                {/foreach}
                                {foreach from=$shopware_fields_prices key=key item=fields}
                                    <option value="prices.{$key}">s_articles_prices.{$key}</option>
                                {/foreach}
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel panel-danger text-center">
                    <div class="panel-heading">Vorhandene Konfiguration zu Trauringe</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="sel1">Kategorie</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$cats item=cat}
                                    <option value="{$cat.ID}">{$cat.name}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Afterbuy Eigenschaft</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$ab_fields item=field}
                                    <option value="basic.{$field}">{$field}</option>
                                {/foreach}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sel1">Shopware Eigenschaft</label>
                            <select class="form-control" id="sel1">
                                {foreach from=$shopware_fields_basic key=key item=fields}
                                    <option value="basic.{$key}">s_articles.{$key}</option>
                                {/foreach}
                                {foreach from=$shopware_fields_details key=key item=fields}
                                    <option value="details.{$key}">s_articles_details.{$key}</option>
                                {/foreach}
                                {foreach from=$shopware_fields_prices key=key item=fields}
                                    <option value="prices.{$key}">s_articles_prices.{$key}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-4">
                <div class="panel panel-danger text-center" id="statePanel">
                    <div class="panel-heading">Kategorie-Schieber</div>
                    <div class="panel-body">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="subcats">Zwinge Kategorie</label>
                                <select class="form-control subcats_from" name="subcats_from">
                                    {foreach from=$subcategories item=item}
                                        <option>{$item.value}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1"><span class="glyphicon glyphicon-menu-right"></span></div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="subcats">in Kategorie</label>
                                <select class="form-control subcats_to" name="subcats_to">
                                    {foreach from=$subcategories item=item}
                                        <option>{$item.value}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">

                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-info text-center" id="statePanel">
                    <div class="panel-heading">Bearbeitungsstatus</div>
                    <div class="panel-body">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">

                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">Wartet...</div>
                </div>
            </div>
        </div>
    </div>
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