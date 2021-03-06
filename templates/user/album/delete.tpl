{* purpose of this template: albums delete confirmation view in user area *}
{include file='user/header.tpl'}
<div class="muimage-album muimage-delete">
{gt text='Delete album' assign='templateTitle'}
{pagesetvar name='title' value=$templateTitle}
<div class="z-frontendcontainer">
    <h2>{$templateTitle}</h2>

    <p class="z-warningmsg">{gt text='Do you really want to delete this album ?'}</p>
    <p class="z-warningmsg">{gt text='Notice. If you delete this album, you will also delete its sub albums and all their pictures!'}</p>
        <p class="z-warningmsg">{gt text='Notice. If there are blocks or contenttypes saved with this album you should delete them before deleting this album!'}</p>
    <form class="z-form" action="{modurl modname='MUImage' type='user' func='delete' ot='album' id=$album.id}" method="post">
        <div>
            <input type="hidden" name="csrftoken" value="{insert name='csrftoken'}" />
            <input type="hidden" id="confirmation" name="confirmation" value="1" />
            <fieldset>
                <legend>{gt text='Confirmation prompt'}</legend>
                <div class="z-buttons z-formbuttons">
                    {gt text='Delete' assign='deleteTitle'}
                    {button src='14_layer_deletelayer.png' set='icons/small' text=$deleteTitle title=$deleteTitle class='z-btred'}
                    <a href="{modurl modname='MUImage' type='user' func='view' ot='album'}">{icon type='cancel' size='small' __alt='Cancel' __title='Cancel'} {gt text='Cancel'}</a>
                </div>
            </fieldset>

            {notifydisplayhooks eventname='muimage.ui_hooks.albums.form_delete' id="`$album.id`" assign='hooks'}
            {foreach from=$hooks key='hookName' item='hook'}
            <fieldset>
                <legend>{$hookName}</legend>
                {$hook}
            </fieldset>
            {/foreach}
        </div>
    </form>
</div>
</div>
{include file='user/footer.tpl'}
