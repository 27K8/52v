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
if( !defined("tyys") ) 
{
    exit( "非法访问" );
}

$aty = "";
$username = $_COOKIE["username"];
$HOST = $_SERVER["SERVER_NAME"];
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

function proving($xzv_28 = 0)
{
    global $username;
    global $HOST;
    $xzv_16 = $_COOKIE["tokens"];
    $xzv_32 = md5($username . "TYyingshi&http://" . $HOST . "/" . $xzv_16);
    if( $_COOKIE["skey"] != $xzv_32 ) 
    {
        location("请登录后访问！", "/user/login.php");
    }

    if( 0 < $xzv_28 ) 
    {
        ifvip($xzv_28);
    }

}

function ifvip($xzv_33)
{
    if( empty($_SESSION["vip"]) || empty($_SESSION["expir_time"]) ) 
    {
        location("正在前往用户中心刷新状态！如想返回当前页面请点击导航栏里的返回！", "/user/");
    }

    if( !($xzv_33 <= $_SESSION["vip"] && time() <= $_SESSION["expir_time"]) ) 
    {
        location("你的权限不够或已到期 请检查是否过期且满足VIP" . $xzv_33 . " 后重试！", "/user/");
    }

}

function location($xzv_15, $xzv_12)
{
    exit( "<script type=\"text/javascript\">alert(\"" . $xzv_15 . "！\");window.location.href=\"" . $xzv_12 . "\";</script>" );
}

function getwy($xzv_18, $xzv_19 = "", $xzv_13 = "")
{
    if( empty($xzv_19) ) 
    {
        $xzv_19 = get_client_ip();
    }

    $xzv_23 = curl_init();
    $xzv_17 = 30;
    curl_setopt($xzv_23, CURLOPT_URL, $xzv_18);
    curl_setopt($xzv_23, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($xzv_23, CURLOPT_CONNECTTIMEOUT, $xzv_17);
    curl_setopt($xzv_23, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($xzv_23, CURLOPT_ENCODING, "");
    curl_setopt($xzv_23, CURLOPT_REFERER, $xzv_18);
    curl_setopt($xzv_23, CURLOPT_HTTPHEADER, array( "X-FORWARDED-FOR:" . $xzv_19, "CLIENT-IP:" . $xzv_19 ));
    if( $xzv_13 ) 
    {
        curl_setopt($xzv_23, CURLOPT_POST, 1);
        curl_setopt($xzv_23, CURLOPT_POSTFIELDS, $xzv_13);
    }

    if( preg_match("/(iPhone|iPad|iPod|Linux|Android)/i", strtoupper($_SERVER["HTTP_USER_AGENT"])) ) 
    {
        $xzv_14 = "Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Mobile Safari/537.36";
    }
    else
    {
        $xzv_14 = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.101 Safari/537.36";
    }

    curl_setopt($xzv_23, CURLOPT_USERAGENT, $xzv_14);
    curl_setopt($xzv_23, CURLOPT_ENCODING, "gzip");
    curl_setopt($xzv_23, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($xzv_23, CURLOPT_SSL_VERIFYHOST, false);
    $xzv_0 = curl_exec($xzv_23);
    curl_close($xzv_23);
    return $xzv_0;
}

function get_client_ip($xzv_7 = 0)
{
    $xzv_7 = ($xzv_7 ? 1 : 0);
    static $xzv_6 = NULL;
    if( $xzv_6 !== NULL ) 
    {
        return $xzv_6[$xzv_7];
    }

    if( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ) 
    {
        $xzv_11 = explode(",", $_SERVER["HTTP_X_FORWARDED_FOR"]);
        $xzv_26 = array_search("unknown", $xzv_11);
        if( false !== $xzv_26 ) 
        {
            unset($xzv_11[$xzv_26]);
        }

        $xzv_6 = trim($xzv_11[0]);
    }
    else
    {
        if( isset($_SERVER["HTTP_CLIENT_IP"]) ) 
        {
            $xzv_6 = $_SERVER["HTTP_CLIENT_IP"];
        }
        else
        {
            if( isset($_SERVER["REMOTE_ADDR"]) ) 
            {
                $xzv_6 = $_SERVER["REMOTE_ADDR"];
            }

        }

    }

    $xzv_31 = sprintf("%u", ip2long($xzv_6));
    $xzv_6 = ($xzv_31 ? array( $xzv_6, $xzv_31 ) : array( "0.0.0.0", 0 ));
    return $xzv_6[$xzv_7];
}

function getSubstr($xzv_34, $xzv_10, $xzv_21)
{
    $xzv_20 = strpos($xzv_34, $xzv_10);
    $xzv_35 = strpos($xzv_34, $xzv_21, $xzv_20);
    if( $xzv_20 == false || $xzv_35 == false || $xzv_35 < $xzv_20 ) 
    {
        return "";
    }

    return substr($xzv_34, $xzv_20 + strlen($xzv_10), $xzv_35 - $xzv_20 - strlen($xzv_10));
}

function title($xzv_27, $xzv_9 = "", $xzv_8 = "")
{
    global $aty;
    global $ini;
    echo "\n<!--\n52影视系统 http://www.52v.xyz\n本模板采用Amaze UI http://amazeui.org/\n-->   \n<!--公共头文件开始（本头文件由代码动态生成）-->   \n<!doctype html>\n<html class=\"no-js\">\n<head>\n    <meta charset=\"utf-8\">\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n\n    <title>";
    echo $xzv_27 . $ini["title"] . " " . $ini["subtitle"];
    echo "</title>\n    <meta name=\"description\" content=\"";
    echo $xzv_9 . $ini["description"];
    echo "\"/>\n    <meta name=\"keywords\" content=\"";
    echo $xzv_8 . $ini["keywords"];
    echo "\"/>\n    \n    <!-- Set render engine for 360 browser -->\n    <meta name=\"renderer\" content=\"webkit\">\n    \n    <!-- No Baidu Siteapp-->\n    <meta http-equiv=\"Cache-Control\" content=\"no-siteapp\"/>\n    \n    <link rel=\"icon\" type=\"image/png\" href=\"";
    echo $aty;
    echo "/assets/img/favicon.png\">\n    \n    <!-- Add to homescreen for Chrome on Android -->\n    <meta name=\"mobile-web-app-capable\" content=\"yes\">\n    <link rel=\"icon\" sizes=\"192x192\" href=\"";
    echo $aty;
    echo "/assets/img/app-icon72x72@2x.png\">\n    \n    <!-- Add to homescreen for Safari on iOS -->\n    <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\n    <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\">\n    <meta name=\"apple-mobile-web-app-title\" content=\"Amaze UI\"/>\n    <link rel=\"apple-touch-icon-precomposed\" href=\"";
    echo $aty;
    echo "/assets/img/app-icon72x72@2x.png\">\n    \n    <!-- Tile icon for Win8 (144x144 + tile color) -->\n    <meta name=\"msapplication-TileImage\" content=\"";
    echo $aty;
    echo "/assets/img/app-icon72x72@2x.png\">\n    <meta name=\"msapplication-TileColor\" content=\"#0e90d2\">\n    \n\t<link rel=\"stylesheet\" href=\"/assets/css/amazeui.min.css\">\n    <link rel=\"stylesheet\" href=\"";
    echo $aty;
    echo "/assets/css/app.css\">\n\n\t<!--[if (gte IE 9)|!(IE)]>\n    <!--<script src=\"";
    echo $aty;
    echo "/assets/js/jquery.min.js\"></script>-->\n\t<script src=\"/assets/js/jquery-3.3.1.min.js\"></script>\n    <!--<![endif]-->\n    <!--[if lte IE 8 ]>\n    <script src=\"https://libs.baidu.com/jquery/1.11.3/jquery.min.js\"></script>\n    <script src=\"https://cdn.staticfile.org/modernizr/2.8.3/modernizr.js\"></script>\n    <script src=\"/assets/js/amazeui.ie8polyfill.min.js\"></script>\n    <![endif]-->\t\n    <script>\n        // 网站相关信息，供页面内的 js 文件调用\n        var tySiteInfo = { siteUrl: \"//www.600m.net\", debug: false }\n    </script>\n";
}

function banner()
{
    global $username;
    global $ini;
    echo "<!--公共header部分开始（本header由代码动态生成）-->\n</head> \n\n<body>\n\n<header class=\"am-topbar\">\n    <div class=\"am-container\">\n    <h1 class=\"am-topbar-brand hover-bounce\">\n        <a href=\"/\" class=\"web-name\">\n            <span class=\"am-icon-film am-icon-md\"></span> \n            ";
    echo $ini["title"];
    echo "            \n        </a>\n    </h1>\n\n    <button class=\"am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only\" data-am-collapse=\"{target: '#doc-topbar-collapse'}\">\n        <span class=\"am-sr-only\">导航切换</span> \n        <span class=\"am-icon-bars\"></span>\n    </button>\n\n  <div class=\"am-collapse am-topbar-collapse\" id=\"doc-topbar-collapse\">\n    <ul class=\"am-nav am-nav-pills am-topbar-nav\">";
    $xzv_2 = explode("\n", $ini["topmenu"]);
    foreach( $xzv_2 as $xzv_25 => $xzv_5 ) 
    {
        $xzv_4 = explode(",", $xzv_5);
        echo "\n    \t<li><a href=\"" . $xzv_4[0] . "\">" . $xzv_4[1] . "</a></li>";
    }
    echo " \n\t\t<li id=\"username\" data-vip=\"";
    echo $_SESSION["vip"];
    echo "\" data-expir_time=\"";
    echo $_SESSION["expir_time"];
    echo "\">";
    if( empty($username) ) 
    {
        echo "<a href=\"/soso.php\">资源搜索</a>";
    }
    else
    {
        echo "<a href=\"/user\">" . $username . "</a>";
    }

    echo "</li>\n\n        <li class=\"am-dropdown\" data-am-dropdown>\n            <a class=\"am-dropdown-toggle\" data-am-dropdown-toggle href=\"javascript:;\">\n                更多 <span class=\"am-icon-caret-down\"></span>\n            </a>\n            <ul class=\"am-dropdown-content\">            ";
    $xzv_24 = explode("\n", $ini["topmenus"]);
    foreach( $xzv_24 as $xzv_25 => $xzv_29 ) 
    {
        $xzv_4 = explode(",", $xzv_29);
        echo "\n            \t<li><a href=\"" . $xzv_4[0] . "\">" . str_replace("|||", "", $xzv_4[1]) . "</a></li>";
        if( strstr($xzv_4[1], "|||") ) 
        {
            echo "<li class=\"am-divider\"></li>";
        }

    }
    echo "            </ul>\n        </li>\n    </ul>\n\n<script language=\"javascript\">\n/*function showLogin(){}\nsetInterval(\"showLogin()\",\"1000\");//每隔1 运行一次\n*/\n   function Checkfrom()\n   {  \n     window.location.href= '/so=' +  tyForm.so.value;\n     return false; //通知 提交 其实也没必要\n   }\n</script>\n\n    <form class=\"am-topbar-form am-topbar-left am-form-inline\" role=\"search\" action=\"/so.php\" name=\"tyForm\" onsubmit=\"return Checkfrom();\" >\n        <div class=\"am-input-group am-input-group-primary am-input-group-sm\">\n            <input name=\"so\" type=\"text\" class=\"am-form-field\" placeholder=\"搜索...\" required>\n            <span class=\"am-input-group-btn\">\n                <button class=\"am-btn am-btn-primary\" type=\"submit\">\n                    <span class=\"am-icon-search\"></span>\n                </button>\n            </span>\n        </div>\n    </form>\n\t\n    <div class=\"am-topbar-right\">\n        <div id=\"show-history-dropdown\" class=\"am-dropdown\" data-am-dropdown=\"{boundary: '.am-topbar'}\">\n            <button id=\"show-history\" class=\"am-btn am-btn-secondary am-topbar-btn am-btn-sm am-dropdown-toggle\" data-am-dropdown-toggle>\n                 <span class=\"am-icon-history\"></span>观看记录 <span class=\"am-icon-caret-down\"></span>\n            </button>\n            <ul id=\"history-list\" class=\"am-dropdown-content\">\n                <li><a href=\"javascript:;\">播放记录载入中..</a></li>\n            </ul>\n        </div>\n    </div>\n\n  </div>\n  </div>\n</header>\n\n\n<!--公共header部分结束-->\n";
    return NULL;
}

function footer()
{
    global $aty;
    global $ini;
    echo "<!--公共foot部分开始（本footer由代码动态生成）-->\n\n    <!-- 返回顶部 -->\n    <div data-am-widget=\"gotop\" class=\"am-gotop am-gotop-fixed\" title=\"返回顶部\">\n        <a href=\"#top\" title=\"\">\n            <i class=\"am-gotop-icon am-icon-arrow-up\"></i>\n        </a>\n    </div>\n\n    <!-- 底部栏 -->\n    <footer data-am-widget=\"footer\" class=\"am-footer am-footer-default am-hide-sm-only\" data-am-footer=\"{  }\">\n        <div class=\"am-footer-miscs\">\n            ";
    echo $ini["footer"];
    echo "\t\t</div>\n    </footer>\n\n    <!-- 底部导航栏 -->\n    <!-- 图标资源来自于  -->\n    <div data-am-widget=\"navbar\" class=\"am-navbar am-cf am-navbar-default am-show-sm-only\" id=\"\">\n        <ul class=\"am-navbar-nav am-cf am-avg-sm-4\">\t\t";
    $xzv_1 = explode("\n", $ini["bottommenu"]);
    foreach( $xzv_1 as $xzv_30 => $xzv_3 ) 
    {
        $xzv_22 = explode(",", $xzv_3);
        echo "\n\t\t\t<li>\n                <a href=\"" . $xzv_22[0] . "\" class=\"\">\n                    <!--<span class=\"am-icon-home\"></span>-->\n                    <img src=\"" . $xzv_22[1] . "\" alt=\"" . $xzv_22[2] . "\"/>\n                    <span class=\"am-navbar-label\">" . $xzv_22[2] . "</span>\n                </a>\n            </li>";
    }
    echo " \n        </ul>\n    </div>\n\n\n    <!-- layer弹窗插件 -->\n \n\t<script src=\"";
    echo $aty;
    echo "/assets/plugns/layer/layer.js\"></script>\n\n    <!-- 滚动加载插件 -->\n    <script src=\"";
    echo $aty;
    echo "/assets/js/jquery.lazyload.min.js?v1.0\"></script>\n\n<script type=\"text/javascript\">\nvar store;\n\n\$(function() {\n    \n    // 图片懒加载\n    \$(\"img.lazyload\").lazyload({\n        effect: \"fadeIn\",     // effect(特效),值有show(直接显示),fadeIn(淡入),slideDown(下拉)等,常用fadeIn\n        failurelimit: 20,    // 加载N张可加区域外的图片\n        threshold: 180, // 距离屏幕180px即开始加载\n        load: function() {\n            \$(this).removeClass('lazyload');\n            \$(this).addClass('img-loaded');\n        }\n    });\n    \n    // 展示播放历史记录\n    \$(\"#show-history\").click(function() {\n        store = \$.AMUI.store;\n        if (store.enabled) {\n            var histemp = store.get('history')? store.get('history'): [];\n            \n            if(histemp.length == 0) {\n                \$(\"#history-list\").html('<li><a href=\"javascript:;\">暂无播放记录</a></li>');\n            } else {\n                \$(\"#history-list\").html('');\n                \n                for(var i=0; i<histemp.length; i++) {\n                    switch(histemp[i].types) {\n                        case 'm':\n                            \$(\"#history-list\").append('<li><a href=\"/m/'+histemp[i].id+'.html\">'+histemp[i].title+'</a></li>');\n                        break;\n                        \n                        case 'tv':\n                            \$(\"#history-list\").append('<li><a href=\"/tv/'+histemp[i].id+'.html\">'+histemp[i].title+' [第'+histemp[i].episode+'集]</a></li>');\n                        break;\n                        \n                        case 'ct':\n                            \$(\"#history-list\").append('<li><a href=\"/ct/'+histemp[i].id+'.html\">'+histemp[i].title+' [第'+histemp[i].episode+'集]</a></li>');\n                        break;\n\t\t\t\t\t\t\n\t\t\t\t\t\tcase 'va':\n\t\t\t\t\t        \$(\"#history-list\").append('<li><a href=\"/va/'+histemp[i].id+'.html\">'+histemp[i].title+' [ '+histemp[i].episode+' ]</a></li>');\n                        break;\n\t\t\t\t\t\t\n\t\t\t\t\t\tcase 'mg':\n                           \$(\"#history-list\").append('<li><a href=\"/mg/'+histemp[i].id+'.html\">'+histemp[i].title+' [ '+histemp[i].episode+' ]</a></li>');\n                        break;\t\t\t\t\n\n\t\t\t\t\t\tcase 'zy':\n                           \$(\"#history-list\").append('<li><a href=\"/zy/'+histemp[i].site+'-'+histemp[i].id+'.html\">'+histemp[i].title+' [ '+histemp[i].episode+' ]</a></li>');\n                        break;\n\t\t\t\t\t\t\n\t\t\t\t\t\tcase '2mm':\n                           \$(\"#history-list\").append('<li><a href=\"/2mm/'+histemp[i].url+'.html\">'+histemp[i].title+' [ '+histemp[i].episode+' ]</a></li>');\n                        break;\t\t\t\t\t\t\n                    }\n                }\n                \n                \$(\"#history-list\").append('<li><a href=\"javascript:;\" onclick=\"clearHistory();\"><span class=\"am-text-warning am-text-xs\">清空播放记录</span></a></li>');\n            }  \n        }\n    });\n\n});\n\n// 清空历史记录\nfunction clearHistory() {\n    // 关闭下拉\n    \$(\"#show-history-dropdown\").dropdown(\"close\");\n    \n    // 清空播放记录存储\n    store.remove('history');\n    \n    layer.msg(\"播放记录已清空\");\n}\n\n// url编码\n// 输入参数：待编码的字符串\nfunction urlEncode(String) {\n    return encodeURIComponent(String).replace(/'/g,\"%27\").replace(/\"/g,\"%22\");\t\n}\n</script>\n\n";
    echo $ini["addcode"];
    echo "\n\t<script src=\"/assets/js/amazeui.min.js\"></script>\n</body> \n</html> \n<!--公共foot部分结束-->\n";
    return NULL;
}


