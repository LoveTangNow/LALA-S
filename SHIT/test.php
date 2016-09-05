<?php
/**
 * Created by PhpStorm.
 * User: ThomasLiu
 * Date: 16/8/14
 * Time: 07:52
 */

$a = "";

//方法一date函数

echo date('y-m-d h:i:s',time());
print "<br>";

//方法二 time函数

$time = time();

echo date("y-m-d",$time);
print "<br>";

//方法四 strftime

echo strftime ("%hh%m %a %d %b" ,time());
print "<br>";

/*
 * 不可逆的加密函数为：md5()、crypt()
 * md5() 用来计算 MD5 哈稀。语法为：string md5(string str);
 * crypt() 将字符串用 UNIX 的标准加密 DES 模块加密。这是单向的加密函数，无法解密。欲比对字符串，将已加密的字符串的头二个字符放在 salt 的参数中，再比对加密后的字符串。
 * 语法为：string crypt(string str, string [salt]);
 *
 * 可逆转的加密为：base64_encode()、urlencode() 相对应的解密函数：base64_decode() 、urldecode()
 *  base64_encode()
 * 将字符串以 MIME BASE64 编码。此编码方式可以让中文字或者图片也能在网络上顺利传输。
 * 语法为string base64_encode(string data);
 *  它的解密函数为：string base64_decode(string encoded_data);将复回原样
 * urlencode() 将字符串以 URL 编码。例如空格就会变成加号。
 * 语法为：string urlencode(string str);
 * 它的解密函数为：string urldecode(string str); 将复回原样
 */

$str = "iOS Developer Tips encoded in Base64";
$encodestr = base64_encode($str);
print $encodestr;
print "<br>";
$uncodestr = base64_decode($encodestr);
print $uncodestr;
print "<br>";
print "<br>";

$str2 = "hello php!!";


$ll = sha1($str2);
print $ll;
print "<br>";
$lll = sha1($ll);
print $lll;
print "<br>";

$aa = OPENSSL_CIPHER_AES_256_CBC;
print $aa;



