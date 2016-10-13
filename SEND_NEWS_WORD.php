<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/9/6
 * Time: 15:43
 * 用于发新动态的文字处理工作
 *
 * 获取到的是:
 *          用户的 id、
 *          一段文字(文字需要在 ios 端校验文字数目)、
 *          发送的设备、
 *
 *      查询并且 生成唯一的 newsid,
 *      发送者的 userid
 *      记录当时的时间 newstime
 *      文字 detail
 *      评论数目 (设置为 0 )
 *      赞的数目 (设置为 0 )
 *      图片数目
 *      设备名称
 *
 * 消息发送者 用 POST 方法
 *  SEND_NEWS_WORD.php
 */

/*
            "senderid":parameters.senderid,
            "words":parameters.words,
            "device":parameters.device,
            "photonumber":parameters.photonumber,
            "photo":parameters.photo
*/
header('Content-type: text/json; charset=UTF-8');
header("Content-type: image/png");

$senderid = $_POST["senderid"];
$words    = $_POST["words"];
$device   = $_POST["device"];
$photonumber = $_POST["photonumber"];
$photo   = $_POST["photo"];

//整个News 的ID【包括 newsid photoname——序号——m/s】

//存储图片们 并生成多分辨率图片

    $id = md5(uniqid(rand()));
    //解码
    $img = base64_decode($photo);
    //路径
    $path_n = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$id.".png";
    //存储
    file_put_contents($path_n, $img);

    $path_s = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$id."_s.png";
    $path_m = "/Users/ThomasLiu/Documents/workspace/php/LALA/photo/MAIN_PHOTOS_FROM_USER/".$id."_m.png";
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

    //////

    //图片路径写入到数据库中
    }

//其他数据写入到数据库中
//链接数据库
//  `news_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
//  `user_id` int(11) DEFAULT NULL,
//  `news_time` datetime DEFAULT '9999-12-31 23:59:59',
//  `news_detail` varchar(255) DEFAULT NULL,
//  `news_pinglun_number` int(11) DEFAULT NULL,
//  `news_zan_number` int(11) DEFAULT NULL,
//  `news_photo_number` int(1) DEFAULT '0',
//  `news_device` varchar(25) DEFAULT NULL,
//$mysqli = new mysqli('127.0.0.1', 'root', 'liujiacheng', 'Link_Now');
//
//$sql = "insert into NEWS (news_id,user_id,news_time,news_pinglun_number,news_zan_number,news_photo_number,news_detail,news_device) VALUES ('" .$id. "','" .$senderid."','" .time()."','" ."0"."','" ."0"."','" .$photonumber."','" .$words."','" .$device. "')";
////
//mysqli_query($mysqli, $sql);
//
//mysqli_close($mysqli);








