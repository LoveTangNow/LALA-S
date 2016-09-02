<?php
/** php 接收流文件
 * @param  String  $file 接收后保存的文件名
 * @return boolean
 */

//$input = file_get_contents('php://input');
//file_put_contents($original, $input); //$original为服务器上的文件
//$_FILE['userfile']['name'];
//$_FILE['userfile']['type'];
//$_FILE['userfile']['size'];


$xmlstr= file_get_contents("php://input");
$img2 = base64_decode($xmlstr); //base64 图片数据流 并解码
print $img2;
// 生成的文件名
$file_dir  = "./photo/".time().".jpg";  //文件需上传路径
$res = file_put_contents($file_dir,$img2);  //上传图片 并返回结果

///////3333333333333333333
///////3333333333333333333

//$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
//文件被打开为写入（w）或增加（a）。
//fwrite($myfile, $xmlstr);
//fclose($myfile);

?>