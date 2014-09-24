{config_load file="template.conf" section="header"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset = utf-8" />
	<meta name="viewport" content="width = device-width">
	<meta name = "viewport" content = "initial-scale = 1.0, user-scalable = yes">
	<title>{$galleryName}{if $subtitle}: {$subtitle}{/if}</title>
	<link rel="Stylesheet" href="{$stylesheet|default:"templates/ios-fotofolders.css"}" type="text/css" />
	<script src="fotofolders.js" type="text/javascript"></script>
</head>


