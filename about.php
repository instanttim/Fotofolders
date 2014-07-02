<?php
require("fotofolders.php");

$smarty = createSmarty();
$smarty->assign("galleryName",FF_TITLE);
$smarty->assign("version",FF_VERSION);

$smarty->display("about.tpl");
?>
