<?php
error_reporting(0);
header('Content-Type:text/html;charset=UTF-8');
$id=$_GET['id'];

$ip = $_SERVER["REMOTE_ADDR"];
$time=date('Y-m-d H:i:s',time());
$content = "\r\n"."ip:".$ip." time:".$time."---".$id;
//定义文件存放的位置
$compile_dir = "C:/log/gudou.txt";
//下面就是写入的PHP代码了
$file = fopen($compile_dir,"a+");
fwrite($file,$content);
fclose($file);


$user='15314265055';
$ptoken='k/pg5QLOZT3baESG1QbqdQ==';
$pserialnumber='7d97ffeeea2f14d5';
$t=time();
$nonce=rand(100000,999999);
$str='sumasalt-app-portalpVW4U*FlS'.$t.$nonce.$user;
$hmac=substr(sha1($str),0,10);
$onlineip=$_SERVER['REMOTE_ADDR'];
$info='ptype=1&plocation=001&puser='.$user.'&ptoken='.$ptoken.'&pversion=030104&pserverAddress=portal.gcable.cn&pserialNumber='.$pserialnumber.'&pkv=1&ptn=Y29tLnN1bWF2aXNpb24uc2FucGluZy5ndWRvdQ&pappName=GoodTV&DRMtoken='.$ptoken.'&epgID=&authType=0&secondAuthid=&t='.$ptoken.'&pid=&cid=&u='.$user.'&p=8&l=001&d='.$pserialnumber.'&n='.$id.'&v=2&hmac='.$hmac.'&timestamp='.$t.'&nonce='.$nonce;
$url='http://portal.gcable.cn:8080/PortalServer-App/new/aaa_aut_aut002';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);       
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
curl_setopt($ch, CURLOPT_USERAGENT, "Apache-HttpClient/UNAVAILABLE (java 1.4)");
//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Host: portal.gcable.cn:8080', 'Connection: Keep-Alive','Accept-Encoding: gzip','Content-Length: 440')); 页头信息备用
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$onlineip, 'CLIENT-IP:'.$onlineip));
$res = curl_exec($ch);
curl_close($ch);
//preg_match('|aaa?(.*?)&ip|',$res, $tk);
//$live="http://gslb.gcable.cn:8070/live/".$id.".m3u8?".$tk[1];
$uas=parse_url($res);
parse_str($uas["query"]);
$token="?t=".$t."&u=".$u."&p=".$p."&pid=&cid=".$cid."&d=".$d."&sid=".$sid."&r=".$r."&e=".$e."&nc=".$nc."&a=".$a."&v=".$v;
$playurl = "http://gslb.gcable.cn:8070/live/".$id.".m3u8".$token;
//echo $playurl;


if($_GET["playseek"]){//时移，时间参数为年月日时分秒，例子：playseek=20200629193000-20200629204000
	$tms=explode("-",$_GET["playseek"]);//将时间参数的开始和结束分开
	$st=$tms[0];//开始时间
	$et=$tms[1];//结束时间

	$st=strtotime($tms[0]);
	$et=strtotime($tms[1]);

	$wasu=$playurl."&starttime=".$st."&endtime=".$et;
}
else{//直播

	$wasu=$playurl;

}

//header('location:'.urldecode($wasu));
header("location: $wasu");
exit;
?>