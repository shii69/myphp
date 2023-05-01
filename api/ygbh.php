<?php

function ygbh($requesturl)
{
    $header = array(
        'upgrade-insecure-requests: 1',
        'user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/107.0.0.0 Safari/537.36',
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $requesturl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    $content = curl_exec($ch);
    curl_close($ch);
    return $content;
}

$apires = ygbh('https://jihulab.com/ygbh1/box/-/raw/main/%E6%9C%88%E5%85%89%E5%AE%9D%E7%9B%92');
$reg = "/proxy:\/\/do=live&type=txt&ext=(.*)?\"/i";
preg_match($reg, $apires, $zburl);
$content = ygbh(base64_decode($zburl[1]));
header("Content-Disposition: attachment; filename=TG@feiyangdigital.txt");
echo '🐑4K测试频道,#genre#
4K60PSDR-H264-AAC测试,http://159.75.85.63:5680/d/ad/h264/playad.m3u8
4K60PHLG-HEVC-EAC3测试,http://159.75.85.63:5680/d/ad/playad.m3u8' . PHP_EOL;
echo $content;