{config_load file="template.conf" section="photos"}
{include file="header.tpl" subtitle="$photoName"}
<body onload="preloader('{$galleryURL}{$nextPhotoPath}');">
<div class="container" id="nav">
	<a href="index.php">{$galleryName}</a>
{if $breadcrumb_array}
	{section name=count loop=$breadcrumb_array}
		&bull; <a href="album.php?album={$breadcrumb_array[count].id}">{$breadcrumb_array[count].name}</a>
	{/section}
{/if}
	&bull; <a href="album.php?album={$albumID}">{$albumName}</a>
</div>
<div id="photoNav2">
	<a href="photo.php?album={$albumID}&amp;photo={$firstPhoto}">First</a>
	&bull;
	<a href="photo.php?album={$albumID}&amp;photo={$lastPhoto}">Last</a>
</div>
<div id="photoNav">
	<a href="photo.php?album={$albumID}&amp;photo={$prevPhoto}">&laquo;&mdash;</a>
	&nbsp;{$photoNum} of {$lastPhoto}&nbsp;
	<a href="photo.php?album={$albumID}&amp;photo={$nextPhoto}">&mdash;&raquo;</a>
</div>
<div>
{if $type eq "image"}
	<img class="photoBorder" width="{$photoWidth}" height="{$photoHeight}" src="{$photoPath}" alt="{$photoName}" /><br/>
	{if #showFilenames#}
	<div class="photoCaption">
		{$photoName}
	</div>
	{/if}
{elseif $type eq "movie"}
	<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="320" height="256">
		<param name="src" value="{$galleryURL}{$photoPath}" />
		<param name="pluginspage" value="http://www.apple.com/quicktime/download/" />
		<param name="controller" value="true" />
		<param name="autoplay" value="true" />
		<embed src="{$galleryURL}{$photoPath}" width="320" height="256" autoplay="false"/>
	</object>
{/if}
</div>
{if $cfg_exif}
	{include file="photo_exif.tpl"}
{/if}
{include file="footer.tpl"}
</body>
</html>
