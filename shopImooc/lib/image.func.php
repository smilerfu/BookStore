<?php
// 通过GD库做验证码
require_once(dirname(__FILE__).'/string.func.php');
require_once(dirname(__FILE__).'/../lib/common.func.php');

function verifyImage($type = 1, $length = 4, $pixelNum = 0, $lineNum = 0, $sess_name = 'verify')
{   
	
	startSessionIfSOff();
    // 创建画布
    $width = 80;
    $height = 28;
    $image = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    
    // 用填充矩形填充画布
    imagefilledrectangle($image, 1, 1, $width - 2, $height - 2, $white);
    
    $chars = buildRandomString($type, $length);
    
    $_SESSION[$sess_name] = $chars;
    
    $fontfiles = array(
        "Abyssinica_SIL.ttf",
    );
    
    // 产生图像中各个文本
    for ($i = 0; $i < $length; $i ++) {
        $size = mt_rand(14, 18);
        $angle = mt_rand(- 15, 15);
        $x = 5 + $i * $size;
        $y = mt_rand(20, 26);
        $fontfile = "/var/www/html/BookStore/shopImooc/fonts/" . $fontfiles[mt_rand(0, count($fontfiles) - 1)];
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        $text = substr($chars, $i, 1);
        imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
    }
    
    // 画图像噪点
    for ($i = 0; $i < $pixelNum; $i ++) {
        $x = mt_rand(0, $width - 1);
        $y = mt_rand(0, $height - 1);
        $color = $black;
        imagesetpixel($image, $x, $y, $color);
    }
    
    // 画图像干扰线
    for ($i = 0; $i < $lineNum; $i ++) {
        $x1 = mt_rand(0, $width - 1);
        $y1 = mt_rand(0, $height - 1);
        $x2 = mt_rand(0, $width - 1);
        $y2 = mt_rand(0, $height - 1);
        $color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
        imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    
    // 显示图像
    header("content-type:image/gif");
    imagegif($image);
    imagedestroy($image);
}

//verifyImage();


/**
 * 
 * @param string $filename	要进行缩放的图片文件路径
 * @param int $dst_w		缩放后的文件宽
 * @param int $dst_h		缩放后的文件高
 * @param real $scale		缩放文件比例(在宽和高都设置成null的时候生效，否则不生效)
 * @param string $destination	保存缩放后的文件路径
 * @param string $isReservedSource	是否保留原图片文件(不保留会被删除)
 * @return string	返回生成的缩放图片文件名
 */
function thumb($filename, $destination = null, $dst_w=null, $dst_h=null, $scale = 1.0, $isReservedSource=true)
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
	$outFun($dst_image, $dstFileName);

	imagedestroy($src_image);
	imagedestroy($dst_image);

	if(!$isReservedSource) //不保留原文件
	{
		unlink($filename);
	}

	return $dstFileName;
}

