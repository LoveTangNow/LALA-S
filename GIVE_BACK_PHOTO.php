
<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/8/21
 * Time: 09:06
 */

/**
 * 这个是用来刷新首页面的php脚本
 *
 ** 首先我们会从iOS客户端得到请求的 UserID
 * 根据得到的 UserID
 * 得到一组FriendsID
 * FriendsID 存放于 一个数组中
 *
 ** 按顺序找到所有FriendsID的NewsID
 *
 * 根据NewsID,查询发送时间
 * 根据NewsID,查询发送设备
 * 根据NewsID,计算照片数目,PhotoCount
 * 根据NewsID,查询照片路径,存储到Paths数组中
 *
 ** 最终返回15条数据:一条数据包括(
 * 1.这条数据的发送者;
 * 2.这条数据的发送时间;
 * 3.这条数据的发送设备;
 * 4.这条数据的主要文字内容;
 * 5.这条数据包含的照片数目,
 * 6.0~9个不等的照片路径)
 */



/**
 ** 首先我们会从iOS客户端得到请求的 UserID
 * 根据得到的 UserID
 * 得到一组FriendsID
 * FriendsID 存放于 一个数组中
 */
//$userid = $_GET["userid"];
$userid = 1;

//链接数据库
$mysqli = new mysqli('127.0.0.1', 'root', 'liujiacheng', 'Link_Now');
mysqli_query($mysqli,"SET NAMES utf8");//mysqli_编码模式

//查询
$sql_friends = "select friend_id from FRIENDSHIP where user_id = ".$userid;
$rst_friends = mysqli_query($mysqli, $sql_friends);
$num_friends = mysqli_affected_rows($mysqli);

$friends_ids =array($userid);

if ($num_friends == 0) {  //没有找到朋友
    //print "no";
}//
else {  //有朋友的
    //print  "yes";
    while ($row = mysqli_fetch_row($rst_friends)) {
        //print $row[0];
        $friends_ids[count($friends_ids ++)] = $row[0];
    }
    mysqli_free_result($rst_friends);
}

//print "<br>";


$Newsids = array();//

for($i = 0;$i < count($friends_ids); $i++){
    $sql_news = "select news_id from NEWS where user_id = ".$friends_ids[$i];
    $rst_news = mysqli_query($mysqli, $sql_news);
    $num_news = mysqli_affected_rows($mysqli);
    if ($num_news == 0) {  //没有找到News
        //print "no";
    }
    else {  //有News
        //print  "yes";
        while ($row = mysqli_fetch_row($rst_news)) {
            //print $row[0]." ";
            $Newsids[count($Newsids ++)] = $row[0];
        }
        mysqli_free_result($rst_news);
    }

}
//print "<br>";

$arr_json = array();

for ($i = 0;$i < count($Newsids); $i++){
   // print $Newsids[$i]." ";

    //查出 时间
    $sql_news_time = "select news_time from NEWS where news_id = ".$Newsids[$i];
    $rst_news_time = mysqli_query($mysqli, $sql_news_time);
    while ($row = mysqli_fetch_row($rst_news_time)) {
        //print $row[0]." ";
        $arr_json[$i]["newstime"] = $row[0];
        //print "<br>";
    }
    mysqli_free_result($rst_news_time);

    //查出 设备

    $sql_news_device = "select news_device from NEWS where news_id = ".$Newsids[$i];
    $rst_news_device = mysqli_query($mysqli, $sql_news_device);
    while ($row = mysqli_fetch_row($rst_news_device)) {
        //print $row[0]." ";
        $arr_json[$i]["device"] = $row[0];
        //print "<br>";
    }
    mysqli_free_result($rst_news_device);

    //查出用户id
    $sql_news_sender = "select user_id from NEWS where news_id = ".$Newsids[$i];
    $rst_news_sender = mysqli_query($mysqli, $sql_news_sender);
    while ($row = mysqli_fetch_row($rst_news_sender)) {
        $arr_json[$i]["senderid"] = $row[0];
        //print $arr_json[$i]["senderid"]." ";
       // print "<br>";
        //用户名
        $sql_news_sender_name = "select user_name from USERS where user_id = ".$arr_json[$i]["senderid"];
        $rst_news_sender_name = mysqli_query($mysqli, $sql_news_sender_name);
        while ($row2 = mysqli_fetch_row($rst_news_sender_name)) {
           // print $row2[0] . " ";
            $arr_json[$i]["sendername"] = $row2[0];
           // print "<br>";
        }
    }
    mysqli_free_result($rst_news_sender_name);

    //查出path 其实就是名称
    $sql_news_photo = "select photo_path from PHOTO where news_id = ".$Newsids[$i];
    $rst_news_photo = mysqli_query($mysqli, $sql_news_photo);
    $num_news_photo = 0;
   // print $num_news_photo."photo_number";
    while ($row = mysqli_fetch_row($rst_news_photo)) {
        //print $row[0]." ";
        $arr_json[$i]["photo"][$num_news_photo ++] = "TEST_PHOTOS/".$row[0];
        //print "<br>";
    }
    mysqli_free_result($rst_news_photo);

    //查出文字内容 detail
    $sql_news_detail = "select news_detail from NEWS where news_id = ".$Newsids[$i];
    $rst_news_detail = mysqli_query($mysqli, $sql_news_detail);
    while ($row = mysqli_fetch_row($rst_news_detail)) {
        //print $row[0]." ";
        $arr_json[$i]["detail"] = $row[0];
        //print "<br>";
    }
    mysqli_free_result($rst_news_detail);
}

echo (json_encode($arr_json));
/**
 ** 按顺序找到所有FriendsID的NewsID
 *
 * 根据NewsID,查询发送时间
 * 根据NewsID,查询发送设备
 * 根据NewsID,计算照片数目,PhotoCount
 * 根据NewsID,shender
 * 根据NewsID,查询照片路径,存储到Paths数组中
 */

mysqli_close($mysqli);
