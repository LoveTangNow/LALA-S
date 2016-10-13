<?php

header("Content-type: image/png");

//把图片移动到服务器制定路径
$path_n = '/Users/ThomasLiu/Documents/workspace/php/LALA/photo/TEST_PHOTOS/00002.png';
$path_m = '/Users/ThomasLiu/Documents/workspace/php/LALA/photo/TEST_PHOTOS/00002s.png';
$path_s = '/Users/ThomasLiu/Documents/workspace/php/LALA/photo/TEST_PHOTOS/00002m.png';
//修改尺寸 至于各个函数是干嘛的，google一下吧


$imagedata = getimagesize($path_n);

$olgWidth = $imagedata[0];
$oldHeight = $imagedata[1];

//判断高度和宽度那个大
//还有一个比例问题

$ratio = $oldHeight / $olgWidth; // 高/宽

    //高度小
    $newHeight_s = 200;
    $newWidth_s = $newHeight_s / $ratio;

    $newHeight_m = 400;
    $newWidth_m = $newHeight_m / $ratio;
    //S
    //M
    //持续检查文件是否存在

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


