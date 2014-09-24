
function checkKey(albumID, firstPhoto, lastPhoto, prevPhoto, nextPhoto) {
	
	// left arrow
	if (event.keyCode == 37) {
		window.location='photo.php?album='+albumID+'&photo='+prevPhoto;
		return true;
	}

	// up arrow
	if (event.keyCode == 38) {
		window.location='photo.php?album='+albumID+'&photo='+firstPhoto;
		return true;
	}
	
	// right arrow
	if (event.keyCode == 39) {
		window.location='photo.php?album='+albumID+'&photo='+nextPhoto;
		return true;
	}
	
	// down arrow
	if (event.keyCode == 40) {
		window.location='photo.php?album='+albumID+'&photo='+lastPhoto;
		return true;
	}
	
	return(false);
}

function preloader(imageURL) {
	//alert(imageURL);
	if (document.images) {
		preload_image = new Image(16,16); 
		preload_image.src = imageURL; 
		return(true);
	}
	return(false);
}

function resizeImage() {
	var window_height = window.innerHeight
	var window_width  = window.innerWidth
	var image_width   = document.getElementById('photo').width
	var image_height  = document.getElementById('photo').height
	var height_ratio  = image_height / window_height
	var width_ratio   = image_width / window_width
	if (height_ratio > width_ratio) {
		document.getElementById('photo').style.width  = "auto"
		document.getElementById('photo').style.height = "90%"
	} else {
		document.getElementById('photo').style.width  = "100%"
		document.getElementById('photo').style.height = "auto"
	}
}

function hideAddressBar() {
	window.scrollTo(0,1);
}