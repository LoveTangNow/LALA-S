<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/8/7
 * Time: 19:40
 *
 * 这里是注册处理脚本
 */
//$userid = $_GET["userid"];

$userid = $_GET["usernameinzc"];
$userpas = $_GET["userpasswordzc"];

//链接数据库
$mysqli = new mysqli('127.0.0.1', '', '', 'test');

//查询
$sql = "select userpassword from users where userid = ".$userid;

$rst2 = mysqli_query($mysqli, $sql);

$num = mysqli_affected_rows($mysqli);

if ($num == 0)
{
    //没有的话,返回"是的",要注册了哦~
    $sql2 = "insert into users (userid,userpassword) VALUES ('".$userid."','".$userpas."')";
    mysqli_query($mysqli, $sql2);
    print "yes";
}
else
{
    print  "no";
}

mysqli_free_result($rst2);
mysqli_close($mysqli);