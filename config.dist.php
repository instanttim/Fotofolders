<?php

//
// Fotofolders v1.3b
// Copyright 2004-2008. All Rights Reserved, Timothy Martin.
//

//
// PHP system configuration
//
ini_set('display_errors','1');
error_reporting(E_ALL ^ E_NOTICE);

//
// important include files that fotofolders needs to operate
//
define("SMARTY_INCLUDE", "/path/to/Smarty.class.php");
define("FEEDCREATOR_INCLUDE", "/path/to/feedcreator.class.php");

//
// general config
//
define("FF_TITLE", "Fotofolders");
define("FF_DESC", "Some Great Photos");
define("FF_OWNER", "Some Guy");

//
// app config
//
define("FF_URL", "http://my.domain.com/fotofolders/");
define("FF_PHOTODIR", "photo_library/");	// relative to the install dir
define("FF_THUMBDIR", "_data/");
define("FF_IMAGESDIR", "images/");

//
// thumbnail options
//
define("FF_THUMBSIZE", 96);
define("FF_THUMBQUALITY", 90);
define("FF_THUMBSCALE", 0.80);
define("FF_EMPTYIMG", "empty.jpg");

//
// misc options
//
define("FF_REVERSEINDEX", FALSE);
define("FF_MANUALINDEX", FALSE);
define("FF_SHOWINFO", FALSE);

?>

