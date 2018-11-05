{extends file="parent:frontend/index/index.tpl"}
{block name="frontend_index_header_javascript_jquery" append}
    <meta id="comerStickyHeader" content="Ewigetrauringe Menü" itemprop="comerStickyHeaderNavigation" data-showdesktop="{if $stickyHeaderShowDesktop}true{else}false{/if}" data-showmobile="{if $stickyHeaderShowMobile}true{else}false{/if}" data-duration="{if $stickyHeaderDuration}{$stickyHeaderDuration}{else}0{/if}">
{/block}