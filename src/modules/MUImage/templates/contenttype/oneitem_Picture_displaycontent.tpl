{* Purpose of this template: Display movies within an external context *}
{pageaddvar name='javascript' value='zikula.imageviewer'}
<a href="{$item.imageUploadFullPathURL}" title="{$item.title|replace:"\"":""}"{if $item.imageUploadMeta.isImage} rel="imageviewer[item]"{/if}>
    {if $item.imageUploadMeta.isImage}
        <img src="{$item.imageUpload|muimageImageThumb:$item.imageUploadFullPath:250:150}" width="250" height="150" alt="{$item.title|replace:"\"":""}" />
    {else}
        {gt text='Download'} ({$item.imageUploadMeta.size|muimageGetFileSize:$item.imageUploadFullPath:false:false})
    {/if}
</a>