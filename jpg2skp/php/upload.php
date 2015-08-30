<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}

	$img_path='uploads/'.$_FILES['upl']['name'];
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $img_path)){
		resize_image();
		image_to_csv();
		exec_sketchup();
		echo '{"status":"success"}';
		exit;
	}
}

echo '{"status":"error"}';


function resize_image(){
	$img_path='uploads/'.$_FILES['upl']['name'];

	$percent = 0.5;

	// Content type
	header('Content-Type: image/jpeg');

	// Get new sizes
	list($width, $height) = getimagesize($img_path);
	$w=128;
	$newwidth = $w;
	$newheight = round($w*$height/$width);

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefromjpeg($img_path);

	// Resize
	imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	echo"here";
	// Output
	imagejpeg($thumb, $img_path);
}

function image_to_csv(){

	$img_path='uploads/'.$_FILES['upl']['name'];
	$file_path="images/jackie.txt";
	list($width, $height, $type, $attr) = getimagesize($img_path);

	$im = imagecreatefromjpeg($img_path);
	$file = $file_path;

	$stack = array();
	for($w=0;$w<$width;$w++){
		for($h=0;$h<$height;$h++){
			$rgb = imagecolorat($im, $w, $h);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$bw= round(0.3*$r+0.59*$g+0.11*$b);
			$s.=$bw;
			if($h<$height-1){
				$s.=",";
			}else{
				$s.="\n";
			}
		}
	}
	file_put_contents($file, $s);
}

function exec_sketchup(){
	 echo exec('/Applications/SketchUp\ 2015/SketchUp.app/Contents/MacOS/SketchUp -RubyStartup jpg2skp.rb') . "\n"; 
}
?>