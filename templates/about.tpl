{config_load file="template.conf" section="about"}
{include file="header.tpl"}
<body>
	<div id="breadcrumb">
		<span class="title">About Fotofolders</span>
	</div>
	<p>Version {$version}</p>
	<p>
		Fotofolders is valid in so many ways, let me count the ways:
	</p>
	<p>
		<a href="http://validator.w3.org/check/referer"><img src="http://www.w3.org/Icons/valid-xhtml10.png" alt="Valid XHTML 1.0!" height="31" width="88" /></a><br/>
		XHTML 1.0
	</p>
	<p>
		<a href="http://jigsaw.w3.org/css-validator/"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a><br/>
		CSS 2/3
	</p>
	<p>
		<a href="http://feedvalidator.org/check?url=http://talking-dog.com/photos/rss.php"><img src="images/valid-rss.png" alt="Valid RSS" title="Validate my RSS feed" width="88" height="31" /></a><br/>
		RSS 1.0 (RDF)
	</p>
{include file="footer.tpl"}
</body>
</html>
