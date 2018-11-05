<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {strip}

        {if $smarty.get.homepage == 1}
            {block name="frontend_sitemap_xml_homepage"}
                {include file="frontend/sitemap_xml/entry.tpl" urlParams = ['controller' => 'index']}
            {/block}
        {/if}
        {if $smarty.get.kategorien == 1}
            {block name="frontend_sitemap_xml_categories"}
                {foreach $sitemap.categories as $category}
                    {if $category.show}
                        {include file="frontend/sitemap_xml/entry.tpl" urlParams = $category.urlParams lastmod = $category.changed}
                    {/if}
                {/foreach}
            {/block}
        {/if}

        {if $smarty.get.artikel == 1}
            {block name="frontend_sitemap_xml_articles"}
                {foreach $sitemap.articles as $article}
                    {include file="frontend/sitemap_xml/entry.tpl" urlParams = $article.urlParams lastmod = $article.changed}
                {/foreach}
            {/block}
        {/if}

        {if $smarty.get.blogs == 1}
            {block name="frontend_sitemap_xml_blogs"}
                {foreach $sitemap.blogs as $blog}
                    {include file="frontend/sitemap_xml/entry.tpl" urlParams = $blog.urlParams lastmod = $blog.changed}
                {/foreach}
            {/block}
        {/if}

        {if $smarty.get.custom == 1}
            {block name="frontend_sitemap_xml_custom_pages"}
                {foreach $sitemap.customPages as $customPage}
                    {if $customPage.show}
                        {include file="frontend/sitemap_xml/entry.tpl" urlParams = $customPage.urlParams lastmod = $customPage.changed}
                    {/if}
                {/foreach}
            {/block}
        {/if}

        {if $smarty.get.hersteller == 1}
            {block name="frontend_sitemap_xml_suppliers"}
                {foreach $sitemap.suppliers as $supplier}
                    {include file="frontend/sitemap_xml/entry.tpl" urlParams = $supplier.urlParams lastmod = $supplier.changed}
                {/foreach}
            {/block}
        {/if}

        {if $smarty.get.landingpages == 1}
            {block name="frontend_sitemap_xml_landingpages"}
                {foreach $sitemap.landingPages as $landingPage}
                    {if $landingPage.show}
                        {include file="frontend/sitemap_xml/entry.tpl" urlParams = $landingPage.urlParams lastmod = $landingPage.0.modified}
                    {/if}
                {/foreach}
            {/block}
        {/if}
    {/strip}
</urlset>