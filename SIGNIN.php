<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/8/8
 * Time: 21:16
 *
 * 这里是登录处理脚本
 */

$data = $_GET["foo"];

$arr_str = array(
    "returncategory" => 0,
    "data" => array(
        "newslist" => array(
                "title" => "标题",
                "image" => "http://192.168.1.8.8080/2014010501015450.gif",
                "source" => "我的博客",
                "commentcount" => 120,
                "newsid" => 10
        ),
        "totalnum" => 10
    ),
);

echo(json_encode($arr_str));
?>