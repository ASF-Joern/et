{extends file="parent:frontend/detail/actions.tpl"}

{block name='frontend_detail_actions_notepad'}
    {if !$sArticle.attributes.AsfAfterbuyIsMarked}
        <form action="{url controller='note' action='add' ordernumber=$sArticle.ordernumber _seo=false}" method="post">
            <button type="submit"
                    title="{"{s name='DetailLinkNotepad' namespace='frontend/detail/actions'}{/s}"|escape}"
                    class="action--link link--notepad"
                    data-ajaxUrl="{url controller='note' action='ajaxAdd' ordernumber=$sArticle.ordernumber _seo=false}"
                    data-text="{s name="DetailNotepadMarked"}{/s}">
                <i class="icon--heart"></i> <span class="action--text">{s name="DetailLinkNotepadShort" namespace="frontend/detail/actions"}{/s}</span>
            </button>
        </form>
    {else}
        <form action="{url controller='note'}" method="post">
            <button type="submit"
                    title="{"{s name='DetailNotepadMarkedTitle' namespace='frontend/detail/actions'}Jetzt Merkzettel ansehen{/s}"|escape}"
                    class="action--link link--notepad js--is-saved">
                <i class="icon--check"></i> <span class="action--text">{s name="DetailNotepadMarked"}{/s}</span>
            </button>
        </form>
    {/if}
{/block}