<?php
/**
 * Created by PhpStorm.png
 * User: ThomasLiu
 * Date: 16/9/4
 * Time: 16:54
 */
header('Content-type: text/json; charset=UTF-8');
header("Content-type: image/png");

$base64 = $_POST["file"]; // 得到参数
$img = base64_decode($base64); // 将格式为base64的字符串解码
$filename = md5(uniqid(rand()));
$path_n = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$filename.".png"; // 产生随机唯一的名字作为文件名
file_put_contents($path_n, $img); // 将图片保存到相应位置

$path_s = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$filename."_s.png";
$path_m = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$filename."_m.png";

//修改尺寸 至于各个函数是干嘛的，google一下吧
$imagedata = getimagesize($path_n);

$olgWidth = $imagedata[0];
$oldHeight = $imagedata[1];

//判断高度和宽度那个大
//还有一个比例问题

$ratio = $oldHeight / $olgWidth; // 高/宽

if($olgWidth > $oldHeight){
    //高度小
    $newHeight_s = 200;
    $newWidth_s = $newHeight_s / $ratio;

    $newHeight_m = 400;
    $newWidth_m = $newHeight_m / $ratio;
    //S
    //M
    $image = imagecreatefrompng($path_n);//----------

    $thumb_s = imagecreatetruecolor ($newWidth_s, $newHeight_s);//创建真彩图像资源
    $color_s = imagecolorAllocate($thumb_s,248,248,248);   //分配一个灰色
    imagefill($thumb_s,0,0,$color_s);
    imagecopyresized ($thumb_s, $image, 0, 0, 0, 0, $newWidth_s, $newHeight_s, $olgWidth, $oldHeight);//----------
    imagepng($thumb_s, $path_s);
    imagedestroy($thumb_s);

    $thumb_m = imagecreatetruecolor ($newWidth_m, $newHeight_m);//创建真彩图像资源
    $color_m = imagecolorAllocate($thumb_m,248,248,248);   //分配一个灰色
    imagefill($thumb_m,0,0,$color_m);                 // 从左上角开始填充灰色
    imagecopyresized ($thumb_m, $image, 0, 0, 0, 0, $newWidth_m, $newHeight_m, $olgWidth, $oldHeight);//----------
    imagepng($thumb_m, $path_m);
    imagedestroy($thumb_m);

    imagedestroy($image);//----------

} else {
    //宽度小
    $newWidth_s = 200;
    $newHeight_s = $newWidth_s * $ratio;

    $newWidth_m = 400;
    $newHeight_m = $newWidth_m * $ratio;
    //S
    //M
    $image = imagecreatefrompng($path_n);

    $thumb_s = imagecreatetruecolor ($newWidth_s, $newHeight_s);//创建真彩图像资源
    $color_s = imagecolorAllocate($thumb_s,248,248,248);   //分配一个灰色
    imagefill($thumb_s,0,0,$color_s);
    imagecopyresized ($thumb_s, $image, 0, 0, 0, 0, $newWidth_s, $newHeight_s, $olgWidth, $oldHeight);
    imagepng($thumb_s, $path_s);
    imagedestroy($thumb_s);

    $thumb_m = imagecreatetruecolor ($newWidth_m, $newHeight_m);//创建真彩图像资源
    $color_m = imagecolorAllocate($thumb_m,248,248,248);   //分配一个灰色
    imagefill($thumb_m,0,0,$color_m);                 // 从左上角开始填充灰色
    imagecopyresized ($thumb_m, $image, 0, 0, 0, 0, $newWidth_m, $newHeight_m, $olgWidth, $oldHeight);
    imagepng($thumb_m, $path_m);
    imagedestroy($thumb_m);

    imagedestroy($image);
}

//存储之后应该有多分辨率图片的转化存储->
?>