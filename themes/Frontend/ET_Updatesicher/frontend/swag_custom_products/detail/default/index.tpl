{namespace name="frontend/detail/option"}

{* Comes from AsfAfterbuy/Subscriber/Detail.php *}
{if $asfTemplateFile}
    {include file="frontend/swag_custom_products/detail/default/ringarten/$asfTemplateFile"}
{else}
    {include file="frontend/swag_custom_products/detail/default/original.tpl"}
{/if}