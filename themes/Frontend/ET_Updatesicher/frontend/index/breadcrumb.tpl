{extends file="parent:frontend/index/breadcrumb.tpl"}

{block name="frontend_index_breadcrumb_prefix" append}
<li style="margin-top: 15px;" class="breadcrumb--entry" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
	<a class="breadcrumb--icon" href="{url controller='index'}" itemprop="item"><i class="icon--house"></i></a>
</li>
<li class="breadcrumb--separator">
	<i class="icon--arrow-right"></i>
</li>
{/block}