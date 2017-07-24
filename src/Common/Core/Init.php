<?php

namespace Common\Core;

class Init
{
    static public $conf = [];
    /*
     * 自动加载配置项
     *
     * @return mix
     */
    static public function getConf($name, $file)
    {
        #已经存在加载的配置项
        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        }
        $path = CHECKS. '/Common/Conf/' .$file. '.php';
        if (is_file($path)) {
            $conf = include $path;
            if (isset($conf[$name])) {
                self::$conf[$file] = $conf;
                return $conf[$name];
            } else {
                throw new \Exception ('没有该配置项');
            }
        } else {
            throw new \Exception ('没有该配置文件');
        }

    }

    /*
     * 动态加载所有配置项
     *
     * @file 配置项文件名
     * @return mix
     */
    static public function getAll($file)
    {
        #已经存在加载的配置项
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }
        $path = MINS. '/core/config/' .$file. '.php';
        if (is_file($path)) {
            $conf = include $path;
            if (isset($conf)) {
                self::$conf[$file] = $conf;
                return $conf;
            } else {
                throw new \Exception ('no config options');
            }
        } else {
            throw new \Exception ('no config files');
        }
    }

    /*
     * 路由
     *
     * @return mix
     */
    static public function route()
    {
        $ctrl = $action = '';
        $url = $_SERVER['REQUEST_URI'];
        $params = explode('&', $url);
        $url = explode('=', $params[0])[1];
        
        if (isset($url) && $url != null) {
            $patharr = explode('.', trim($url));
            if (count($patharr) >= 3) {
                //多级目录
                $ctrls = $patharr;
                unset($ctrls[count($patharr)-1]);
                $ctrl = $ctrls;
                $action = end($patharr);
            } else {
                //单层目录
                if (isset($patharr[0])) {
                    $ctrl = $patharr[0];
                }
                if (isset($patharr[1])) {
                    $action = $patharr[1];
                } else {
                }  
            }

            #get参数
            $count = count($params);
            $i = 1;
            while ($i < $count) {
                $para = explode('=', $params[$i]);
                if (isset($para[1]) && $para[1] != null) {
                    $_ET[$para[0]] = $para[1];
                }
                $i++;
            }
        } else {
            $ctrl = conf::get('CTRL', 'route');
            $action = conf::get('ACTION', 'route');;
        }

        return ['ctrl' => $ctrl, 'action' => $action];

    }
}
