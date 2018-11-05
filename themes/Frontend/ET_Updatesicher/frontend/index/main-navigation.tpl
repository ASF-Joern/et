{extends file="parent:/frontend/index/main-navigation.tpl"}

{* Wurde bearbeitet um den Titel der Startseite umbennenen zu können *}
{block name='frontend_index_navigation_categories_top_link_home'}
    <a class="navigation--link is--first{if $sCategoryCurrent == $sCategoryStart && $Controller == 'index'} active{/if}" href="{url controller='index'}" title="Home" itemprop="url">
        <span itemprop="name">{s name='IndexLinkHome' namespace="frontend/index/categories_top"}{/s}</span>
    </a>
{/block}
