<div class="buttons--off-canvas">
    <a class="close--off-canvas" href="#">
        <i class="icon--arrow-left"></i>
        Zurück
    </a>
</div>
<div class="content--description">
    {* Product description *}
    {block name='frontend_detail_description_text'}
        <div class="product--properties desc_box_table">

            <h2 class="article_name">{$sArticle.articleName} Details</h2>
            <table class="product--properties-table">
                <tbody>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Material/Farbe:</td>
                    <td id="table_matleg" class="product--properties-value">{$sArticle.attr7} {$sArticle.attr13}</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Oberfl&auml;che:</td>
                    <td id="table_surface" class="product--properties-value">{$sArticle.attr10}</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Steinbesatz:</td>
                    <td id="table_stone" class="product--properties-value">{$sArticle.attr6}</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Ringbreite:</td>
                    <td class="product--properties-value">{$sArticle.width|replace:".":","}mm</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Ringst&auml;rke:</td>
                    <td class="product--properties-value">{$sArticle.height|replace:".":","}mm (massiv)
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
                    <td class="product--properties-label is--bold">Lieferzeit:</td>
                    <td class="product--properties-value">ca. {$sArticle.shippingtime} Tage
                        <div class="tooltip">[?]
                            <div class="tooltiptext">
			<div class="tooltip-header">
				<h4 class="tooltip-title">Lieferzeit zu lange?</h4>
			</div>
			<div class="tooltip-content">
				Wir können die meisten Trauringe - unabhänigig von der angegebenen Lieferzeit - auch innerhalb weniger Tage produzieren.
				<hr>
				Dazu rufen Sie uns einfach an oder schreiben uns:<br>
				<strong><i class="icon--phone"></i></strong> 06404 - 802 90 20<br>
				<strong><i class="icon--mail"></i></strong> info@ewigetrauringe.de
			</div>
		</div>
                        </div>
                    </td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Gr&ouml;&szlig;en:</td>
                    <td class="product--properties-value">{$sArticle.attr15} - {$sArticle.attr16}mm</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Herkunftsland:</td>
                    <td class="product--properties-value">Deutschland</td>
                </tr>
                <tr class="product--properties-row">
                    <td class="product--properties-label is--bold">Herstellung:</td>
                    <td class="product--properties-value">Hauseigene Produktion</td>
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
        <div class="desc_box_vorteile">
            <h3>Unsere Vorteile</h3>
            <ul class="vorteile-tabelle">
                <li>Kostenlose Gravur</li>
                <li>Kostenloses Etui</li>
                <li>Kostenloser Versand</li>
                <li>Allergiefrei</li>
                <li><a title="Mehr erfahren zur lebenslangen Garantie" href="/trauringe-service#lebenslange-garantie" target="_blank">Lebenslange Garantie</a></li>
                <li>Made in Germany</li>
            </ul>
        </div>

        <div class="desc_box_vorteile">
            <h4>Garantiezertifikat</h4>
            <div class="zertifikat-box" style="height: 180px;">
                <table class="mf zertifikat-table" style="width: 30%; height: 185px; float: left;">
                    <tbody>
                    <tr>

                        <td class="left" style="width:40%;"><img class="logo" style="width: 80px; margin-left:9px;" title="Logo zum Zertifikat" src="https://www.ewigetrauringe.de/media/image/c5/a3/b0/ewigetrauringe-2018-logo2.png" alt="garantie-zertifikat-logo" /><br />
                            <img class="pdimg" style="width: 100%;" src="{$sArticle.image.thumbnails[0].source}" alt="Trauringe-Bild zum Zertifikat" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="mf zertifikat-table" style="width: 70%; float: left; line-height: 16px;">
                    <tbody>
                    <tr>
                        <td style="text-align: center; height: 0.2cm; width:60%;" colspan="2"><strong>Garantiezertifikat</strong></td>
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
                        <td class="white" style="background: white; float: left; border-right: 1px solid #efefef; margin-right: 5px; padding-right: 5px;"><span>Steinart: <span id="zertStone">{if $sArticle.attr6 === "Zirkonia"}Zirkonia{else}Diamant{/if}</span></span></td>
                        <td class="white" style="background: white; float: left;"><span>Schliff: <span id="zertRefinement">{$sArticle.refinement}</span></span></td>
                    </tr>
                    <tr class="row-right">
                        <td class="white" style="background: white;"><span>Farbe/Reinheit: <span id="zertQuality">{if $sArticle.attr6 === "Zirkonia"}-{else}G/Si{/if}</span></span></td>
                    </tr>
                    <tr class="row-right">
                        <td class="white" colspan="2" style="background: white;"><span>Gesamtgewicht: <span id="zertWeight">{if $sArticle.attr6 === "Zirkonia"}-{else}{$sArticle.weight|replace:".":","}ct.{/if}</span> </span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="clear: both;"></div>
    {/block}
</div>