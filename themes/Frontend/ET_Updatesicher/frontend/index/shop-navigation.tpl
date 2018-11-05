{extends file="parent:frontend/index/shop-navigation.tpl"}

{* Menu (Off canvas left) trigger *}
{block name='frontend_index_offcanvas_left_trigger'}
    <li class="navigation--entry entry--menu-left" role="menuitem">
        <a class="entry--link entry--trigger btn is--icon-left" href="#offcanvas--left" data-offcanvas="true" data-offCanvasSelector=".sidebar-main">
            <i class="icon--menu"></i> <span>{s namespace='frontend/index/menu_left' name="IndexLinkMenu"}{/s}</span>
        </a>
    </li>
{/block}
