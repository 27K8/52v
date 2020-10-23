<!--
<?php
    require "../admin/ini.php";
    require "../admin/config.php";
	require "../admin/analysis.php";
?>
-->
<?php
    // 公共函数文件
	require_once '../api.inc.php';
    require '../assets/include/function.php';

    $id=($_GET['id']);
	$cxurl = "http://cj.okzy.tv/inc/feifei3s_subname/";
	$url = $cxurl."?vodids=".$id;
$data=json_decode(file_get_contents($url),true);            
                $str = $data['data'][0]['vod_url'];
                $suArr = explode("$$$",$str);

$bf = explode("$",$suArr[1]);//自动播放
$bf1 = explode("\n",$bf[1]);
$bf2 =$bf1[0];
if (strpos($bf2,'.m3u8')) {$bf3='http://www.52v.xyz/p2pm3u8.php?v='.$bf2;}else{$bf3=$bf2;};
//print_r ($bf3)
    $title=$data['data'][0]['vod_name'];  
	$jian=$data['data'][0]['vod_content'];
	//网页head	
    if(empty($title)){$title="404";}
    title("$title - $leixing - ","$title,",$title);
    //网页导航栏
    banner();


?>
   
<style>
/* 资源切换按钮 */
.play-source-group {
    margin: 0 5px 5px 0;
}
/* 源站播放按钮 */
.play-source-group .am-dropdown-toggle {
    padding: .5em .6em;
    border-left: 1px solid #c7c6c6;
}

/* 上一集，下一集 */
.btn-prev-source, .btn-next-source, .btn-tyjx,.btn-goto-origin, .btn-goto-origin:hover ,.btn-link, .btn-link:hover {
    color: #dd514c;
    cursor: pointer;
    margin-left: 10px;
}
.btn-play-source {
    margin: 0 5px 5px 0;
}
/* 下侧推荐列表 */
.tuijian-item {
    max-width: 160px;
    margin: 0 auto;
}
.tuijian-item img {
    max-width: 200px!important;
}
</style>
<div class="am-container">

    <?php if(!empty($gonggao))echo $gonggao;?>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd"><?php echo $title;?></div>
    
<?php if (strpos($pinbi,$title)!== false) {echo'<div class="am-panel-bd player-box">
        <iframe  src="../v/banquan.html" width="100%" height="100%" allowfullscreen="true" allowtransparency="true"></iframe>
    </div>';}else{echo'<div class="am-panel-bd player-box">
        <iframe id="video" src="'.$bf3.'" width="100%" height="100%" allowfullscreen="true" allowtransparency="true" allow="autoplay"></iframe>
    </div>';};
?>


    </div>
<script src="/yingshi/base64.js"></script>
<div class="am-panel am-panel-default">
    <div class="am-panel-hd">        选集
        <span class="btn-prev-source">[上一集]</span>
        <span class="btn-next-source">[下一集]</span>
        <a class="btn-goto-origin" target="_blank">[源站播放]</a>
		<span class="btn-link"  id="share">当前播放：</span>
		<span class="btn-link" id="demo1" style="font-size:20px;color:orange"></span>
    </div>
    <div class="am-panel-bd">
		
        <div class="am-tabs" id="tv-res-choose" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                
                <li class="am-active" id="tttest">
                    <a href="#zy">资源网</a>
                </li>
               
			</ul>
            
        <div class="am-tabs-bd tv-res-lists">
        <div class="am-tab-panel am-fade am-in am-active" id="imgo">
				  <?php

                foreach($suArr as $a=>$b){  
                    $v = explode("\n",$b);
                    $d[] =$v; 
                }
                foreach($d as $k=>$v){    
                    foreach ($v as $cc){
                         $u = explode("$",$cc);
                        if(strpos($u[1] ,'.m3u8')){
                        $urls= $u[1];
                        $titl= $u[0];
                        echo
                       '<li class="am-btn am-btn-sm btn-play-source"><a href="http://www.52v.xyz/p2pm3u8.php?v='.$urls.'"  target="ajax" onclick="GetHref(this);return false;">'.$titl.'</a></li>';
                        }
                    }   
                }
?> 
        </div>
		</div>
        </div>    
    </div>
</div>
<div class="am-panel am-panel-default">
    <div class="am-panel-hd">简介</div>
    <div class="am-panel-bd">
        <?php 
if(!empty($jian)){ echo $jian; }else{echo "error 404 ! 没有这个视频！ 请返回首页搜索你想看的视频";}
?>
    </div>
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">相关推荐</div>
    <div class="am-panel-bd">
        
        <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-5 am-gallery-bordered tuijian-list">

                    <div class="am-alert am-alert-secondary" data-am-alert>
                            暂无相关推荐
                    </div> 
                                
        </ul>
        
    </div>
</div>

<?php  require '../assets/include/pinglun.php'; ?>

</div>  <!-- 容器 -->
<script>
function GetHref(obj){
document.getElementById("video").src=obj.href;
document.getElementById("demo1").innerHTML=obj.innerHTML;
}
</script>

<?php
    //网页页尾
    footer();
?>