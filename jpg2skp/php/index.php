<?php
$img_path="images/jackie_icon.jpg";
$img_path="images/jackie.txt";
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

?>
