{extends file="parent:widgets/checkout/info.tpl"}

{* Notepad entry *}
{block name="frontend_index_checkout_actions_notepad" prepend}
    <li class="navigation--entry entry--phone" role="menuitem">
		{s name="checkout/info/telefon"}
		<a href="tel:+4964048029020" title="Rufen Sie uns an" class="btn">
            <i class="icon--phone" style="font-size: 18px; font-size: 1.225rem; vertical-align: middle; color: #ab3333;"></i>
        </a>	
		{/s}
    </li>
{/block}