<?php
require("config.php");

//
// Please don't change this!
//
define("FF_VERSION","1.3b3");

// sets up the smarty template
function createSmarty() {
	require(SMARTY_INCLUDE);
	$smarty = new Smarty;
	$smarty->config_dir = dirname(__FILE__).'/templates/';
	$smarty->compile_check = TRUE;
	$smarty->debugging = FALSE;

	return $smarty;
}

// number cycler					 
function cycle($min, $max, $newNum) {

	if ($newNum < $min) {
		$newNum = $max;
	} else if ($newNum > $max) {
		$newNum = $min;
	}
	return $newNum;
}

// debugging, html style
function print_debug($debug_input) {
	global $debugOutput;
	$debugOutput = htmlentities(print_r($debug_input, TRUE), ENT_COMPAT, 'UTF-8');
}

class index {
	// index arrays
	var $album_array;
		
	// album constructor
	function index() {
			
		if ($dir_handle = @opendir(FF_PHOTODIR)) {
			// go through and get all the files that are really directories (and don't start with ".")
			while ($file = readdir($dir_handle)) { 
				if (strpos($file, ".") !== 0) {
					if (is_dir(FF_PHOTODIR.$file) && $file != current(split("/",FF_THUMBDIR))) {
						$directories[] = $file;
					}							
				}
			}
			closedir($dir_handle);
			
			// if there are directories, sort and make a new array with names/urls	
			if (isset($directories)) {
				if (FF_MANUALINDEX) {
					// check for the data file
					// DONE: check to see if any directories aren't in the data file, then add them
					// DONE: check to see if there are any directories that don't exist anymore, then remove them
					// DONE: use the resulting directory list!
					// DONE: rebuild the file if changes were made
					
/* Code for parsing a descript.ion file

	$descriptions = Array(); 
	if ($useDescriptionsFrom!="") { 
		$descriptionsFile = @file($useDescriptionsFrom); 
		if ($descriptionsFile!==false) { 
			for ($i=0;$i<count($descriptionsFile);$i++) { 
				$d = explode($separationString,$descriptionsFile[$i]); 
				if (!$descriptionFilenamesCaseSensitive) { 
					$d[0] = strtolower($d[0]); 
				} 
				$descriptions[$d[0]] = htmlentities(join($separationString, array_slice($d, 1))); 
			} 
		} 
	} 

*/	
				
					// BUG: need to look in the actual location, not just this hardcoded location.!
					if (file_exists(FF_PHOTODIR.FF_THUMBDIR."_albums.txt")) {
						
						// this reads in the data file and removes the newlines
						$albumList = array();
						foreach (file(FF_PHOTODIR.FF_THUMBDIR."_albums.txt") as $line) {
							$albumList[] = rtrim($line);
						}

						// remove stale albums from the albumlist if they exist
						$staleAlbums = array_diff($albumList, $directories);
						if (count($staleAlbums) > 0) {
							$albumIndex = array_flip($albumList);
							foreach ($staleAlbums as $curAlbum) {
								unset($albumList[$albumIndex[$curAlbum]]);
							}
							$rebuildAlbumlist = TRUE;
						} 

						// add new albums to the data file
						$newAlbums = array_diff($directories, $albumList);
						if (count($newAlbums) > 0) {
							foreach ($newAlbums as $curAlbum) {
								$albumList[] = $curAlbum;
							}
							$rebuildAlbumlist = TRUE;
						}	

						// rebuild if there were any stale or new albums
						if (isset($rebuildAlbumlist)) {
							// BUG! YOU MAY NEED TO CREATE THE DATA FOLDER!!! 
							$handle = fopen(FF_PHOTODIR.FF_THUMBDIR."_albums.txt", "w+");
							foreach ($albumList as $line) {
								fwrite($handle, $line."\n");
							}
						}
					} else {
						//this will create the index data file
						$handle = fopen(FF_PHOTODIR.FF_THUMBDIR."_albums.txt", "w+");
						foreach ($directories as $line) {
							fwrite($handle, $line."\n");
						}			
					}
					
					$directories = $albumList;
					
				} else if (FF_REVERSEINDEX) {
					rsort($directories, SORT_STRING);
				} else {
					sort($directories, SORT_STRING);
				}
				
				// make an album out of each directory!
				foreach ($directories as $directory) {
					$album = new album($directory);
					$album_array[] = $album;
				}
			}
		}
		//DEBUG
		//print_debug($album_array);
		
		$this->album_array = $album_array;
	}
}


/*
	TODO:
		make a special incoming "albumPath" which is the index identifier "_index" -- this should cause the album constructor to 
		behave in some of the same ways as the as the index class, maybe use the alternate template or do additional recursion?
		
		remove the index class!
		
*/
class album {
	// album vars
	var $name;				// the html/xml valid name of the album
	var $id;				// the id of the album, url ready
	var $dir;				// the directory of the album
	var $breadcrumb; 		// the breadcrumb TRAIL!
	
	// album and photo arrays
	var $album_array;		// an array of album arrays which contains: name, id, thumbsrc
	var $photo_array;		// an array of photo arrays which contains: index, name, thumb_file, thumb_url, photo_file, photo_url
	var $movie_array;		// an array of movie arrays... for now
		
	// album constructor
	function album($albumPath) {
	
		// create the parent album array
		$albumPath_array = explode("/", $albumPath);
		
		$name = array_pop($albumPath_array);

		if ( preg_match('/^#[0-9]*_(.*)/', $name, $matches) ) {
			$name = $matches[1];
		}

		$this->name = htmlentities($name, ENT_COMPAT, 'UTF-8');
		$this->id = rawurlencode($albumPath);
		$this->dir = FF_PHOTODIR.$albumPath."/";
		
		// create the breadcrumb 2d array
		$parentAlbum = "";
		foreach ($albumPath_array as $albumName) {
			$this->breadcrumb[] = array("name" => htmlentities($albumName, ENT_COMPAT, 'UTF-8'),"id" => $parentAlbum.$albumName);
			$parentAlbum = $parentAlbum.$albumName."%2F";
		}
		
		// the harder stuff - find the sub albums
		if ($dir_handle = @opendir($this->dir)) {
			// go through and get all the files that are really directories (and don't start with ".")
			while ($file = readdir($dir_handle)) { 
				// make sure it's not a hidden file
				if (strpos($file, ".") !== 0) {
					// check to see if it's a directory (and not the thumbdir) or a file
					if (is_dir($this->dir.$file) && $file != current(split("/",FF_THUMBDIR))) {
						$subalbumDirs[] = $file;
					} else if (is_file($this->dir.$file)) {	// if it's a real file
					
						if (!is_file($this->dir.FF_THUMBDIR.$file)) {
						// make sure there's a thumb for this file
							if (preg_match('/\.jpg$/', $file)) {
							// if it's a jpg add it to the todo list
								$makeThumbsArray[] = $file;
							}
						}
						$photoFiles[] = $file;
					}						
				}
			}
			closedir($dir_handle);
		}
		
		if (isset($makeThumbsArray)) {
			//time to make the donuts
			$this->thumbnailer($this->dir,$makeThumbsArray);
		}
		
		// DEBUG
		//print_debug($subalbumDirs);
		
		// sort the list of directories and make a new array with names, urls, and a thumb	
		if (isset($subalbumDirs)) {
		
			if (FF_REVERSEINDEX) {
				rsort($subalbumDirs, SORT_STRING);
			} else {
				sort($subalbumDirs, SORT_STRING);
			}

			foreach ($subalbumDirs as $albumName) {
				// clear the array
				unset ($albumThumb);
				unset ($thumb_array);
				unset ($makeThumbsArray);
				
				$albumPath = $this->dir.$albumName."/";
				
				// go through all the files in the album
				if ($dir_handle = @opendir($albumPath)) {
					
					// look for a custom thumb
					if (is_file($albumPath.FF_THUMBDIR."album.jpg")) {
						$albumThumb = $albumPath.FF_THUMBDIR."album.jpg";
					}
					
					// go through and look for files and thumbs
					while ($file = readdir($dir_handle)) {
				
						// if there's a non-hidden file
						if (is_file($albumPath.$file) && strpos($file, ".") !== 0) {
							
							// check if there is a corrisponding thumbnail file
							if (is_file($albumPath.FF_THUMBDIR.$file)) {
								// if there isn't a custom thumb, add this thumb to the array for random picking
								if (!isset($albumThumb)) {
									$thumb_array[] = $albumPath.FF_THUMBDIR.$file;
								}
							} else {
								// there wasn't a corresponding thumbnail
								$makeThumbsArray[] = $file;
								$thumb_array[] = $albumPath.FF_THUMBDIR.$file;
							}
						}
					}
					closedir($dir_handle);
				}
				
				if (isset($makeThumbsArray)) {
					//time to make the donuts
					$this->thumbnailer($albumPath,$makeThumbsArray);
				}
				
				if (!isset($albumThumb) && isset($thumb_array)) {
					$albumThumb = $this->pickThumb($thumb_array);
				} else if (!isset($albumThumb)) {
					$albumThumb = FF_IMAGESDIR.FF_EMPTYIMG;
				}
				
				// new code that properly encodes the path for the img src attribute
				$albumThumbSrcParts = explode('/', $albumThumb);
				for ($i = 0; $i <= count($albumThumbSrcParts)-1; $i++) {
					$albumThumbSrcParts[$i] = rawurlencode($albumThumbSrcParts[$i]);
				}
				$albumThumbSrc = implode('/',$albumThumbSrcParts);
				
				$this->album_array[] = array(
					"name"=>htmlentities($albumName, ENT_COMPAT, 'UTF-8'),
					"id"=>rawurlencode($albumName),
					"thumbsrc"=>htmlentities($albumThumbSrc, ENT_COMPAT, 'UTF-8')
				);
			}
		}
				
		//DEBUG
		print_debug($this->album_array);		
		
		// sort the list of photos and make a new array with names and thumb urls	
		if (isset($photoFiles)) {
			natcasesort($photoFiles);
			
			//create an indexer
			$i=1;
			
			foreach ($photoFiles as $file) {
				$fileParts = explode('.', $file);
				$fileExt = array_pop($fileParts);

				switch ($fileExt) {
				case 'jpg':
				case 'gif':
				case 'png':
				   $fileType = 'image';
				   break;
				case 'mov':
				case 'mp4':
				   $fileType = 'movie';
				   break;
				}
				
				$this->photo_array[] = array(
					"index"=>$i,
					"type"=>$fileType,
					"name"=>current(split("\.jpg",$file)),
					"thumb_file"=>FF_THUMBDIR.$file,
					"thumb_url"=>FF_THUMBDIR.rawurlencode($file),
					"photo_file"=>$file,
					"photo_url"=>rawurlencode($file),
				);
				// increment the indexer
				$i++;
			}
		}
			
		//DEBUG
		//print_debug($this->photo_array);
			
	} // end of constructor
	
	function thumbnailer($albumDir,$fileArray) {
		// this might take a long time!
		//set_time_limit(0);
	
		// make sure there's a thumbnail directory, if not then make it.
		if (!is_dir($albumDir.FF_THUMBDIR)) {
			mkdir($albumDir.FF_THUMBDIR, 0750);
			//print("Made \"".$albumDir.FF_THUMBDIR."\" Directory<br>"); 
		}
		// go through each file in the array and thumbnail 'em. 
		for ($i=0; $i < count($fileArray); $i++) {
			
			// DEBUG
			//print("working on: ".$albumDir.$fileArray[$i]."<br>");
	
			$photoImage = imagecreatefromjpeg($albumDir.$fileArray[$i]); 
			$imagedata = getimagesize($albumDir.$fileArray[$i]); 
			
			$sourceSide = min($imagedata[0], $imagedata[1]) * FF_THUMBSCALE;
			$sourceX = ($imagedata[0] - $sourceSide)/2;
			$sourceY = ($imagedata[1] - $sourceSide)/2;
			
			/*  This figures out if it's landscape or portrate and changes scale factors accordingly
		
			if ($imagedata[1] > $imagedata[0]) {
				// portrait (height is greater than width)
				$scaleFactor = $thumbSize / $imagedata[1];
				$w = $imagedata[0] * $scaleFactor;
				$h = $thumbSize;
			} else {
				// landscape (width is greater than height)
				$scaleFactor = $thumbSize / $imagedata[0];
				$w = $thumbSize;
				$h = $imagedata[1] * $scaleFactor;
			}
			
			$imageNew = imagecreatetruecolor($w, $h);
			imagecopyresampled($imageNew, $image, 0, 0, 0, 0, $w, $h, $imagedata[0], $imagedata[1]);
			*/
		
			// imagecopyresampled (resource dst_im, resource src_im, int dstX, int dstY, int srcX, int srcY, int dstW, int dstH, int srcW, int srcH)
		
			$thumb = imagecreatetruecolor(FF_THUMBSIZE, FF_THUMBSIZE);
			imagecopyresampled($thumb, $photoImage, 0, 0, $sourceX, $sourceY, FF_THUMBSIZE, FF_THUMBSIZE, $sourceSide, $sourceSide);
	
			imagejpeg($thumb, $albumDir.FF_THUMBDIR.$fileArray[$i], FF_THUMBQUALITY);
			
			// DEBUG
			//print("thumb created: ".$albumDir.FF_THUMBDIR.$fileArray[$i]."<br>");
		}
	}
	
	function pickThumb($thumb_array) {		
		$randomThumb = $thumb_array[rand(0, count($thumb_array) - 1)];
		$albumThumb = $randomThumb;
		return $albumThumb;
	}	
}

?>