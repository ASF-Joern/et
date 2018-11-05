{* Sidebar auf Shopseiten erweitert - ABC-Seitenmenu *}
{extends file='parent:frontend/index/sites-navigation.tpl'}
{block name="frontend_index_left_menu_container" append}

    {* Trauring Bar Shopseiten von 46 bis 96 Shopseiten ID *}
    {if $sCustomPage.tpl1variable === "vorteile"}
        <div class="shop-sites--container is--rounded">
            {block name='frontend_index_left_menu_headline'}
				<div class="navigation--headline">Vorteile</div>
            {/block}
            <ul role=menu style="line-height: 2rem;margin: 0rem 1rem 1rem 1rem;
							list-style: outside none none;
							background-image: url(themes/Frontend/ET_Updatesicher/frontend/images/vorteile-bei-ringkauf-icons.jpg);
							background-repeat: no-repeat; padding-left: 30px; background-size: contain;">
                <li class="navigation--entry" role="menuitem">Gratis Ringetui</li>
                <li class="navigation--entry" role="menuitem">1 Monat Widerrufsrecht</li>
                <li class="navigation--entry" role="menuitem">Kostenlose Gravur</li>
                <li class="navigation--entry" role="menuitem">Kostenloser Versand</li>
                <li class="navigation--entry" role="menuitem">Echtheitszertifikat</li>
                <li class="navigation--entry" role="menuitem">Allergiefrei</li>
                <li class="navigation--entry" role="menuitem">Eigene Herstellung in DE</li>
            </ul>
        </div>
		
        <div class="shop-sites--container is--rounded" style="height: 175px">
            {block name='frontend_index_left_menu_headline'}
			<div class="navigation--headline">Wir im Video</div>
			{/block}
            <p class="modal--size-table" style="margin: 0rem 1rem 1rem 1rem;" data-content=""
               data-modalbox="true" data-targetselector="a" data-width="660" data-height="475"
               data-mode="ajax"><a href="https://www.ewigetrauringe.de/imagefilm-von-ewigetrauringe"> <img style="float: right; margin-left: 15px;"
                                                                                                           title="Video abspielen: Eheringe von Ewigetrauringe"
                                                                                                           src="themes/Frontend/ET_Updatesicher/frontend/images/ewigetrauringe-video-abspielen.png"
                                                                                                           alt="Imagefilm - Ewigetrauringe" /></a>
            </p>
        </div>
    {/if}

    {* Trauring-ABC Shopseiten *}
    {if $sCustomPage.grouping === "trauring-abc" || $sCustomPage.grouping === "hochzeit-abc"}
        <div class="shop-sites--container is--rounded">
            {block name='frontend_index_left_menu_headline'}
                <div class="shop-sites--headline navigation--headline">
                {if $sCustomPage.grouping === "trauring-abc"}
                    {s namespace='frontend/index/menu_left' name="MenuLeftHeadingABC1"}{/s}
                {else}
                    {s namespace='frontend/index/menu_left' name="MenuLeftHeadingABC2"}{/s}
                {/if}
                </div>
            {/block}
            <nav class="abc-nav">
                <ul class="abc-nav-ul">
                    {assign value="" var="char"}
                    {foreach from=$sMenu[$sCustomPage.grouping] item=page}
                        {if $char !== $page.description|substr:0:1}
                            {if $char !== ""}
                                </ul>
                            </li>
                            {/if}
                            {$char = $page.description|substr:0:1}
                            <li><a href="#">{$page.description|substr:0:1}</a>
                                <ul>
                        {/if}
                                <li><a href="{$page.link}" title="Infos zu {$page.description}">{$page.description}</a></li>
                    {/foreach}
                </ul>
            </nav>
        </div>
    {/if}

{/block}