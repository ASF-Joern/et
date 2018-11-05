{* Sidebar left Vorteile *}
{extends file='parent:frontend/index/sidebar.tpl'}
{block name='frontend_index_left_categories' append}
{if !$sCustomPage}
<div class="sidebar--categories-navigation">
	<div class="sidebar--navigation">
        <div class="navigation--headline">Vorteile</div>
        <ol class="sidebar--navigation categories--navigation" style="line-height: 2rem;
    list-style: outside none none; border: 0px;
    background-image: url(themes/Frontend/ET_Updatesicher/frontend/images/vorteile-bei-ringkauf-icons.jpg);
    background-repeat: no-repeat; padding-left: 30px; margin: 0rem 1rem 1rem 1rem; background-size: contain;" role="menu">
            <li class="navigation--entry" role="menuitem">Gratis Ringetui</li>
            <li class="navigation--entry" role="menuitem">1 Monat Widerrufsrecht</li>
            <li class="navigation--entry" role="menuitem">Kostenlose Gravur</li>
            <li class="navigation--entry" role="menuitem">Kostenloser Versand</li>
            <li class="navigation--entry" role="menuitem">Echtheitszertifikat</li>
            <li class="navigation--entry" role="menuitem">Allergiefrei</li>
            <li class="navigation--entry" role="menuitem">Eigene Herstellung in DE</li>
        </ol>
    </div>
</div>

<div class="sidebar--categories-navigation">
	<div class="sidebar--navigation" style="height: 175px;">
	<div class="navigation--headline">Wir im Video</div>
		<p class="modal--size-table" style="margin: 0rem 1rem 1rem 1rem;" data-content=""
		data-modalbox="true" data-targetselector="a" data-width="660" data-height="500"
		data-mode="ajax"><a href="https://www.ewigetrauringe.de/imagefilm-von-ewigetrauringe" title="Zum Ewigetrauringe Video">
		<img title="Video abspielen: Eheringe von Ewigetrauringe"
		src="themes/Frontend/ET_Updatesicher/frontend/images/ewigetrauringe-video-abspielen.png"
		alt="Imagefilm - Ewigetrauringe" /></a>
		</p>
	</div>
</div>

	<div class="sidebar--categories-navigation">
	<div class="sidebar--navigation">
		<div class="navigation--headline">Ringgröße bestimmen</div>
		<a href="https://www.ewigetrauringe.de/ringmass-kostenlos-anfordern" title="Zum Ringmaßband-Formular">
		<img src="themes/Frontend/ET_Updatesicher/frontend/images/ringroesse-ermitteln.png" style="width: 200px;
    margin: 0rem 1rem 0rem 1rem;" alt="Ringröße ermitteln" title="Ringmaßband hier kostenlos!">
		</a>
	</div>
</div>
{/if}
{/block}