{extends file="parent:backend/_base/layout.tpl"}

{block name="content/main"}
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Was macht die Schnittstelle? <span class="glyphicon glyphicon-menu-right"></span></a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li>Bestellungen aus dem Shop <b>an Afterbuy</b> übertragen.</li>
                        <li>Artikel aus Afterbuy <b>in Shopware</b> importieren.</li>
                        <li>Artikelveränderungen die im Shop gemacht werden <b>an Afterbuy</b> übertragen.</li>
                        <li>Artikelveränderungen die in Afterbuy gemacht werden <b>an Shopware</b> übertragen.</li>
                        <li>Attributsveränderung an Afterbuy Artikeln vornehmen: hinzufügen, aktualisieren oder löschen.</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Erklärung zur Konfiguration <span class="glyphicon glyphicon-menu-right"></span></a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li>Für den Fall einer Neuinstallation oder das weitere Produktfelder in Afterbuy hinzukommen, können alle relevanten Felder aktualisiert werden.</li>
                        <li>Im Panel <b>Attributspflege Afterbuy</b> können die Bezeichnungen der Afterbuy Felder umbenannt werden. Bsp: Anr in Artikelnummer</li>
                        <li>Im Panel <b>Attributspflege Shopware</b> können alle Datenbankfelder des Artikels, seiner Details und Attribute sowie der Eigenschaften umbenannt werden. Bsp: s_articles_details.ordernumber in Artikelnummer</li>
                        <li>Im Panel <b>Attributsmapping für Artikel</b> können in belieber Wahl einzelne oder mehrere Afterbuy Felder einem oder mehreren Shopware Artikelfeldern zugewiesen werden und dessen Reihenfolge je Shop Kategorie.
                            <ul>
                                <li>
                                    Ausserdem ermöglicht es für Felder die mehrere Daten enthalten bspw. mehrere Bilder, diese mit einem Trenner zu versehen oder mit einem Regulären Ausdruck.
                                </li>
                                <li>
                                    <b>Hinweis: </b> Diese Konfigurationen können beliebig exportiert und importiert werden.
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Der Cronjob und wann passiert was? <span class="glyphicon glyphicon-menu-right"></span></a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                        <li><b>Bestellungen nach Afterbuy</b> werden im direkten Abschluß im Shop an Afterbuy übertragen in Echtzeit.</li>
                        <li><b>Artikel nach Afterbuy</b> im moment werden die Artikel nur über den Preismanager im Shop geändert und nach einer Neukalkulation werden nur die geänderten Artikel in Afterbuy geupdatet.</li>
                        <li><b>Artikel nach Shopware</b> hier schaut der Cronjob im Interval, welcher in der Pluginkonfiguration festgelegt ist, bei Afterbuy nach, ob sich Artikel geändert haben.</li>
                    </ul>
                    <h3>Weitere Funktionen coming soon...</h3>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Welche Funktionsaufrufe gibt es? <span class="glyphicon glyphicon-menu-right"></span></a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <h3>Coming soon</h3>
                </div>
            </div>
        </div>
    </div>
{/block}

{block name="content/javascript" append}
<script>
    $('#accordion a').click(function() {
        $(this).children(":first").toggleClass("glyphicon-menu-right");
        $(this).children(":first").toggleClass("glyphicon-menu-down");
    });
</script>
{/block}