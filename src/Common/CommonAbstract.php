<?php

namespace Common;

use Common\UrlGet;

/*
 * 一些公共信息
 *
 * @date 24/07/17 14:15:22
 */
class CommonAbstract
{
    protected $url;
    protected $params;

    public function __construct()
    {
        $this->url = $this->getUrl();
    }

    /*
     * 获取url地址
     *
     * @return str
     */
    protected function getUrl()
    {
        $urlGet = new UrlGet();
        return $urlGet->getUrl();
    }

    /*
     * 格式化参数
     *
     * @return array
     */
    protected function formatParams($params)
    {
        $list = [];
        if ($params['count'] && $params['count'] >= 1) {
            $list['count'] = (int)$params['count'];
        }

        return $params;
    }
}
