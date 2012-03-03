{* purpose of this template: albums view view in user area *}
<div class="muimage-album muimage-view">
{include file='user/header.tpl'}
{gt text='Album list' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>

    <div id="album_header">
    {checkpermissionblock component='MUImage::' instance='.*' level="ACCESS_ADD"}
        {gt text='Create album' assign='createTitle'}
        <a href="{modurl modname='MUImage' type='user' func='edit' ot='album'}" title="{$createTitle}" class="z-icon-es-add">
            {$createTitle}
        </a>
    {/checkpermissionblock}

    {assign var='all' value=0}
    {if isset($showAllEntries) && $showAllEntries eq 1}
        {gt text='Back to paginated view' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='album'}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
        {assign var='all' value=1}
    {else}
        {gt text='Show all entries' assign='linkTitle'}
        <a href="{modurl modname='MUImage' type='user' func='view' ot='album' all=1}" title="{$linkTitle}" class="z-icon-es-view">
            {$linkTitle}
        </a>
    {/if}
    </div>
    {if isset($items)}
    {foreach item='album' from=$items}
    <div class="muimage_view_album_container">
    <div class="muimage_view_album_title">
    <a href="{modurl modname='MUIMage' type='user' func='display' ot='album' id="`$album.id`"}">{$album.title}</a>
    <div class="muimage_view_album_title_action">
    {if count($album._actions) gt 0}
        {strip}
        {foreach item='option' from=$album._actions}
        <a href="{$option.url.type|muimageActionUrl:$option.url.func:$option.url.arguments}" title="{$option.linkTitle|safetext}"{if $option.icon eq 'preview'} target="_blank"{/if}>
              {icon type=$option.icon size='extrasmall' alt=$option.linkText|safetext}
        </a>
        {/foreach}
        {/strip}
    {/if}
    </div>
    </div>
    <div class="muimage_view_album_description">
    {$album.description}
    </div>
    <div class="muimage_view_album_image">
    {$album.id|muimageGetFirstAlbumImage:$childAlbum.id}
    </div>
    <div class="muimage_view_album_bottom">
    {$album.description}
    </div>
    </div>
    {/foreach}
    {else}
    {gt text='No SubAlbums'}
    {/if}
    
    <div style="clear: both">&nbsp;</div>

    {if !isset($showAllEntries) || $showAllEntries ne 1}
        {pager rowcount=$pager.numitems limit=$pager.itemsperpage display='page'}
    {/if}

   {* {notifydisplayhooks eventname='muimage.ui_hooks.albums.display_view' urlobject=$currentUrlObject assign='hooks'} *}
    {foreach key='hookname' item='hook' from=$hooks}
        {$hook}
    {/foreach} 
</div>
</div>
{include file='user/footer.tpl'}
