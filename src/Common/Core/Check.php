<?php

namespace Common\Core;

use Common\Core\Init;
use Common\CommonAbstract;

class Check
{
    public static $classMap = [];

    /*
     * 启动
     *
     * @return
     */
    static public function run()
    {
        #内容,文件名
        Log::init();
        $route = Init::route();
        //Log::log($_SERVER, 'server');
        #自动执行到位到方法
        $ctrlClass = $route['ctrl'];
        if (is_array($ctrlClass)) {
            $file = self::ctrlToStr($ctrlClass);
            $class = self::ctrlToStr($ctrlClass, 'class');
        }
        $action = $route['action'];
        $ctrlFile = CHECKS .'/'. $file. '.php';
        if (is_file($ctrlFile)) {
            include $ctrlFile;
            $ctrl = new $class();
            $ctrl->$action();
        } else {
            throw new \Exception ('没有可执行的方法');
        }
    }

    /*
     * 自动加载类
     *
     * @return mix
     */
    static public function load($class)
    {
        #自动加载类
        if (isset($classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\', '/', $class);
            if (is_file(CHECKS .'/'. $class.'.php')) {
                include CHECKS .'/'. $class.'.php';
                self::$classMap[$class] = $class;
            } else {
                return false;
            }
        }
    }

    /*
     * 如果多级目录,则将数组转化为字符串
     *
     * @return str
     */
    static protected function ctrlToStr($arr, $type = 'file')
    {
        $str = '';
        if (is_array($arr) && $type == 'file') {
            foreach ($arr as $key => $val) {
                $str = $str . $val . '/';
            }
            $str = trim($str, '/');
        } elseif (is_array($arr) && $type == 'class') {
            foreach ($arr as $key => $val) {
                $str = $str . $val . '\\';
            }
            $str = trim($str, '\\');
        } else {
            throw new \Exception ('没有对应的类');
        }
        return $str;
    }
}
