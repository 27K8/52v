<!--
<?php 
    require "admin/ini.php";
    require "admin/config.php";
?>
-->
<?php 
    // 公共函数文件
	require_once './api.inc.php';
    require './assets/include/function.php';
    $so=$_GET['so']; 
    // 网页head
    title($so.' - 搜索结果 - ',"$so,",$so);
    //网页导航栏
    banner();
	
error_reporting(0);
$seach=getwy('http://so.360kan.com/index.php?kw='.$so);
$szz3='#(<b>(.*?)</b><span>(.*?)</span></li></ul>)?<ul class="index-(.*?)-ul g-clear">(\n\s*)?<li>(\n\s*)?<b>类型：</b>(\n\s*)?<span>(.*?)</span>#';
preg_match_all('#js-playicon" title="(.*?)"\s*data#', $seach,$sarr);//$sarr 的1为名字
preg_match_all('#<div class="m-score">(.*?)</div>#', $seach,$pingfen);//评分
preg_match_all('#a href="(.*?)" class="g-playicon js-playicon"#', $seach,$hrefrr);//$hrefrr 链接
preg_match_all('#<img src="(.*?)" alt="(.*?)" />#',$seach,$imgrr);//图片、
preg_match_all('#<span class="playtype">(.*?)</span>#', $seach,$ysfl);//类型
preg_match_all('|<div class="m-description">(.*)</div>|isU', $seach,$jianjie);// 简介

preg_match_all($szz3, $seach,$sarr3);//sarr2的3为剧集
?>

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

	<?php if(!empty($gonggao))echo $gonggao;?>
	
    <div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    
    <!-- 标题栏 -->
    
    <p>共找到 <?php echo count($sarr[1]); ?> 个相关结果</p>
    
    <div class="am-list-news-bd">
    <ul class="am-list">
    
    <!-- 搜索结果列表 -->
    <?php foreach ($sarr[1] as $i=>$name){
		$href=str_replace("http://www.360kan.com","",$hrefrr[1][$i]);
        echo '<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
            <div class="am-u-sm-4 am-list-thumb">
                <a href="'.$href.'" target="_blank" class="search-item-href">
                    <img src="assets/img/lazy.gif" data-original="'.$imgrr[1][$i+1].'" alt="'.$name.'" class="lazyload">
                </a>
            </div>
            
            <span class="video-score" title="评分">'.$pingfen[1][$i].'</span>
            
            <div class="am-u-sm-8 am-list-main">
                <h3 class="am-list-item-hd">
                    <a href="'.$href.'" target="_blank" class="search-item-href">'.$ysfl[1][$i].$name.'</a>
                </h3>
                
                <div class="am-list-item-text">
                    '.$jianjie[1][$i].'
                </div>
                <a href="'.$href.'" target="_blank" class="am-btn am-btn-secondary am-btn-sm search-item-btn">
                    <i class="am-icon-play"></i>
                    在线播放  
                </a>
            </div>
        </li> ';
        
    }
	
	if( count($sarr[1])<=0 ){ echo '    <div class="am-alert am-alert-warning" data-am-alert>
        没找到“'.$so.'”相关结果，请换个关键词再试 或者<a href="/zy/'.$so.'.html" target="_blank">[资源搜索]</a></a>
    </div>';}
    ?>
    <!-- 搜索结果 结束 -->
    
    </ul>
    </div>
    </div>

</div>  <!-- 容器 -->

<script>
$('.search-item-href').each(function(){
    var href = $(this).attr('href');
    if(href == '') {
        $(this).removeAttr('href');
        $(this).removeAttr('target');
    }
});
$('.search-item-btn').each(function(){
    var href = $(this).attr('href');
    if(href == '') {
        $(this).removeAttr('href');
        $(this).removeAttr('target');
        $(this).attr('disabled', 'disabled');
        $(this).html('无法播放');
        $(this).removeClass('am-btn-secondary');
        $(this).addClass('am-btn-default');
    }
});
</script>

<?php
    //网页页尾
    footer();
?>