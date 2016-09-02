<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/9/2
 * Time: 12:16
 */

$to = "liujiachengzhenniu@qq.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "liujiachengzhenniu@qq.com";
$headers = "From: $from";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";


$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//文件被打开为写入（w）或增加（a）。
$txt = "Bill Gates\n";
fwrite($myfile, $txt);
$txt = "Steve Jobs\n";
fwrite($myfile, $txt);
fclose($myfile);

?>