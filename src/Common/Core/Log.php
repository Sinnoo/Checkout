<?php

namespace Common\Core;
use Common\Core\Init;

class Log
{
    static $class;
    static public function init()
    {
        #参数名,文件
        $drive = Init::getConf('DRIVE', 'Log');
        $class = 'Common\Log\\'. $drive;
        self::$class = new $class;
    }

    /*
     * 日志内容和存放的文件
     *
     * @return bool
     */
    static public function log($data, $file = 'log')
    {
        self::$class->log($data, $file);
    }
}
