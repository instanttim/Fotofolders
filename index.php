<?php
require("fotofolders.php");

$smarty = createSmarty();

$smarty->assign("galleryName",FF_TITLE);

$index = new index();

if (isset($index->album_array)) {
	foreach ($index->album_array as $album) {
		$index_array[] = array(
			"name"=>$album->name,
			"id"=>$album->id,
			"album_array"=>$album->album_array
		);
	}
	$smarty->assign("index_array",$index_array);
}

$smarty->assign("debug_output", $debugOutput);
$smarty->assign("version",FF_VERSION);
$smarty->display("index.tpl");

?>
