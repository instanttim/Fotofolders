{config_load file="template.conf" section="photos"}
{include file="ios-header.tpl" subtitle="$photoName"}
<body onload="setTimeout('hideAddressBar()', 100);{$preLoad}" onresize="resizeImage()">
	<div class="container" id="nav">
		&larr; <a href="album.php?album={$albumID}">{$albumName}</a>
		<div id="photoNav">
			<a href="photo.php?album={$albumID}&amp;photo={$prevPhoto}">&laquo;&mdash;</a>
			&nbsp;{$photoNum} of {$lastPhoto}&nbsp;
			<a href="photo.php?album={$albumID}&amp;photo={$nextPhoto}">&mdash;&raquo;</a>
		</div>
	</div>
	<div>
	{if $type eq "image"}
		<img class="photoBorder" id="photo" width="{$photoWidth}" height="{$photoHeight}" src="{$photoURL}" alt="{$photoName}" onload="resizeImage()" /><br/>
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
</body>
</html>
