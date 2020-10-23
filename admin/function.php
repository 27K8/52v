<?php 
error_reporting(0);
$domain = gettopdomainhuo();
$real_domain = "baidu.com";

$client_check = $check_host . "?a=client_check&u=" . $_SERVER["HTTP_HOST"];
$check_message = $check_host . "?a=check_message&u=" . $_SERVER["HTTP_HOST"];
$check_info = file_get_contents($client_check);
$message = file_get_contents($check_message);
if( $check_info == "1" ) 
{
    echo "<font color=red>" . $message . "</font>";
    exit();
}

if( $check_info == "2" ) 
{
    echo "<font color=red>" . $message . "</font>";
    exit();
}

if( $check_info == "3" ) 
{
    echo "<font color=red>" . $message . "</font>";
    exit();
}



unset($domain);
header("Content-type: text/html; charset=utf-8");
error_reporting(0);
include("password.php");
$token = md5($admin_user . md5($admin_pwd) . "tyys");
function getTopDomainhuo()
{
    $host = $_SERVER["HTTP_HOST"];
    $matchstr = "[^\\.]+\\.(?:(" . $str . ")|\\w{2}|((" . $str . ")\\.\\w{2}))\$";
    if( preg_match("/" . $matchstr . "/ies", $host, $matchs) ) 
    {
        $domain = $matchs["0"];
    }
    else
    {
        $domain = $host;
    }

    return $domain;
}

function title($xzv_4)
{
    echo "<!--\n微宝影视系统 http://400rj.com\n购买源码联系QQ3213145200 可功能定制 \n-->   \n<!DOCTYPE html>\n<html lang=\"zh-cn\">\n<head>\n  <meta charset=\"utf-8\"/>\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n  <title>";
    echo $xzv_4;
    echo "-微宝影视管理中心</title>\n  <meta name=\"keywords\" content=\"微宝影视管理中心\" />\n  <meta name=\"description\" content=\"微宝影视管理中心\" />\n  <link href=\"//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\"/>\n  <script src=\"//cdn.bootcss.com/jquery/1.12.4/jquery.min.js\"></script>\n  <script src=\"//cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js\"></script>\n  <!--[if lt IE 9]>\n    <script src=\"http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js\"></script>\n    <script src=\"http://libs.useso.com/js/respond.js/1.4.2/respond.min.js\"></script>\n  <![endif]-->\n</head>\n";
}

function head($xzv_3)
{
    $xzv_9 = 0;
    while( $xzv_9 < 5 ) 
    {
        $xzv_10[$xzv_9] = "";
        $xzv_9++;
    }
    $xzv_10[$xzv_3] = " class=\"active\"";
    echo "<body>\n  <nav class=\"navbar navbar-fixed-top navbar-default\">\n    <div class=\"container\">\n      <div class=\"navbar-header\">\n        <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">\n          <span class=\"sr-only\">导航按钮</span>\n          <span class=\"icon-bar\"></span>\n          <span class=\"icon-bar\"></span>\n          <span class=\"icon-bar\"></span>\n        </button>\n        <a class=\"navbar-brand\" href=\"./\">后台管理</a>\n      </div><!-- /.navbar-header -->\n      <div id=\"navbar\" class=\"collapse navbar-collapse\">\n        <ul class=\"nav navbar-nav navbar-right\">\n          <li";
    echo $xzv_10[0];
    echo "><a href=\"./\"><span class=\"glyphicon glyphicon-user\"></span> 平台首页</a></li>\n\t\t  <li";
    echo $xzv_10[1];
    echo "><a href=\"./appset.php\"><span class=\"glyphicon glyphicon-cog\"></span> APP设置</a></li>\n\t\t  <li";
    echo $xzv_10[2];
    echo "><a href=\"./set.php\"><span class=\"glyphicon glyphicon-cog\"></span>首页配置</a></li>\n\t\t  <li";
    echo $xzv_10[3];
    echo ">\n                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\"><span class=\"glyphicon glyphicon-cog\"></span>网站配置<b class=\"caret\"></b></a>\n                <ul class=\"dropdown-menu\">\n                    <li><a href=\"set1.php\">公告&接口设置</a></li>\n\t\t\t\t\t<li><a href=\"set2.php\">网页设置</a></li>\n\t\t\t\t\t<li><a href=\"set3.php\">接口账号配置</a></li>\n                </ul>\n           </li>\t\t\t\n\t\t  <li ";
    echo $xzv_10[4];
    echo " ><a href=\"./about.php\"><span class=\"glyphicon glyphicon-tree-deciduous\"></span> 关于程序</a></li>\n          <li><a href=\"./login.php?logout\"><span class=\"glyphicon glyphicon-log-out\"></span> 退出登陆</a></li>\n        </ul>\n      </div><!-- /.navbar-collapse -->\n    </div><!-- /.container -->\n  </nav><!-- /.navbar -->\n ";
}

function footer()
{
    echo "  \n?    <hr/>\n    <footer class=\"container\">\n        <div style=\"float: left;\">\n        &copy; <a href=\"http://400rj.com\" title=\"微宝影视系统\" target=\"_blank\"微宝影视系统</a> 微宝影视系统\n        </div>\n        <div style=\"float: right;\">\n           <a href=\"http://400rj.com\" title=\"微宝影视\" target=\"_blank\">微宝影视</a>\n        </div>\n    </footer>\n";
}

function showmsg($xzv_1 = "未知的异常", $xzv_13 = 4, $xzv_8 = false)
{
    switch( $xzv_13 ) 
    {
        case 1:
            $xzv_2 = "success";
            break;
        case 2:
            $xzv_2 = "info";
            break;
        case 3:
            $xzv_2 = "warning";
            break;
        case 4:
            $xzv_2 = "danger";
            break;
    }
    echo "<div class=\"panel panel-" . $xzv_2 . "\">\n      <div class=\"panel-heading\">\n        <h3 class=\"panel-title\">提示信息</h3>\n        </div>\n        <div class=\"panel-body\">";
    echo $xzv_1;
    if( $xzv_8 ) 
    {
        echo "<hr/><a href=\"" . $xzv_8 . "\"><< 返回上一页</a>";
    }
    else
    {
        echo "<hr/><a href=\"javascript:history.back(-1)\"><< 返回上一页</a>";
    }

    echo "</div>\n    </div>";
}

function saveFile($xzv_5, $xzv_0)
{
    if( !$xzv_5 || !$xzv_0 ) 
    {
        return false;
    }

    if( makeDir(dirname($xzv_5)) ) 
    {
        if( $xzv_12 = fopen($xzv_5, "w") ) 
        {
            if( @fwrite($xzv_12, $xzv_0) ) 
            {
                fclose($xzv_12);
                return true;
            }

            fclose($xzv_12);
            return false;
        }

    }

    return false;
}

function makeDir($xzv_11, $xzv_6 = 511)
{
    if( !$xzv_11 ) 
    {
        return false;
    }

    if( !file_exists($xzv_11) ) 
    {
        return mkdir($xzv_11, $xzv_6, true);
    }

    return true;
}

function FileMSG($xzv_7)
{
    if( $xzv_7 ) 
    {
        return showmsg("修改成功！", 1);
    }

    return showmsg("修改失败！可能权限不足！请设置该文件为0777权限！", 3);
}


