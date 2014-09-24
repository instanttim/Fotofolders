{config_load file="template.conf" section="albums"}
{include file="header.tpl" subtitle="$albumName"}
<body>
	<div class="container" id="nav">
		<a href="index.php">{$galleryName}</a>
{if $breadcrumb_array}
	{section name=count loop=$breadcrumb_array}
		&bull; <a href="album.php?album={$breadcrumb_array[count].id}">{$breadcrumb_array[count].name}</a>
	{/section}
{/if}
		&bull; {$albumName}
	</div>
{if $album_array}
	<div class="container" id="albums">
		<h2>Albums</h2>
		<div>
			<table class="thumbtable">
				<tr>
	{section name=count loop=$album_array}
					<td>
						<a href="album.php?album={$albumID}%2F{$album_array[count].id}">
							<img class="albumThumb" height="{#thumbSize#}" width="{#thumbSize#}" src="{$album_array[count].thumb_url}" alt="{$album_array[count].name} Thumb" /><br/>
							{$album_array[count].name}
						</a>
					</td>
		{if %count.rownum% is div by #photoColumns#}
			{if %count.rownum% != count($album_array)}
				</tr><tr>
			{/if}
		{/if}
	{/section}
				</tr>
			</table>
		</div>
	</div>
{/if}
{if $photo_array}
	<div id="photos">
	{if $album_array}
		<h2>Photos</h2>
	{/if}
		<table class="thumbtable">
			<tr>
	{section name=count loop=$photo_array}
				<td valign="top">
					<a href="photo.php?album={$albumID}&amp;photo={$photo_array[count].index}">
						<img height="{#thumbSize#}" width="{#thumbSize#}" src="{$photo_array[count].thumb_url}" alt="{$photo_array[count].thumb_file} Thumb" /><br/>
		{if #showFilenames#}
						{$photo_array[count].name}
		{/if}
					</a>
				</td>
		{if %count.rownum% is div by #photoColumns#}
			{if %count.rownum% != count($photo_array)}
				</tr><tr>
			{/if}
		{/if}
	{/section}
			</tr>
		</table>
	</div>
{/if}
{include file="footer.tpl"}
</body>
</html>