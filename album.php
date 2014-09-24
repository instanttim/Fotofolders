<?php
require("fotofolders.php");

$smarty = createSmarty();

$smarty->assign("galleryName",FF_TITLE);

if (isset($_GET['album'])) {
	$albumID = $_GET['album'];
} else {
	$albumID = "_index";
}

$album = new album($albumID);

$smarty->assign("breadcrumb_array",$album->breadcrumb);
$smarty->assign("albumName",$album->name);
$smarty->assign("albumID",$album->id);
$smarty->assign("albumDir",htmlentities($album->dir));

if (isset($album->album_array) && count($album->album_array) > 0) {
	$smarty->assign("album_array",$album->album_array);
}

if (isset($album->photo_array) && count($album->photo_array) > 0) {
	$smarty->assign("photo_array",$album->photo_array);
}

$smarty->assign("debug_output", $debugOutput);
$smarty->assign("version",FF_VERSION);
$smarty->display("album.tpl");

?>