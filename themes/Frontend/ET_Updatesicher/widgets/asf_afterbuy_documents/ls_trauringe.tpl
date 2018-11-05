<html>
	<head>
		<title>Lieferschein - Ewigetrauringe - Trauringe</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	</head>
	<body>
		{include file='widgets/asf_afterbuy_documents/style.tpl'}
		<div id="dina5">
			<div id="header">
				<div class="row_left">
					<img style="height: 100px;" src="http://www.ewigetrauringe.de/dev/media/image/c5/a3/b0/ewigetrauringe-2018-logo2.png"/>
				</div>
				<div class="row_right">
					<table>
						<tr>
							<td>Druck</td>
							<td>{$printdate}</td>
						</tr>
						<tr>
							<td style="font-weight: bolder;">Bestellung</td>
							<td style="font-weight: bolder; color: red;">{$buyDate}</td>
						</tr>
						<tr>
							<td>Feedback am</td>
							<td>{$feedback}</td>
						</tr>
					</table>
				</div>
			</div>
			
			<div id="content">	
				<div class="row_left">
					<h2>Kundendaten</h2>
					<table>
						{if $company}
						<tr>
							<td>{$company}</td>
						</tr>
						{/if}
						<tr>
							<td>{$lastname}, {$firstname}</td>
						</tr>
						<tr>
							<td>{$street}</td>
						</tr>
						<tr>
							<td>{$plz} {$city} | {$country}</td>
						</tr>
						<tr>
							<td>{$tel}</td>
						</tr>
					</table>
				</div>
				<div class="row_right">
					<h2>Rechnungsdaten</h2>
					<table>
						<tr style="font-weight: bolder; color: red;">
							<td>RNR</td>
							<td>{$billNr}</td>
						</tr>
						<tr>
							<td>KNR</td>
							<td>{$customernumber}</td>
						</tr>
						<tr>
							<td>Art Nr.</td>
							<td>{$articleNumber}</td>
						</tr>
						<tr>
							<td>Modell</td>
							<td>{$model}</td>
						</tr>
						<tr>
							<td>EUR</td>
							<td>{$price}€</td>
						</tr>
						<tr>
							<td>Zahlart</td>
							<td>{$payKind}</td>
						</tr>
					</table>
				</div>	

				<div class="row_left">
					<img style="height: 350px;" src="{$picture}">
					<div id="notiz">
						<h2>Notiz:</h2>
						<p>{$note}</p>
					</div>
				</div>

				<div class="row_right">
					<p style="font-weight: bolder; float: left; width: 50%;">Profil<br>
					P{$profile}</p>
					<p style="float: right; width: 50%; font-size: 19px;"><img src="https://ewigetrauringe.de/ab_profil_{$profile}.png"></p>
					<p style="font-weight: bolder; color: red; font-size: 19px;">Material: {$alloy} {$color}</p>
					<h2>Damenring</h2>
					<table>
						<tr>
							<td>Größe</td>
							<td>{$wSize}</td>
						</tr>
						<tr>
							<td>Breite</td>
							<td>{$wWidth}</td>
						</tr>
						<tr>
							<td>Stärke</td>
							<td>{$wThickness}</td>
						</tr>
						<tr>
							<td>Gravur</td>
							<td>{$wEngraving}</td>
						</tr>
						<tr>
							<td>Steinbesatz</td>
							<td style="font-weight: bolder; color: red;">{$stone}</td>
						</tr>
					</table>
					<hr style="margin-top: 20px; margin-bottom: 20px;">
					<h2>Herrenring</h2>
					<table>
						<tr>
							<td>Größe</td>
							<td>{$mSize}</td>
						</tr>
						<tr>
							<td>Breite</td>
							<td>{$mWidth}</td>
						</tr>
						<tr>
							<td>Stärke</td>
							<td>{$mThickness}</td>
						</tr>
						<tr>
							<td>Gravur</td>
							<td>{$mEngraving}</td>
						</tr>
					</table>
				</div>
			</div>
		
			<div id="footer">
				<img style="float: right; margin-right: 35px;" src="{$barcodeLeft}"> <img style="float: left;" src="{$barcodeRight}">
			</div>
		</div>
		</div>
	</body>
</html>