<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8"/>

    <div class="library" id="header" style="position:absolute; top:0px; left:0px; height:10%; right:0px;overflow:hidden;"> 
    &nbsp Image library
	</div>
<style>
.library {
	color: #ffe4e1; 
	font-size: 72px; 
	font-family: 'Signika', sans-serif; 
	background: #6B5B95; 
}

</style>
</head>
<body style="height:100%; width:100%">

<div id="content" style="position:absolute; top:10%; bottom:5%; left:2%; right:0px; overflow:auto;"> 
    	
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="ModelImage">
  <div id="caption"></div>
</div>
    
<script>
var modal = document.getElementById('myModal');
function openDefaultImage ($image, $caption){ 
    
var img = document.getElementById($image);
var modalImg = document.getElementById("ModelImage");
var captionText = document.getElementById("caption");
    modal.style.display = "block";
    captionText.innerHTML = $caption;
    modalImg.src = $image;

var span = document.getElementsByClassName("close")[0];
span.onclick = function() {modal.style.display = "none";}
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
}

</script>
    
	
<style>
	  
body {
	margin: 25px;
}
.header {
	background: #6B5B95;
	color: 	#ffffff; 
	display: 	inline-block; 
	font-family: 'Lato', sans-serif; 
	font-size: 12px; 
	font-weight: bold; 
	line-height: 12px; 
	letter-spacing: 1px; margin: 0 0 30px;
	padding: 10px 15px 8px; 
	text-transform: uppercase;
}	  

.container {
    position: relative;

   display:inline;
    float:left;
    width:300px;
    height:200px;
  text-align: center;
    overflow: hidden;
}

.FolderHeader {
	color: 	#6B5B95;
    position: relative;
 display:inline;
    width:100%;
    height:100%;
    float:left;
 
  text-align: left;
}

.image {
    position: relative;
	display:block;
    object-fit: cover;
    width:100%;
    height:100%;
  transition: .5s ease;
  backface-visibility: hidden;
}

.middle {

   margin:0;
  transition: .5s ease;
  opacity: 0;
  position: relative;
  left: 50%;
  transform: translate(-50%, -100%);
  text-align: center;
	background: #6B5B95; 
}

.container:hover .image {
  opacity: 0.3;
}

.container:hover .middle {
  opacity: 1;
}

.text {

  color: #ffe4e1;
  font-size: 16px;
  padding: 16px 32px;
}
    
body {font-family: Arial, Helvetica, sans-serif;}

#myImg {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}



#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 900px;
}

/* Caption of Modal Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation */
.modal-content, #caption {    
    -webkit-animation-name: zoom;
    -webkit-animation-duration: 0.6s;
    animation-name: zoom;
    animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
    from {-webkit-transform:scale(0)} 
    to {-webkit-transform:scale(1)}
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}


} 
    
    
    
    
        
</style>
    

<?php

//Two variables are set to show where the image library is located and which extensions to allow
$dir_path = "images/";
$extensions_array = array('jpg', 'png','jpeg','gif','tif','pdf','psd');

/*This function sends a request to the php file to generate the thumbnail and the default images
This is run for each image that is found in the image library*/
function thumbnailImageGET ($dir_path, $file){

//********************RESET THIS***************************************************************************************************** 
$filename = $dir_path.$file;//sets the location of the php file 
//*********************************************************************************************************************************** 
$response = file_get_contents($filename);//shows the generated image
echo("<script>console.log('PHP: ".$filename."');</script>");//logs the location of the file
echo($response);//shows the image (clickable)
}

/*
This function recursively looks through the folders in the library to find images in folders and sub-folders
*/
function FindImages($dir_path,$extensions_array) {
if(is_dir($dir_path)){//If the directory is valid
    $files = scandir($dir_path);//Fill an array with the file name (contents) of the directory
}
    for($i = 0; $i < count($files); $i++)//for each file in the directory
    {
		//set the variables for the file and extension
        $file = $files[$i];
        $extension = pathinfo($file, PATHINFO_EXTENSION);
		
        if ($file!= '..' && $file!= '.'){//checks to see if the file is not hidden 

        if ($extension == null and isset($file))
        {
            //If the file is a folder, go into the folder and recur
            $sub_dir_path = $dir_path.$file.'/';
           
            
            if(substr($sub_dir_path, -8) === "default/" || substr($sub_dir_path, -10) === "thumbnail/" )//Ignore previously made default and thumbnail folders
            {//echo("This is the default/thumbnail folder so we don't look inside<br><br>");
            }
            else {
                echo('</div><div class="FolderHeader"><h1>'.$file.'</h1></div><div class="BigContainer">');
                FindImages($sub_dir_path,$extensions_array);
            }
        }
        else
        {
            //Check whether the file found is an image
            if(in_array($extension , $extensions_array))
            {//if an image is found, generate and display the thumbnails
            thumbnailImageGET($dir_path,$file);
            }
        }
    }}
}
echo ("<br><br><div class='BigContainer'><table>");
FindImages($dir_path,$extensions_array);//run the script and populate the page
echo ("</div><br><br></table>");
?>
    </div> 
</body>
</html>

    
    
    
    
    
    
    
    