{* Top bar main *}
{block name="frontend_index_top_bar_main"}
    <div class="top-bar">

        {* Top bar main container *}
        {block name="frontend_index_top_bar_main_container"}
            <div class="container block-group">

                {* Top bar navigation *}
                {block name="frontend_index_top_bar_nav"}
                    <nav class="top-bar--navigation block">

                        {* Article Compare *}
                        {block name='frontend_index_navigation_inline'}
                            {if {config name="compareShow"}}
                                <div class="navigation--entry entry--compare is--hidden" role="menuitem" aria-haspopup="true" data-drop-down-menu="true">
                                    {block name='frontend_index_navigation_compare'}
                                        {action module=widgets controller=compare}
                                    {/block}
                                </div>
                            {/if}
                        {/block}

                        {* Service / Support drop down *}
                        {block name="frontend_index_checkout_actions_service_menu"}
                            <div id="top-bar-service">
                                <ul>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#echtheitszertifikat"
                                             title="Trauring-Service mit Echtheitszertifikat">Echtheitszertifikat</a></li>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#widerrufsrecht"
                                             title="Trauring-Service mit 1 Monat Widerrufsrecht">1 Monat Widerrufsrecht</a></li>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#kostenlose-gravur"
                                             title="Eheringe mit kostenloser Gravur">Kostenlose Gravur</a></li>
                                    <li><span>✔</span> <a href="trauringe-service#kostenloser-versand"
                                             title="Eheringe mit kostenlosem Versand">Kostenloser Versand</a></li>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#gratis-ringetui"
                                             title="Gratis Eheringe-Etui inklusive">Gratis Ringetui</a></li>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#made-in-germany"
                                             title="Eheringe made in Germany">Made in Germany</a></li>
                                    <li><span>✔</span> <a href="https://www.ewigetrauringe.de/trauringe-service#lebenslange-garantie"
                                             title="Lebenslange Garantie auf Eheringe">Lebenslange Garantie</a></li>
                                </ul>
                                <div id="MyCustomTrustbadge"></div>
						<div id="header-service">
							<a href="tel:+4964048029020" style="font-size: 1rem;" title="Rufen Sie uns an"><i aria-hidden="true"
								class="fa fa-phone fa-2x" style="padding: 5px; color: #ab3333"></i>
								<div style="float: right;"><strong>Trauring-Beratung</strong><br>
								<span style="font-size: 1rem;float: left;">06404-8029020</span></div>
							</a>
						</div>
                            </div>
                        {/block}
                    </nav>
                {/block}
            </div>
        {/block}
    </div>
{/block}