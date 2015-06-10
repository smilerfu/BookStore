<?php
// 通过GD库做验证码
require_once 'string.func.php';
// require_once '../include.php';
function verifyImage($type = 1, $length = 4, $pixelNum = 0, $lineNum = 0, $sess_name = "verify")
{
    // session_start();
    
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
        "SIMHEI.TTF",
        "SIMKAI.TTF"
    );
    
    // 产生图像中各个文本
    for ($i = 0; $i < $length; $i ++) {
        $size = mt_rand(14, 18);
        $angle = mt_rand(- 15, 15);
        $x = 5 + $i * $size;
        $y = mt_rand(20, 26);
        $fontfile = "../fonts/" . $fontfiles[mt_rand(0, count($fontfiles) - 1)];
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

