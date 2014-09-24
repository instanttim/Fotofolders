{config_load file="template.conf" section="photos"}
{include file="header.tpl" subtitle="$photoName"}
<body onload="{$preLoad}">
	<script type="text/javascript">
		document.onkeydown=onKeyDown;
		function onKeyDown() {literal}{{/literal}
			checkKey('{$albumID}',{$firstPhoto},{$lastPhoto},{$prevPhoto},{$nextPhoto});
		{literal}}{/literal}
	</script>
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
		<img class="photoBorder" id="photo" width="{$photoWidth}" height="{$photoHeight}" src="{$photoURL}" alt="{$photoName}" /><br/>
		{if #showFilenames#}
		<div class="photoCaption">
			{$photoName}
		</div>
		{/if}
	{elseif $type eq "movie"}
		<!-- Video for Everybody, Kroc Camen of Camen Design -->
		<video class="movieBorder" controls>
			<source src="{$photoURL}"  type="video/mp4" />
			<!-- <source src="__VIDEO__.OGV"  type="video/ogg" /> -->
			<object width="640" height="384" type="application/x-shockwave-flash" data="jwplayer/player.swf">
				<param name="movie" value="jwplayer/player.swf" />
				<param name="flashvars" value="image=__POSTER__.JPG&amp;file={$photoURL}&amp;skin=jwplayer/simple.swf" />
				<img src="__VIDEO__.JPG" width="640" height="360" alt="__TITLE__"
				     title="No video playback capabilities, please download the video below" />
			</object>
		</video>
		<p>
			<strong>Download Video:</strong> <a href="{$photoURL}">"{$photoName}"</a>
		</p>
	{/if}
	</div>
	{include file="footer.tpl"}
</body>
</html>
