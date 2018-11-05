{assign var="stone" value=" x "|explode:$sArticle.attr6}
<div class="buttons--off-canvas">
    <a class="close--off-canvas" href="#">
        <i class="icon--arrow-left"></i>
        Zurück
    </a>
</div>
<div class="product--properties desc_box_table">
    <h2 class="articleName">{$sArticle.articleName} Details</h2>
    <table class="product--properties-table">
        <tbody>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Material:</td>
            <td id="table_mat" class="product--properties-value">{$sArticle.attr13}</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Legierung:</td>
            <td id="table_leg" class="product--properties-value">{$sArticle.attr7}</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Breite:</td>
            <td id="table_width" class="product--properties-value">{$sArticle.width|replace:".":","}mm
                <div class="tooltip">[?]
                    <div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Breite</h4>
                        </div>
                        <div class="tooltip-content"> <img src="themes/Frontend/ET_Updatesicher/frontend/images/tooltips/verlobungsring-max-breite.jpg" alt="max-breite-verlobungsring">
                            Der Wert bezieht sich auf die breiteste Stelle des Memoire Rings.
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">St&auml;rke:</td>
            <td class="product--properties-value" id="table_height">{$sArticle.height|replace:".":","}mm (massiv)
                <div class="tooltip">[?]
                    <div class="tooltiptext">
                        <div class="tooltip-header">
                            <h4 class="tooltip-title">Ringstärke</h4>
                        </div>
                        <div class="tooltip-content">
                            <img src="themes/Frontend/ET_Updatesicher/frontend/images/tooltips/massive-ringe.jpg" alt="massive-trauringe-vollkoerper">
                            Unsere Ringe werden aus Vollmaterial hergestellt und sind somit massiv.
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Oberfl&auml;che:</td>
            <td id="table_surface" class="product--properties-value">{$sArticle.attr10}</td>
        </tr>
        {if !empty($sArticle.description_long)}
            <tr class="product--properties-row">
                <td class="product--properties-label is--bold">Beschreibung:</td>
                <td class="product--properties-value">{$sArticle.description_long|replace:"“":'"'}</td>
            </tr>
        {/if}
        </tbody>
    </table>
</div>

<div class="product--properties desc_box_table">
    <h3>Steinbesatz</h3>
    <table class="product--properties-table">
        <tbody>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Gewicht:</td>
            <td id="table_weight" class="product--properties-value">{$sArticle.weight|replace:".":","} ct.</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Ma&szlig;e:</td>
            <td id="table_stone" class="product--properties-value">{$sArticle.attr6}</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Anzahl:</td>
            <td id="table_quantity" class="product--properties-value">{$sArticle.attr11}</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Steinart/Form:</td>
            <td class="product--properties-value">Diamant / Brillant</td>
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Farbe:</td>
            {if $sArticle.attr7 === "925er"}
            <td id="table_color" class="product--properties-value">weiß
                <div class="tooltip">[?]
                    <div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4>
                        </div>
                        <div class="tooltip-content">
                            Alle unsere verwendeten Schmucksteine sind in feinem weiß.
                        </div>
                    </div>
                </div>
            </td>
            {else}
                <td id="table_color" class="product--properties-value">G
                    <div class="tooltip">[?]
                        <div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Farbe</h4>
                            </div>
                            <div class="tooltip-content">
                                Alle unsere verwendeten Edelsteine sind in feinem weiß.
                            </div>
                        </div>
                    </div>
                </td>
            {/if}
        </tr>
        <tr class="product--properties-row">
            <td class="product--properties-label is--bold">Reinheit:</td>
            {if $sArticle.attr7 === "925er"}
                <td id="table_clarity" class="product--properties-value">Zirkonia
                    <div class="tooltip">[?]
                        <div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Zirkonia</h4>
                            </div>
                            <div class="tooltip-content">
                                Zirkoniasteine sind künstlich hergestellte Schmucksteine. Sie sind kaum von echten Diamanten zu unterscheiden und strahlen ebenso wunderschön.
                            </div>
                        </div>
                    </div>
                </td>
            {else}
                <td id="table_clarity" class="product--properties-value">SI
                    <div class="tooltip">[?]
                        <div class="tooltiptext"> <div class="tooltip-header"> <h4 class="tooltip-title">Reinheit</h4>
                            </div>
                            <div class="tooltip-content">
                                Die Reinheit bezieht sich auf die Klarheit des Edelsteins. Dabei redet man von SI (kleine Einschlüsse), VS (sehr kleine Einschlüsse)
                                und IF (lupenrein), welches die hochwertigste Reinheit ist.
                            </div>
                        </div>
                    </div>
                </td>
            {/if}
        </tr>
        </tbody>
    </table>
</div>

<div class="desc_box_vorteile">
    <h3>Memoireringe Anfertigung</h3>
    <p>Bitte beachten Sie, dass alle Memoireringe individuell f&uuml;r Sie angefertigt werden.</p>
</div>

<div class="desc_box_vorteile">
    <h4>Garantiezertifikat</h4>
    <div class="zertifikat-box" style="height: 180px;">
        <table class="mf zertifikat-table" style="width: 30%; height: 185px; float: left;">
            <tbody>
            <tr>

                <td class="left" style="width:40%;"><img class="logo" style="width: 80px;  margin-left:9px;" title="Logo zum Zertifikat" src="https://www.ewigetrauringe.de/media/image/c5/a3/b0/ewigetrauringe-2018-logo2.png" alt="garantie-zertifikat-logo" /><br />
                    <img class="pdimg" style="width: 100%;" src="{$sArticle.image.thumbnails[0].source}" alt="Trauringe-Bild zum Zertifikat" />
                </td>
            </tr>
            </tbody>
        </table>
        <table class="mf zertifikat-table" style="width: 70%; float: left; line-height: 16px;">
            <tbody>
            <tr>
                <td style="text-align: center; height: 0.2cm; width:60%;"><strong>Garantiezertifikat</strong></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white; float: left; border-right: 1px solid #efefef; margin-right: 5px; padding-right: 5px;"><span>Kaufdatum: </span>{$smarty.now|date_format:"%d.%m.%y"}</td>
                <td class="white" style="background: white; float: left;"><span>Preis: <span id="zertPrice">{$sArticle.price|currency}</span></span></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white;"><span>Kunde: </span>Max Mustermann</td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white; float: left; border-right: 1px solid #efefef; margin-right: 5px; padding-right: 5px;"><span>Kd-Nr.:</span> 000000</td>
                <td class="white" style="background: white; float: left;"><span>Modell: <span id="zertModel">{$sArticle.attr12}</span></span></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white;"><span>Material: <span id="zertMaterial">{$sArticle.attr7} {$sArticle.attr13}</span></span></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white; float: left; border-right: 1px solid #efefef; margin-right: 5px; padding-right: 5px;"><span>Steinart: <span id="zertStone">{if $sArticle.attr7 === "925er"}Zirkonia{else}Diamant{/if}</span></span></td>
                <td class="white" style="background: white; float: left;"><span>Schliff: <span id="zertRefinement">{if $sArticle.attr7 === "925er"}-{else}Brillant{/if}</span></span></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white;"><span>Farbe/Reinheit: <span id="zertQuality">G/Si</span></span></td>
            </tr>
            <tr class="row-right">
                <td class="white" style="background: white;"><span>Gesamtgewicht: <span id="zertWeight">{$ct}ct.</span> </span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div style="clear: both;"></div>