<?php
    ini_set('display_errors',1);            //错误信息
    ini_set('display_startup_errors',1);    //php启动错误信息
    error_reporting(-1);
    $id = isset($_GET['id']) ? $_GET['id'] : '-1';
    $ts = isset($_GET['ts']) ? $_GET['ts'] : '-1';

    if($id !== '-1'){
        $baseurl = 'https://millionscast.com/';

        $header = array(
                'Referer: https://stream.crichd.vip/'
            );
        $url = $baseurl.'crichdws.php?player=desktop&live='.$id;
        $res = get($url, $header, $e_url);
        
        $reg = "/return\(\[\"(.*?)\"\]/";
        preg_match($reg, $res, $arr);
        $str = str_replace("\/","/", str_replace("\",\"", "", $arr[1]));
        
        $header = array(
            'Referer: https://millionscast.com/'
        );

        $res = get($str, $header, $e_url);
        $baseurl = dirname($e_url);
        $reg = '/(.*\.ts)/i';
        preg_match_all($reg, $res, $arr);
        foreach ($arr[1] as $key => $value){
            $res = str_replace($value, 'crichd.php?ts='.strtr(base64_encode("$baseurl/$value"), '+/', '-_'), $res);
        }
        echo($res);

    }else if($ts !== '-1'){
        $header = array(
            'Referer: https://millionscast.com/'
        );
        $decoded_ts = base64_decode(strtr($ts, '-_', '+/'));
        $res = ts($decoded_ts, $header);
    }

    function get($url, $header, &$e_url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $e_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return $result;
    }

    function ts($url, $header){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        curl_close($ch);
    }
?>
