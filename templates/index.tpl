{config_load file="template.conf" section="index"}
{include file="header.tpl"}
<body>
	<div class="container" id="nav">
		<span id="about"><a href="about.php">About Fotofolders</a></span>
		<h1>{$galleryName}</h1>
	</div>
	<div class="container" id="index">
{if $index_array}
	{section name=i loop=$index_array}
		<div class="indexAlbum">
			<div class="indexAlbumInfo">
				<div class="indexAlbumTitle">
					<a href="album.php?album={$index_array[i].id}">{$index_array[i].name}</a>
				</div>
		{if $index_array[i].album_array}
			{section name=j loop=$index_array[i].album_array}
				<div class="indexSubAlbum">
					<a href="album.php?album={$index_array[i].id}%2F{$index_array[i].album_array[j].id}">
						<img class="indexThumb" height="{#thumbSize#}" width="{#thumbSize#}" src="{$index_array[i].album_array[j].thumbsrc}" alt="{$index_array[i].album_array[j].thumbsrc}" />
						<span class="indexCaption">{$index_array[i].album_array[j].name}</span>
					</a>
				</div>
			{/section}
		{/if}
			</div>
		</div>
	{/section}
{else}
	There are no photo albums.
{/if}
	</div>
{include file="footer.tpl"}
</body>
</html>
