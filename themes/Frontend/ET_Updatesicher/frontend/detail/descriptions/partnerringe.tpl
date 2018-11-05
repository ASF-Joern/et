<div class="buttons--off-canvas">
	<a class="close--off-canvas" href="#">
		<i class="icon--arrow-left"></i>
		Zurück
	</a>
</div>
<div class="product--properties desc_box_table">

	<h2>{$sArticle.articleName} Details</h2>
	<table class="product--properties-table">
	<tbody>
		<tr class="product--properties-row">
		<td class="product--properties-label is--bold">Material/Farbe:</td>
		<td id="table_matleg" class="product--properties-value">{$sArticle.attr13}</td>
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
		<td class="product--properties-value">{$sArticle.height|replace:".":","}mm
	</td>
	</tr>
		<tr class="product--properties-row">
		<td class="product--properties-label is--bold">Lieferzeit:</td>
		<td class="product--properties-value">ca. {$sArticle.shippingtime} Tage
	</td>
		</tr>
		<tr class="product--properties-row">
			<td class="product--properties-label is--bold">Gr&ouml;&szlig;en:</td>
			<td class="product--properties-value">48 - 70mm</td>
		</tr>
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
	</ul>
</div>

<div style="clear: both;">&nbsp;</div>