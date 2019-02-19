<?php

thumbnailImage ($_GET['path'], $_GET['file']);// run the function below with the REST values


/*
This function generates the image files if they have not already been made 
and returns the file to the ImageSelectorMagick.php page.
This is run for each image found but doe not overwrite images already found
*/
function thumbnailImage ($dir_path, $file){


	//$dir_path = ('images/'.$dir_path);
//Add directories unless they already exist

cho "<script>console.log( 'Debug Objects: " . $dir_path. $file . "' );</script>";

    if (!is_dir($dir_path.'/default/')) {
        mkdir($dir_path.'/default/',0777);//Directory made with full read write execute permissions
    }
    if (!is_dir($dir_path.'/thumbnail/')) {
        mkdir($dir_path.'/thumbnail/',0777);
    }

	//set the thumbnail and default directory variables
    $thumb=$dir_path.'/thumbnail/'; 
    $default=$dir_path.'/default/'; 

	//split out the filename for image modifications
    $extension = strtolower(pathinfo($dir_path.'/'.$file,PATHINFO_EXTENSION));
    $imageName = strtolower(pathinfo($dir_path.'/'.$file,PATHINFO_BASENAME));
    $DisplayName = strtolower(pathinfo($dir_path.'/'.$file,PATHINFO_FILENAME));
	


    
    //if the file has not already been seen then make a thumbnail and save the default image as a web friendly jpeg so that it can be seen in all browsers
    if(! file_exists($thumb.$DisplayName.'.jpeg')){
	//set the size of the thumbnail
    $thumbWidth = 600;
    $thumbHeight = 450;
		$image = new Imagick($dir_path.$file); //new imagick image file
		$d = $image->getImageGeometry(); //get the image size
		$defaultWidth = $d['width']; 
		$defaultHeight = $d['height']; 
	
		$scale_ratio = $defaultWidth / $defaultHeight; // find the ratio of the image
		
		//reduct the image by height or width, whichever is biggest
		if (($thumbWidth / $thumbHeight) > $scale_ratio) {
			   $thumbWidth = $thumbHeight * $scale_ratio;
		} else {
			   $thumbHeight = $thumbWidth / $scale_ratio;
		}


	//make a thumbnail image  and save it in the new thumbnail directory
	$NewImage = new Imagick($dir_path.$file);
	$NewImage->setCompression(Imagick::COMPRESSION_JPEG); 
	$NewImage->setCompressionQuality(60); 
	$NewImage->setImageFormat('jpeg');
	$NewImage->resizeImage(thumbWidth,thumbHeight,Imagick::FILTER_LANCZOS,1);
	$NewImage->writeImage($thumb.$DisplayName.".jpeg"); //testing
	
	//save the default image in the default folder as a JPEG so that it loads in Chrome/ Firefox
	$DefaultImage = new Imagick($dir_path.$file);
	$DefaultImage->setCompression(Imagick::COMPRESSION_JPEG); 
	$DefaultImage->setCompressionQuality(100); 
	$DefaultImage->setImageFormat('jpeg');
	$DefaultImage->writeImage($default.$DisplayName.".jpeg"); //testing
	


	//add the new extension to the image name
	$imageName = $DisplayName.'.jpeg';
	//display the image with the onclick event to access the default image through a function (modal)
	echo(  '<div class="container" ><img class="image" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')" src="'.$thumb.$imageName.'" alt="'.$imageName.'"><div class="middle" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')"><div class="text" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')">'.$DisplayName.'</div></div></div>');  

} else
	//use the previously made image name
{	$imageName = $DisplayName.'.jpeg';
	//display the image with the onclick event to access the default image through a function (modal)
	echo(  '<div class="container" ><img class="image" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')" src="'.$thumb.$imageName.'" alt="'.$imageName.'"><div class="middle" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')"><div class="text" onclick="openDefaultImage(\''.$default.$imageName.'\',\''.$DisplayName.'\')">'.$DisplayName.'</div></div></div>');  
	}
}
?>






