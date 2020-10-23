
<?php
include "./b/aik.config.php";
error_reporting(0);
//$q=$_GET['v'];
$q="功夫";
$html=$aik['wangzhan'];
$zyso = file_get_contents($html.'?wd='.$q); 
$data = json_decode($zyso, true);
?>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>搜索结果无广告播高清播放！</title>
    <meta name="description" content="600米影视,600米影视是专门做电视剧,电影等在线播放服务，本页面提供电影的相关内容"/>
    <meta name="keywords" content="600米影院,600米科技,600米电影程序,电影网站源码,免会员,VIP观看电影,最新电影,动作,热剧,追热剧,电影,视频大全,在线高清电影,付费电影"/>
    
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    
    <!-- No Baidu Siteapp-->
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    
    <link rel="icon" type="image/png" href="/assets/img/favicon.png">
    
    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="/assets/img/app-icon72x72@2x.png">
    
    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <link rel="apple-touch-icon-precomposed" href="/assets/img/app-icon72x72@2x.png">
    
    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="/assets/img/app-icon72x72@2x.png">
    <meta name="msapplication-TileColor" content="#0e90d2">
    
	<link rel="stylesheet" href="/assets/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/css/app.css">
	<script src="/assets/js/jquery-3.3.1.min.js"></script>
    <script>
        // 网站相关信息，供页面内的 js 文件调用
        var tySiteInfo = { siteUrl: "//www.600m.net", debug: false }
    </script>
<!--公共header部分开始（本header由代码动态生成）-->
</head> 

<body>

<style>
.video-score {
    position: absolute;
    right: 10px;
    top: 0;
    font-size: 16px;
    color: #f72;
}
.video-score:first-letter {
    font-size: 20px;
}
/* 封面左侧边距 */
.am-list-news-default .am-list .am-list-item-thumb-left .am-list-thumb {
    padding-left: 10px;
}
/* 图片尺寸，居中 */
.am-list-news-default .am-list .am-list-thumb img {
    max-width: 200px;
    margin: 0 auto;
}
/* 文字右侧边距 */
.am-list-news-default .am-list .am-list-item-text {
    -webkit-line-clamp: 10; 
    max-height: none; 
    line-height: 1.6em;
    margin-right: 10px;
}
/* 电影标题 */
.am-list-item-hd a {
    font-size: 150%;
}
@media only screen and (max-width: 640px) {
    /* 小屏图片展示完全 */
    .am-list-news-default .am-list-item-thumb-left .am-list-thumb {
        max-height: none;
    }
    /* 右侧描述 */
    .am-list-news-default .am-list .am-list-item-text {
        -webkit-line-clamp: 3; 
        max-height: 3.9em; 
        line-height: 1.3em;
    }
    /* 电影标题 */
    .am-list-item-hd a {
        font-size: 100%;
    }
}

/* 按钮 */
.am-list .am-list-item-desced .am-btn, .am-list .am-list-item-thumbed .am-btn {
    margin-top: 10px;
    padding: .5em 1em;
}
</style>


<div class="am-container">
    <div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    
    <!-- 标题栏 -->

    <div class="am-list-news-bd">
    <ul class="am-list">
    
    <!-- 搜索结果列表 -->
	<?php foreach($data["data"] as $i =>$name){
$id=$data['data'][$i]['vod_id'];
$mz=$data['data'][$i]['vod_name'];
$tu=$data['data'][$i]['vod_pic'];
$lx=$data['data'][$i]['list_name'];
$nf=$data['data'][$i]['vod_year'];
$gx=$data['data'][$i]['vod_continu'];
$nei=$data['data'][$i]['vod_content'];
echo '<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
            <div class="am-u-sm-4 am-list-thumb">
                <a href="../b/info.php?id='.$id.'" target="_blank" class="search-item-href">
                   <img src="'.$tu.'"  alt="'.$mz.'" class="lazyload">
				   
                </a>
            </div>
            
            <span class="video-score" title="类型">'.$lx.'</span>
            
            <div class="am-u-sm-8 am-list-main">
                <h3 class="am-list-item-hd">
                    <a href="../b/info.php?id='.$id.'" target="_blank" class="search-item-href">'.$mz.'</a>
                </h3>
                
                <div class="am-list-item-text">
                    '.$nei.'
                </div>
                <a href="../b/info.php?id='.$id.'" target="_blank" class="am-btn am-btn-secondary am-btn-sm search-item-btn">
                    <i class="am-icon-play"></i>
                    在线播放  
                </a>
            </div>
        </li> ';
        
    }
	
	
    ?>
	
	     <!-- 搜索结果 结束 -->
    
    </ul>
    </div>
    </div>

</div>  <!-- 容器 -->



<!--公共foot部分开始（本footer由代码动态生成）-->

    <!-- 返回顶部 -->
    <div data-am-widget="gotop" class="am-gotop am-gotop-fixed" title="返回顶部">
        <a href="#top" title="">
            <i class="am-gotop-icon am-icon-arrow-up"></i>
        </a>
    </div>

    



<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?528547890f7df08154852c3a9f630c2e";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
	
</body> 
</html> 
<!--公共foot部分结束-->