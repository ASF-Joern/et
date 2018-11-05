{extends file="parent:backend/_base/layout.tpl"}
{block name="content/main"}
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-2">
                <div class="panel panel-info text-center">
                    <div class="panel-heading">Alle Artikel importieren</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary importAllArticles">Importieren</button>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-success importSelectedRing" name="reset">Markierten Importieren</button>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info text-center" id="statePanel">
                    <div class="panel-heading">Bearbeitungsstatus</div>
                    <div class="panel-body">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"
                                 aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                        </div>
                    </div>
                    <div class="panel-footer">Wartet...</div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-info text-center" id="logPanel">
                    <div class="panel-heading">Log</div>
                    <div class="panel-body"></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-info text-left" id="articlePanel">
                    <div class="panel-heading">Zu importierende Artikel</div>
                    <div class="panel-body">
                        <div class="col-lg-12" id="articleQuantity" data-value="{$articleQuantity}">
                            {foreach from=$articles key=name item=article}
                                <div class="col-lg-4">
                                    <button type="button" id="{$name}" class=" ring btn btn-danger" data-value="{count($article)}" data-ring="{$name}">
                                        {$name} <span class="badge badge-light">{count($article)}</span>
                                    </button>
                                </div>
                            {/foreach}
                        </div>
                    </div>
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

        function batchAjax($url, $data) {

            var info = '';

            $.ajax({
                url: $url,
                data: $data,
                method: "get",
                dataType: "json",
                beforeSend: function(xhr) {

                    var display = $('#statePanel .progress-bar').text();

                    if(!display) {
                        $('#statePanel .progress-bar').removeClass("progress-bar-success");
                        $('#statePanel .progress-bar').addClass("progress-bar-danger");
                        $('#statePanel .progress-bar').css("width","100%");
                        $('#statePanel .progress-bar').text("0/" + $('#' + $data.ringName).data("value"));
                    }

                    $('#statePanel .panel-footer').text(String($('button.ring.is--active').text()).split(" ")[0].trim() + " wird importiert");
                },
                success: function(data) {

                    if(data !== 1) {

                        var founded = parseInt(data.count);

                        var result = (parseInt($('#' + data.ringName).data("value")) / founded);
                        if(result === 2) {
                            $('#statePanel .progress-bar').removeClass("progress-bar-danger");
                            $('#statePanel .progress-bar').addClass("progress-bar-warning");
                        }
                        if(result === 1) {
                            $('#statePanel .progress-bar').text("");
                            $('#statePanel .panel-footer').text("Wartet...");
                            $('#statePanel .progress-bar').css("width","0%");
                            return;
                            var $data = { productID: data.productID, ringName: String($('#' + data.ringName).parent().next().children(':first-child').text()).split(" ")[0].trim() };
                        } else {
                            var $data = { productID: data.productID, ringName: data.ringName };

                        }

                        var errorLog = data.errorLog;
                        console.log(data.errorLog);
                        if(errorLog.length >= 1) {

                            for(var elem in errorLog) {

                                if($('#logPanel .panel-body').text() === '') {
                                    console.log(elem);
                                    $('#logPanel .panel-body').text(elem + "<br>");
                                } else {
                                    $('#logPanel .panel-body').text("<br>" + elem);
                                }

                            }
                        }

                        $('#statePanel .progress-bar').text(founded + "/" + $('#' + data.ringName).data("value"));
                        batchAjax("{url controller=AsfAfterbuy action=addArticles}", $data);
                    } else {
                        $('#statePanel .progress-bar').removeClass("progress-bar-warning");
                        $('#statePanel .progress-bar').addClass("progress-bar-success");
                        $('#statePanel .progress-bar').text("11771/11771");
                        $('#statePanel .progress-bar').css("width","100%");
                        $('#statePanel .panel-footer').text("Erfolgreich!");
                    }
                    info = data;
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
                        if($('#statePanel .progress-bar').text() === "11771/11771") {
                            setTimeout(function() {
                                $('#statePanel .progress-bar').text("");
                                $('#statePanel .panel-footer').text("Wartet...");
                                $('#statePanel .progress-bar').css("width","0%");
                            }, 1000);
                        }
                    }
                }, 1000);

            });

        };

        $(document).ready(function() {

            $('.importAllArticles').click(function() {
                batchAjax("{url controller=AsfAfterbuy action=addArticles}", { });
            });

            $('.importSelectedRing').click(function() {
                batchAjax("{url controller=AsfAfterbuy action=addArticles}", { ringName: String($('button.ring.is--active').data("ring")).trim() });
            });

            $('button.ring').click(function() {

                $('button.ring.is--active').removeClass("is--active");
                $('button.ring.btn-success').addClass("btn-danger");
                $('button.ring.btn-success').removeClass("btn-success");

                $(this).addClass("is--active");
                $(this).removeClass("btn-danger");
                $(this).addClass("btn-success");

            });

        });
    </script>


{/block}