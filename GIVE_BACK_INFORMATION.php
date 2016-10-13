
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
//$userid = $_POST["userid"];
$userid = 1;

//链接数据库
//$mysqli = new mysqli('localhost', 'root', 'liujiacheng', 'Link_Now');
$con = mysql_connect("localhost","root","liujiacheng");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
mysql_query($con,"SET NAMES utf8");//mysqli_编码模式

mysql_select_db("DATA", $con);
$rst_friends = mysql_query("select friend_id from FRIENDSHIP where user_id = ".$userid);
$num_friends = mysql_affected_rows($con);

$friends_ids =array($userid);

if ($num_friends != 0)
{
    while($row = mysql_fetch_array($rst_friends))
    {
        $friends_ids[count($friends_ids ++)] = $row["friend_id"];
    }
    mysql_free_result($rst_friends);
}
//以上代码查询所有获得的 id 的朋友 id

$Newsids = array();//

for($i = 0;$i < count($friends_ids); $i++){
    //$sql_news = "select news_id from NEWS where user_id = ".$friends_ids[$i];
    $rst_news = mysql_query("select news_id from NEWS where user_id = ".$friends_ids[$i]);
    $num_news = mysql_affected_rows($con);
    if ($num_news == 0) {  //没有找到News
        //print "no";
    }
    else {  //有News
        //print  "yes";
        while ($row = mysql_fetch_row($rst_news)) {
            //print $row[0]." ";
            $Newsids[count($Newsids ++)] = $row["news_id"];
        }
        mysql_free_result($rst_news);
    }

}
//print "<br>";

$arr_json = array();

for ($i = 0;$i < count($Newsids); $i++){
   // print $Newsids[$i]." ";

    //查出 时间
    $sql_news_time = "select news_time from NEWS where news_id = ".$Newsids[$i];
    $rst_news_time = mysql_query($sql_news_time);//
    while ($row = mysql_fetch_row($rst_news_time)) {
        //print $row[0]." ";
        $arr_json[$i]["newstime"] = $row["news_time"];
        //print "<br>";
    }
    mysql_free_result($rst_news_time);

    //查出 设备

    $sql_news_device = "select news_device from NEWS where news_id = ".$Newsids[$i];
    $rst_news_device = mysql_query($sql_news_device);
    while ($row = mysql_fetch_row($rst_news_device)) {
        //print $row[0]." ";
        $arr_json[$i]["device"] = $row["news_device"];
        //print "<br>";
    }
    mysql_free_result($rst_news_device);

    //查出用户id
    $sql_news_sender = "select user_id from NEWS where news_id = ".$Newsids[$i];
    $rst_news_sender = mysql_query($sql_news_sender);
    while ($row = mysql_fetch_row($rst_news_sender)) {
        $arr_json[$i]["senderid"] = $row["user_id"];
        //print $arr_json[$i]["senderid"]." ";
       // print "<br>";
        //用户名
        $sql_news_sender_name = "select user_name from USERS where user_id = ".$arr_json[$i]["senderid"];
        $rst_news_sender_name = mysql_query($sql_news_sender_name);
        while ($row2 = mysql_fetch_row($rst_news_sender_name)) {
           // print $row2[0] . " ";
            $arr_json[$i]["sendername"] = $row2["user_name"];
           // print "<br>";
        }
    }
    mysql_free_result($rst_news_sender_name);
    mysql_free_result($rst_news_sender);

    //查出图片path 其实就是名称
    $sql_news_photo = "select photo_path from PHOTO where news_id = ".$Newsids[$i];
    $rst_news_photo = mysql_query($sql_news_photo);
    $num_news_photo = 0;
   // print $num_news_photo."photo_number";
    while ($row = mysql_fetch_row($rst_news_photo)) {
        //print $row[0]." ";
        $arr_json[$i]["photo"][$num_news_photo ++] = $row["photo_path"];
        //print "<br>";
    }
    $arr_json[$i]["photonumer"] = $num_news_photo."";
    mysql_free_result($rst_news_photo);

    //查出文字内容 detail
    $sql_news_detail = "select news_detail from NEWS where news_id = ".$Newsids[$i];
    $rst_news_detail = mysql_query($sql_news_detail);
    while ($row = mysql_fetch_row($rst_news_detail)) {
        //print $row[0]." ";
        $arr_json[$i]["detail"] = $row["news_detail"];
        //print "<br>";
    }
    mysql_free_result($rst_news_detail);

    $arr_json[$i]["newsid"] = $Newsids[$i];
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

mysql_close($con);
