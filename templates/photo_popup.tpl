{config_load file="template.conf" section="photos"}
{include file="header_popup.tpl" subtitle="$photoName"}
<body>
	<div id="photoNav2">
		<a href="photo.php?album={$albumID}&amp;photo={$firstPhoto}&amp;popup">First</a>
		&bull;
		<a href="photo.php?album={$albumID}&amp;photo={$lastPhoto}&amp;popup">Last</a>
	</div>
	<div id="photoNav">
		<a href="photo.php?album={$albumID}&amp;photo={$prevPhoto}&amp;popup">&laquo;&mdash;</a>
		&nbsp;{$photoNum} of {$lastPhoto}&nbsp;
		<a href="photo.php?album={$albumID}&amp;photo={$nextPhoto}&amp;popup">&mdash;&raquo;</a>
	</div>
	<div>
		<img class="photoBorder" width="{$photoWidth}" height="{$photoHeight}" src="{$photoPath}" alt="{$photoName}" /><br/>
{if #showFilenames#}
		<div class="photoCaption">
			{$photoName}
		</div>
{/if}
	</div>
{include file="footer.tpl"}
</body>
</html>
