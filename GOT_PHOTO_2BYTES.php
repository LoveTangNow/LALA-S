<?php
/**
 * Created by PhpStorm.png
 * User: ThomasLiu
 * Date: 16/9/4
 * Time: 16:54
 */
header('Content-type: text/json; charset=UTF-8');

$base64 = $_GET["file"]; // 得到参数
$img = base64_decode($base64); // 将格式为base64的字符串解码
$filename = md5(uniqid(rand()));
$path = "/Users/ThomasLiu/Documents/workspace/php/LALA/MAIN_PHOTOS_FROM_USER/photo/".$filename.".png"; // 产生随机唯一的名字作为文件名
file_put_contents($path, $img); // 将图片保存到相应位置

//存储之后应该有多分辨率图片的转化存储->
?>