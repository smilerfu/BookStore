<?php
require_once '../lib/string.func.php';
/*
$filename = "uploads/big.jpg";
$src_image = imagecreatefromjpeg($filename);
list($src_w, $src_h) = getimagesize($filename);
$scale = 0.5;
$dst_w = ceil($src_w * $scale);
$dst_h = ceil($src_h * $scale);

$dst_image = imagecreatetruecolor($dst_w, $dst_h);
imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

header("content-type:image/jpeg");
imagejpeg($dst_image, "uploads/small.jpg");
imagedestroy($src_image);
imagedestroy($dst_image);
*/

/*
$filename = "uploads/big.jpg";
list($src_w, $src_h, $imagetype) = getimagesize($filename);
$mime = image_type_to_mime_type($imagetype);
//echo $mime; //:image/jpeg

$createFun = str_replace("/", "createfrom", $mime);
$outFun = str_replace("/", null, $mime);

$src_image = $createFun($filename);
$dst_50_image = imagecreatetruecolor(50, 50);
// $dst_220_image = imagecreatetruecolor(220, 220);
// $dst_350_image = imagecreatetruecolor(350, 350);
// $dst_800_image = imagecreatetruecolor(800, 800);
imagecopyresampled($dst_50_image, $src_image, 0, 0, 0, 0, 50, 50, $src_w, $src_h);
$outFun($dst_50_image, "uploads/small_50.jpg");
imagedestroy($src_image);
imagedestroy($dst_50_image);
*/

function thumb($filename, $dst_w=null, $dst_h=null, $scale = 1.0, $destination = null, $isReservedSource=false)
{
	
	list($src_w, $src_h, $imagetype) = getimagesize($filename);
	if (is_null($dst_w) || is_null($dst_h))
	{
		$dst_w = $src_w * $scale;
		$dst_h = $src_h * $scale;
	}
	$dst_w = ceil($dst_w);
	$dst_h = ceil($dst_h);
	$mime = image_type_to_mime_type($imagetype);
	$createFun = str_replace("/", "createfrom", $mime);
	$outFun = str_replace("/", "", $mime);
	
	$src_image = $createFun($filename);
	$dst_image = imagecreatetruecolor($dst_w, $dst_h);
	
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, 50, 50, $src_w, $src_h);
	$dstFileName = is_null($destination) ? getUniName().".".getExt($filename):$destination;
	
	#echo $destination;
	$outFun($dst_image, "uploads/aaa.jpg");
	
	imagedestroy($src_image);
	imagedestroy($dst_image);
	
	if(!$isReservedSource) //不保留原文件
	{
		unlink($filename);
	}
	
	return $dstFileName;
}


