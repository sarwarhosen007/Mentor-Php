<?php 
function check_image($image){
     
    $target_dir = "image/";
	$target_file = $target_dir . basename($_FILES[$image]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	    $check = getimagesize($_FILES["$image"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        $message = "File is not an image.";
	        $uploadOk = 0;
	    }

	// Check if file already exists
	if (file_exists($target_file)) {
	    $message =  "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["$image"]["size"] > 500000) {
	    $message = "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    $message =  "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["$image"]["tmp_name"], $target_file)) {
	        $url = basename( $_FILES["$image"]["name"]);
	    } else {
	        $message =  "Sorry, there was an error uploading your file.";
	    }
	}

}

?>