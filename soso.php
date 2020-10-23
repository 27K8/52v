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
	$from=$_GET['from'];
    // 网页head
    title($so.' - 搜索结果 - ',"$so,",$so);
    //网页导航栏
    banner();
	
error_reporting(0);

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
	    <div class="am-g" style="margin: 20px 0">
        <div class="am-u-lg-10 am-u-sm-centered">

            <!-- 搜索表单 -->
            <form action="./soso.php" method="get" class="am-margin-bottom" role="search" name="SoForm" onsubmit="return Checkfrom1();">
                <div class="am-input-group am-input-group-primary">
                    <input name="so" value="" type="text" 
                      class="am-form-field" placeholder="抢先看搜索各种电影、电视剧" required>
                    <span class="am-input-group-btn">
                        <button class="am-btn am-btn-primary" id="b_so" type="submit">
                            <span class="am-icon-search"></span>
                        </button>
                    </span>
                </div>
                <center>
	            <div class="am-form-group" style="margin-top: 10px;">
				    <label class="am-radio-inline am-success">
				    来源：
				    </label>
                    <label class="am-radio-inline am-success">
                        <input type="radio" value="360" name="from" title="扒取于360影视融化全网影视" data-am-ucheck> 搜全网
                    </label>
                    <label class="am-radio-inline am-success">
                        <input type="radio" value="zy" name="from" title="扒取资源网" data-am-ucheck> 搜资源网
                    </label>
<input type="submit" value="点击搜索">
					
                </div>
				
                </center>
            </form>
        
        </div>
    </div>	
	
	
	
	
	
	
    <div data-am-widget="list_news" class="am-list-news am-list-news-default" >
    
    <!-- 标题栏 -->
    
    <p>资源网相关结果</p>
    
    <div class="am-list-news-bd">
    <ul class="am-list">
    
    <!-- 搜索结果列表 -->
    <?php  
	$html="http://cj.okzy.tv/inc/feifei3s_subname/";
$q=$so;
$zyso = file_get_contents($html.'?wd='.$q); 
$data = json_decode($zyso, true);
 foreach($data["data"] as $i =>$name){
	if ((stristr($data['data'][$i]['list_name'], '福利') != false) || (stristr($data['data'][$i]['list_name'], '伦理片') != false)) {
                $id = '';
                $mz= '';
                $tu = '';
                $lx= '';
				$nf= '';
				$gx='';
				$nei='';
                $nullNum++;
            } else {
                $id=$data['data'][$i]['vod_id'];
$mz=$data['data'][$i]['vod_name'];
$tu=$data['data'][$i]['vod_pic'];
$lx=$data['data'][$i]['list_name'];
$nf=$data['data'][$i]['vod_year'];
$gx=$data['data'][$i]['vod_continu'];
$nei=$data['data'][$i]['vod_content'];
            } 
echo '<li class="am-g am-list-item-desced am-list-item-thumbed am-list-item-thumb-left">
            <div class="am-u-sm-4 am-list-thumb">
                <a href="../yingshi/bf.php?id='.$id.'" target="_blank" class="search-item-href">
                   <img src="'.$tu.'"  alt="'.$mz.'" class="lazyload">
				   
                </a>
            </div>
            
            <span class="video-score" title="类型">'.$lx.'</span>
            
            <div class="am-u-sm-8 am-list-main">
                <h3 class="am-list-item-hd">
                    <a href="../yingshi/bf.php?id='.$id.'" target="_blank" class="search-item-href">'.$mz.'</a>
                </h3>
                
                <div class="am-list-item-text">
                    '.$nei.'
                </div>
                <a href="../yingshi/bf.php?id='.$id.'" target="_blank" class="am-btn am-btn-secondary am-btn-sm search-item-btn">
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