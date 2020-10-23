<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR | E_WARNING | E_PARSE); //关闭错误报告 error_reporting(0);
session_start();
date_default_timezone_set('PRC');

define('tyys','tysoft');
define('ROOT', dirname(__FILE__).'/');

if(is_file(ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(ROOT.'360safe/360webscan.php');
}

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';

if(!file_exists( ROOT.'install/install.lock')){
   header('Content-type:text/html;charset=utf-8');
   exit('你还没安装！<a href="install/">点此安装</a>');
}
/*
require ROOT.'config.php';
if(!isset($port))$port='3306';
*/
?>
