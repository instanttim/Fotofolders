<?php
require("fotofolders.php");
require(FEEDCREATOR_INCLUDE); 

$index = new index();

if (isset($index->album_array)) {
	foreach ($index->album_array as $album) {
		$index_array[] = array(
			"name"=>$album->name,
			"htmlname"=>$album->htmlname,
			"id"=>$album->id,
			"subalbum_array"=>$album->subalbum_array
		);
	}
}

$rss = new UniversalFeedCreator(); 
$rss->useCached(); 
$rss->title = FF_TITLE; 
$rss->description = FF_DESC; 
$rss->link = FF_URL; 
$rss->syndicationURL = FF_URL.end(explode("/",$_SERVER["PHP_SELF"]));

//$image = new FeedImage(); 
//$image->title = "dailyphp.net logo"; 
//$image->url = "http://www.dailyphp.net/images/logo.gif"; 
//$image->link = "http://www.dailyphp.net"; 
//$image->description = "Feed provided by dailyphp.net. Click to visit."; 
//$rss->image = $image; 

for ($i=0; $i < count($index_array); $i++) {
	// albums
    $item = new FeedItem();
    $item->title = $index_array[$i]['name'];
    $item->link = FF_URL."album.php?album=".$index_array[$i]['id'];
    $item->description = "There is a new album \"".$index_array[$i]['name']."\".";
    $rss->addItem($item);
	// subalbums	
	if ($index_array[$i]['subalbum_array']) {
		for ($j=0; $j < count($index_array[$i]['subalbum_array']); $j++) {
			$item = new FeedItem();
			$item->title = $index_array[$i]['name'].": ".$index_array[$i]['subalbum_array'][$j]['name'];
			$item->link = FF_URL."album.php?album=".$index_array[$i]['id']."/".$index_array[$i]['subalbum_array'][$j]['id'];
			$item->description = "There is a new album \"".$index_array[$i]['subalbum_array'][$j]['name']."\" in the \"".$index_array[$i]['name']."\" album.";
			$rss->addItem($item);
		}
	}
} 

// valid format strings are: RSS0.91, RSS1.0, RSS2.0, PIE0.1, MBOX, OPML
print($rss->saveFeed("RSS1.0", "index.rdf"));

?>
