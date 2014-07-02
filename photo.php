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
$smarty->assign("photoPath", htmlentities($album->dir.$album->photo_array[$photoIndex]['photo_file']));
$smarty->assign("nextPhotoPath", htmlentities($album->dir.$album->photo_array[$nextNum - 1]['photo_file']));

$smarty->assign("type", $album->photo_array[$photoIndex]['type']);

if ($album->photo_array[$photoIndex]['type'] == 'jpg') {
	$size = getimagesize($album->dir.$album->photo_array[$photoIndex]['photo_file']);
	$smarty->assign("photoWidth", $size[0]);
	$smarty->assign("photoHeight", $size[1]);
}



if (FF_SHOWEXIF) {
/*	require("exif.php");
	$exifInfo = read_exif_data_raw($albumDir.$album->photo_array[$photoIndex]['photo_file'],0);
	
	//$commentExplode = explode("ASCII", $exifInfo['SubIFD']['UserCommentOld']);
	//$comment = $commentExplode[1];
	
	$smarty->assign("exif_desc",$exifInfo['IFD0']['ImageDescription']);
	//$smarty->assign("exif_usercomment", $comment);
	$smarty->assign("exif_make",$exifInfo['IFD0']['Make']);
	$smarty->assign("exif_model",$exifInfo['IFD0']['Model']);
	$smarty->assign("exif_datetime",$exifInfo['SubIFD']['DateTimeOriginal']);
	$smarty->assign("exif_exposuretime",$exifInfo['SubIFD']['ExposureTime']);
	$smarty->assign("exif_iso",$exifInfo['SubIFD']['ISOSpeedRatings']);
	$smarty->assign("exif_shutterspeed",$exifInfo['SubIFD']['ShutterSpeedValue']);
	$smarty->assign("exif_aperture",$exifInfo['SubIFD']['ApertureValue']);
	$smarty->assign("exif_exposurebias",$exifInfo['SubIFD']['ExposureBiasValue']);
	$smarty->assign("exif_flash",$exifInfo['SubIFD']['Flash']);
*/

	function output_iptc_data( $image_path ) {    
	   $size = getimagesize ( $image_path, $info);        
	     if(is_array($info)) {    
	       $iptc = iptcparse($info["APP13"]);
/*
			echo '<pre>';
			print_r($iptc);
   			echo '</pre>';
*/
		return $iptc;
	   }
	return false;
	}

	$iptc = output_iptc_data($album->dir.$album->photo_array[$photoIndex]['photo_file']);
	$title = $iptc['2#005'][0];
	$smarty->assign("exif_desc", $title);
	
	$smarty->assign("cfg_exif",FF_SHOWEXIF);
}

$smarty->assign("debug_output", $debugOutput);

if (isset($_GET['popup'])) {
	$smarty->display("photo_popup.tpl");
} else {
	$smarty->display("photo.tpl");
}

?>