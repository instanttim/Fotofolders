<?php
require("fotofolders.php");

$smarty = createSmarty();

$smarty->assign("galleryName",FF_TITLE);
$smarty->assign("galleryURL",FF_URL);

$photoIndex = $_GET['photo'] - 1;
$album = new album($_GET['album']);

$firstNum = 1;
$lastNum = count($album->photo_array);

if ($photoIndex == NULL) {
	$photoIndex = 0;
}

$nextNum = cycle($firstNum, $lastNum, $_GET['photo'] + 1);
$prevNum = cycle($firstNum, $lastNum, $_GET['photo'] - 1);

$smarty->assign("breadcrumb_array", $album->breadcrumb);
$smarty->assign("albumName", $album->name);
$smarty->assign("albumID", $album->id);
$smarty->assign("albumDir", htmlentities($album->dir));
$smarty->assign("photoNum", $_GET['photo']);
$smarty->assign("firstPhoto", $firstNum);
$smarty->assign("prevPhoto", $prevNum);
$smarty->assign("nextPhoto", $nextNum);
$smarty->assign("lastPhoto", $lastNum);	

$smarty->assign("photoName", $album->photo_array[$photoIndex]['name']);
$smarty->assign("photoURL", htmlentities($album->photo_array[$photoIndex]['photo_url']));

$smarty->assign("type", $album->photo_array[$photoIndex]['type']);

if ($album->photo_array[$photoIndex]['type'] == 'image') {
	$size = getimagesize($album->dir.$album->photo_array[$photoIndex]['photo_file']);
	// TODO: should evaluate if we're sending to an iOS device, and change the size before we even load?
	$smarty->assign("photoWidth", $size[0]);
	$smarty->assign("photoHeight", $size[1]);
}

if (FF_PRELOAD) {
	$preloadURL = FF_URL.$album->dir.rawurlencode($album->photo_array[$nextNum - 1]['photo_file']);
	$smarty->assign("preLoad", "preloader('".$preloadURL."');");
}

$smarty->assign("debug_output", $debugOutput);
$smarty->assign("version",FF_VERSION);

if (isset($_GET['popup'])) {
	$smarty->display("photo_popup.tpl");
} else if (detectIOS() == TRUE) {
	$smarty->display("ios-photo.tpl");
} else {
	$smarty->display("photo.tpl");
}
?>