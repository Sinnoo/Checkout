<?php

namespace Common;

/*
 * 获取url路径,不包含参数
 *
 * @date 24/07/17 14:07:18
 */

class UrlGet
{
    /*
     * 获取url路径
     *
     * @return str
     */
    public function getUrl()
    {
        $url = 'http';

        if ($_SERVER["HTTPS"] == 'on') {
            $url .= 's';
        }
        $url .= '://';
        $urlHost = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $urlHost = $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
        }

        $url .= $urlHost;
        $url = $this->checkUrl($url);
        return $url;
    }

    /*
     * 检测合法性
     *
     * @date 24/07/17 14:14:02
     */
    private function checkUrl($url)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == 'POST') {
            echo "请求方式无效,请使用GET方式!";
            exit;
        }
        return $url;
    }
}
