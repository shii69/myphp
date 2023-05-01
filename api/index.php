<?php
date_default_timezone_set("亚洲/上海");
$ channel = empty( $ _GET [ 'id' ]) ? " cctv16hd4k/15000000 ": trim( $ _GET [ 'id' ]);
$ array = explode(" / ", $ channel );
$ stream = " http://lnbuott-v5-live.bestvcdn.com.cn/live/program/live/ { $ array [ 0 ]} / { $ array [ 1 ]} / ";
$时间戳= substr(时间(), 0 , 9 ) - 7 ;
$当前= " #EXTM3U "。"\r\n";
$当前.= " #EXT-X-VERSION:3 " 。"\r\n";
$ current .= " #EXT-X-TARGETDURATION:3 " . "\r\n";
$ current .= " #EXT-X-MEDIA-SEQUENCE: { $ timestamp }" 。"\r\n";
对于 ( $ i = 0 ; $ i < 3 ; $ i ++) {
    $时间匹配= $时间戳。'0' ;
    $ timefirst = date( 'YmdH' , $ timematch );
    $当前.= " #EXTINF:3, " . "\r\n";
    $当前.= $流. $时间优先。“ / ”。$时间戳。“ .ts ”。"\r\n";
    $时间戳= $时间戳+ 1 ;
}
header(" Content-Disposition: attachment; filename=playlist.m3u8 ");
回声 $当前;
