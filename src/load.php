<?php
include "Config/config.php";
include CORE. '/Check.php';
spl_autoload_register('Common\Core\Check::load');
Common\Core\Check::run();
?>
