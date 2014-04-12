<?php
 
function thumb($newwidth, $newheight, $filename)
{
	// Get new sizes
	list($width, $height) = @getimagesize($filename);

	if( $newwidth/$width > 1 ) $newwidth = $width;
	
	$newheight2 = (int)($height*($newwidth/$width));
	
	if( $newheight2 > $newheight )
	{
		$newwidth = (int)($width*($newheight/$height));
	}
	else
	{
		$newheight = $newheight2;
	}
	
	if( $newheight2 > $height )
	{
		$newheight = $height;
		$newwidth = $width;
	}
	// Load
	$thumb = @imagecreatetruecolor($newwidth, $newheight);
	
	$ext1 = explode( '.', $filename );
	$ext = strtolower($ext1[@count($ext1)-1]);
	
	if( $ext == 'jpg' )
		$source = @imagecreatefromjpeg($filename);
	elseif( $ext == 'png' )
		$source = @imagecreatefrompng($filename);
	elseif( $ext == 'gif' )
		$source = @imagecreatefromgif($filename);
	elseif( $ext == 'bmp' )
		$source = @imagecreatefromwbmp($filename);

	// Resize
	@imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	header('Content-Type: image/jpeg');
	// Output
	@imagejpeg($thumb);
	@imagedestroy($thumb);
}

$x = 1;
if(isset($_GET['m']))
	$x = (double)$_GET['m'];

thumb(150*$x, 83*$x, $_GET['img']);

?>