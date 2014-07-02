function popupWindow(albumID) {
	open('photo.php?album='+albumID+'&photo=1&popup','pp_photo','toolbar=no,location=no,directories=no,status=no,menubar=no,width=680,height=720,scrollbars=no,resizable=yes');
	return true;
}

function checkKey(albumID, firstPhoto, lastPhoto, prevPhoto, nextPhoto) {
	
	// left arrow
	if (event.keyCode == 37) {
		window.location='photo.php?album='+albumID+'&photo='+prevPhoto+'&popup';
		return true;
	}

	// up arrow
	if (event.keyCode == 38) {
		window.location='photo.php?album='+albumID+'&photo='+firstPhoto+'&popup';
		return true;
	}
	
	// right arrow
	if (event.keyCode == 39) {
		window.location='photo.php?album='+albumID+'&photo='+nextPhoto+'&popup';
		return true;
	}
	
	// down arrow
	if (event.keyCode == 40) {
		window.location='photo.php?album='+albumID+'&photo='+lastPhoto+'&popup';
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
