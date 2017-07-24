<?php

namespace Tension;

use Common\CommonAbstract;

class Test extends CommonAbstract
{
    public function check()
    {
        $params['count'] = 5;
        $url = 'http://www.runoob.com/php/func-date-microtime.html';//$this->url;
        if ($url == '' || $url == null) {
            echo 'URL不能为空!';
            exit;
        }
        $params = $this->formatParams($params);
        $res = $this->multiCurlTime($url, 0, $res, $params);
        var_dump($res);exit;
    }

    protected function multiCurlTime($url, $usleep, $res, $params)
    {
        $count = [];
        $handle = [];
        $running = 0;
        $mhCurl = curl_multi_init();
        for ($iNum = 0; $iNum < $params['count']; $iNum++) {
            $chCurl = curl_init();
            curl_setopt($chCurl, CURLOPT_URL, $url);
            curl_setopt($chCurl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($chCurl, CURLOPT_TIMEOUT, 30);
            curl_setopt($chCurl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
            curl_setopt($chCurl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($chCurl, CURLOPT_MAXREDIRS, 7);
            curl_multi_add_handle($mhCurl, $chCurl);
            $handle[$iNum++] = $chCurl;
        }

        do {
            curl_multi_exec($mhCurl, $running);
            if ($usleep > 0)
                usleep($usleep);
        } while ($running > 0);

        foreach($handle as $iNum => $chCurl) {
            $content  = curl_multi_getcontent($chCurl);
            $count[$iNum] = (curl_errno($chCurl) == 0) ? $content : false;
        }

        foreach($handle as $chCurl) {
            curl_multi_remove_handle($mhCurl, $chCurl);
        }
        curl_multi_close($mhCurl);
        return $count;
    }
}
