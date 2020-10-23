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

	$type=$_GET['type'];
	switch($_GET['type']) {
        case 'm':
            $leixing="电影";			
        break;
                        
        case 'tv':
            $leixing="电视剧";	
        break;
                        
        case 'ct':
            $leixing="动漫";	
        break;
						
		case 'va':
            $leixing="综艺";	
        break;	

        default:
           exit("........不要乱输入");		
    }
	
    $id=($_GET['id']);
	//echo "http://www.360kan.com/$type/$id.html";
    $info=getwy("https://www.360kan.com/$type/$id.html");
    preg_match_all('#<div class="title-left g-clear">[\s\S]+?<h1>(.*?)</h1>#',$info,$title0); //标题 
    $title=$title0[1][0];  
	//网页head	
    if(empty($title)){$title="404";}
    title("$title - $leixing - ","$title,",$title);
    //网页导航栏
    banner();
if($type=="va"){
    $zongyi= getSubstr($info, '<div style="display:none;" class="js-month-tab">', '<div class="juji-page js-juji-page"');  //综艺。。
    preg_match_all("#<span class='s1'>(.*?)</span>#", $zongyi,$zname);
    preg_match_all("#<a href='(.*?)'#", $zongyi,$zurl);
    preg_match_all("#<span class='w-newfigure-hint'>(.*?)</span>#", $zongyi,$zqing); 
	$namearr=$zname[1];	$urlarr=$zurl[1];	$qtarr=$zqing[1];
    $mrsp=$zurl[1][0];    $episode=$zqing[1][0];
    $playsite=getSubstr($info,'站点选择','</ul>');
    preg_match_all('#data-cn="(.*?)" data-site="([a-z0-9]*)"#', $playsite,$bfyuan);  //播放源
    $sitename=$bfyuan[1][0]; $site=$bfyuan[2][0];	
	$sitenamearr=$bfyuan[1]; $sitearr=$bfyuan[2];	
    
    if(empty($sitename)){
    	preg_match_all('#<span class="ea-site ea-site-([a-z0-9]*) btn">(.*?)</span>#', $playsite,$bfyuan1);  //站点选择
        $site=$bfyuan1[1][0];    	$sitename=$bfyuan1[2][0];
    }	
	
}elseif($type=="m"){
    $dianying = getSubstr($info, '<div class="top-list-zd g-clear">', '</div>');  //电影。。
    $dianyingth=str_replace('http://cps.youku.com/redirect.html?id=0000028f&url=','',$dianying); //替换多余的
    preg_match_all('#<a data-daochu="to=(.*?)" class="(.*?)" href="(.*?)" monitor-shortpv-c-sub="tab_(.*?)"#', $dianyingth,$movie); //站点排序：
    $mrsp=$movie[3][0];
    
    $playsite=getSubstr($tvinfo,'playsite:[','],');
    preg_match_all('#"ensite":"(.*?)","cnsite":"(.*?)"#', $playsite,$tvyuan);  //播放源
}elseif($type=="ct"){	
    $chang=getSubstr($info,'<div class="m-series-content js-tab-content"','</div>');  //动漫。。
    if(!empty($chang)){ $info=str_replace(getSubstr($info,'<div class="m-series-content js-tab-content"','</div>'),'',$info); }
    preg_match_all('#<a data-num="(.*?)"data-daochu="to=(.*?)" href="(.*?)"#', $info,$jishuarr);  //集数
	$namearr=$jishuarr[1];
	$urlarr=$jishuarr[3];
	$qtarr=$jishuarr[2];
    $mrsp=$jishuarr[3][0];
    $episode=1;
    $playsite=getSubstr($info,'playsite:[','],');
    preg_match_all('#"ensite":"(.*?)","cnsite":"(.*?)"#', $playsite,$bfyuan);  //播放源	
	$site=$bfyuan[1][0];	$sitename=$bfyuan[2][0];
	$sitearr=$bfyuan[1];	$sitenamearr=$bfyuan[2];	
}else{	
    $chang=getSubstr($info,'<div class="num-tab-main g-clear js-tab" style="display:none;">','</div>');
    if(!empty($chang)){ $info=str_replace(getSubstr($info,'<div class="num-tab-main js-tab g-clear">','</div>'),'',$info); }
    preg_match_all('#<a data-num="(.*?)" data-daochu="to=(.*?)" href="(.*?)"#', $info,$jishuarr);  //集数
	$namearr=$jishuarr[1];
	$urlarr=$jishuarr[3];
	$qtarr=$jishuarr[2];
    $mrsp=$jishuarr[3][0];
    $episode=1;
    $playsite=getSubstr($info,'playsite:[','],');
    preg_match_all('#"ensite":"(.*?)","cnsite":"(.*?)"#', $playsite,$bfyuan);  //播放源	
	$site=$bfyuan[1][0];	$sitename=$bfyuan[2][0];
	$sitearr=$bfyuan[1];	$sitenamearr=$bfyuan[2];	
}


function unicode_decode($name){
  $json = '{"str":"'.$name.'"}';
  $arr = json_decode($json,true);
  if(empty($arr)) return '';
  return $arr['str'];
}
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
    
      
<?php if(empty($mrsp)){ ?>
    <div class="am-alert am-alert-warning" data-am-alert>
        <span class="am-icon-chain-broken am-icon-lg">&nbsp;</span> 
		正版电影没找到？ 	<?php if($title!="404"){?>  试试抢先资源观看. 你可以点击<a href="/api/?v=<?=$title;?>" target="_blank">[资源搜索]</a>里有没有<?php }else{?> 无效的URL，请不要胡乱输入哦！<?php }?> 
    </div>
<div class="am-panel-bd player-box">
        <iframe  src="https://z1.m1907.cn/?eps=0&jx=<?=$title;?>" width="100%" height="100%" allowfullscreen="true" allowtransparency="true"></iframe>
    </div>
<?php }else{ ?>

<?php if (strpos($pinbi,$title)!== false) {echo'<div class="am-panel-bd player-box">
        <iframe  src="../v/banquan.html" width="100%" height="100%" allowfullscreen="true" allowtransparency="true"></iframe>
    </div>';}else{echo'<div class="am-panel-bd player-box">
        <iframe id="ty-vip-player" src="" width="100%" height="100%" allowfullscreen="true" allowtransparency="true" allow="autoplay"></iframe>
    </div>';};
?>


    
    
    </div>
<script src="/yingshi/base64.js"></script>
<div class="am-panel am-panel-default">
    <div class="am-panel-hd"><?php if($type=="m"){ echo "播放源"; }else{?>
        选集
        <span class="btn-prev-source">[上一<?=$type=="va"?"期":"集"?>]</span>
        <span class="btn-next-source">[下一<?=$type=="va"?"期":"集"?>]</span>
        <a class="btn-goto-origin" target="_blank">[源站播放]</a><?php }?>
		<span class="btn-tyjx"><input type="checkbox" id="tyjx" onchange="tyjiexi(this.checked)"/>解析接口</span>
		<span class="btn-link" onClick="shortUrl()" id="share">[分享]</span>
		<span class="btn-link"><input type="text" value="" id="inputUrl" onClick="copyUrl()"/></span>
    </div>
    <div class="am-panel-bd">
	<?php if($type=="m"){
	foreach ($movie[3] as $n=>$movie0){
    $spdz=explode('?',$movie0);
    if(!empty($spdz[1])){$moviehref=$spdz[0]."?from=nyqty";}
    $moviename=$movie[4][$n];
    $moviehref=$movie0;
     echo '
     <div alt="600M影视" class="am-btn-group play-source-group">
         <button type="button" class="am-btn am-btn-sm btn-play-source" data-url="'.$moviehref.'">
             '.$moviename.'
         </button>
         <div class="am-dropdown am-dropdown-up" data-am-dropdown>
             <button class="am-btn am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle> <span class="am-icon-caret-up"></span></button>
             <ul class="am-dropdown-content">
                 <li><a href="'.$moviehref.'" target="_blank">去源站播放</a></li>
             </ul>
         </div>
     </div>';
    }

	}else{ ?>
	
        <div class="am-tabs" id="tv-res-choose" data-am-tabs>
            <ul class="am-tabs-nav am-nav am-nav-tabs">
                
                <li class="am-active" id="tttest">
                    <a href="#<?=$site;?>"><?=unicode_decode($sitename);?></a>
                </li>
           <?php for($i=1;$i<count($sitenamearr);$i++){
                 echo '
				 <li><a href="#'.$sitearr[$i].'">'.unicode_decode($sitenamearr[$i]).'</a></li>'; 	 
                 }
			?>    
			</ul>
            
        <div class="am-tabs-bd tv-res-lists">
        <div class="am-tab-panel am-fade am-in am-active" id="<?=$site;?>">
	
	<?php foreach ($urlarr as $i=>$video){
	        echo '
			<button alt="'.$qtarr[$i].'" type="button" class="am-btn am-btn-sm btn-play-source" data-url="'.$video.'">'.$namearr[$i].'</button>'; 
	} ?>
	
        </div>
		
<?php 
	for($i=1;$i<count($sitearr);$i++){
	    echo '
		<div class="am-tab-panel am-fade tv-res" id="'.$sitearr[$i].'">读取中...</div>'."\n"; 	 
	}
?>
		</div>
        </div>
<?php }?>      
        <br> * 如播放失败请更换解析
        
        <div id="jiexi1"  class="am-btn-group">
            <div class="am-dropdown am-dropdown-up" id="video-api-select" data-am-dropdown>
                <button class="am-btn am-btn-default am-btn-sm am-dropdown-toggle" data-am-dropdown-toggle>
                    <span id="apiname">切换解析接口</span> 
                    <span class="am-icon-caret-down am-margin-left-xs"></span>
                </button>
                
                <ul class="am-dropdown-content" id="videoapi">
                    <li class="am-dropdown-header">切换视屏解析接口</li>              
<?php 
	foreach ($analysis as $i => $value) {
		echo '
		            <li class="videoapi-item" data-url="'.base64_encode($value["url"]).'" data-name="'.base64_encode($value["name"]).'">
                        <a href="javascript:;"><script>document.write(TYBase.decode("'.base64_encode($value["name"]).'"));</script></a>
                    </li>';
    }
?>


                </ul>
            </div>
        </div>
		
		<div id="jiexi2">
        <select id="appduan" placeholder="切换视屏解析接口" data-am-selected="{btnWidth: '100%', maxHeight: 225}" class="filter-change-listen" onchange="qiehuanjiexi(this.value)">
		  <option selected value=""></option><?php 
    foreach ($analysis as $i => $value) {
		echo '
		  <option data-name="'.base64_encode($value["name"]).'" value="'.base64_encode($value["url"]).'"><script>document.write(TYBase.decode("'.base64_encode($value["name"]).'"));</script></option>';
    }
?>
            
        </select>
		</div>
		
		
		
        
    </div>
</div>
<script>
var store;

tySiteInfo.videoApi = TYBase.decode("<?=base64_encode($analysis[0]["url"])?>");

var ystype = "<?=$type?>";

var videoInfo = {
    id: "<?=$id;?>",
    url: "<?=$mrsp;?>",
    title: "<?=$title;?>"<?php if($type!="m") {?>,
    episode: "<?=$episode?>",
    site: "<?=$site;?>"<?php } ?> 
}

$(function() {
    store = $.AMUI.store;
    
    // 获取存储在本地的个性设置
    if (store.enabled) {
        tySiteInfo.videoApi = store.get('videoApi')? store.get('videoApi'): tySiteInfo.videoApi;
        
        // 找到并高亮所用解析接口
        $(".videoapi-item").each(function () {
            if($(this).data("url") == TYBase.encode(tySiteInfo.videoApi)) {
                $(this).addClass("am-active");
                return false;
            }
        });
        
		//找到SELECT选中的
	     document.getElementById('appduan').value=TYBase.encode(tySiteInfo.videoApi);
		 
		//取TY解析... 
		document.getElementById('tyjx').checked=store.get('tyjx') ? true : false;
		
		 
        // 找到历史播放记录并处理
        var histemp = store.get('history')? store.get('history'): [];
        
        for(var i=0; i<histemp.length; i++) {
            if(histemp[i].types == ystype && histemp[i].id == videoInfo.id) {
                videoInfo.url = histemp[i].url; <?php if($type!="m") {?> // 使用之前的同一个播放源
                videoInfo.episode = histemp[i].episode;  // 记录播放集数
                videoInfo.site = histemp[i].site;  // 资源站点
                // 切换到当前播放源的 tab
                $('#tv-res-choose').tabs('open', $('.am-tabs-nav a[href="#' + videoInfo.site + '"]'))
                layer.msg("您上次观看到<?=$type=="va"?"":"第"?> " + histemp[i].episode + " <?=$type=="va"?"期":"集"?>");<?php } ?> 
                break;
            }
        }
    }
    <?php if($type!="m") {?> 
    // 依次加载其它源资源
    $(".tv-res").each(function () {
        $(this).load("/yingshi/qh.php?id=" + videoInfo.id + "&site=" + $(this).attr("id")+ '&category=<?=($type=="tv")?2:(($type=="ct")?4:"");?>', function() {
            if($(this).attr("id") == videoInfo.site) {
                highlightSource();    // 高亮当前播放的这一集
                refreshToolBtn();    // 刷新上一集、下一集按钮
            }
        });
    });
    
    // 上一集
    $(".btn-prev-source").click(function() {
        $(".btn-play-source.am-btn-secondary").prev().click();
    });
    
    // 下一集
    $(".btn-next-source").click(function() {
        $(".btn-play-source.am-btn-secondary").next().click();
    });
    <?php } ?> 
    
	// 高亮当前播放
    highlightSource();
	
	<?php if($type=="m") {?> 
    // 切换播放源
    $(".btn-play-source").click(function() {
        $(".btn-play-source").removeClass("am-btn-secondary");
        $(this).addClass("am-btn-secondary");
        
        // 记录播放源
        videoInfo.url = $(this).data("url");
        
        // 更新视屏播放
        refreshVideo();
        
        layer.msg("已切换到 " + $(this).html() + " 线路");
    });
	
    <?php }else{ ?> 
    // 切换播放源（剧集）
    $(".tv-res-lists").on("click", ".btn-play-source", function() {
        $(".btn-play-source").removeClass("am-btn-secondary");
        $(this).addClass("am-btn-secondary");
        
        // 记录播放源（剧集）
        videoInfo.url = $(this).data("url");    // 链接
        videoInfo.episode = $(this).html();       // 集数
        videoInfo.site = $(this).parent().attr('id');    // 来源
        
        // 更新视屏播放
        refreshVideo();
        
        layer.msg("正在播放<?=$type=="va"?"":"第"?> " + videoInfo.episode + " <?=$type=="va"?"期":"集"?>");
    });
	
	<?php } ?> 
    // 切换解析接口 PC端
    $(".videoapi-item").click(function() {
        $("#videoapi .am-active").removeClass("am-active");
        $(this).addClass("am-active");
        
        // 记录接口地址
        tySiteInfo.videoApi = TYBase.decode($(this).data("url"));
        
        // 关闭下拉
        $("#video-api-select").dropdown("close");
        
        // 更新视屏播放
        refreshVideo();
        
        // 改变显示的接口名
        // $("#apiname").html($(this).data("name"));
        layer.msg("切换接口为 " + TYBase.decode( $(this).data("name")));
    });
    
    // 启动播放
    refreshVideo();
});

// 切换解析接口 移动端
function qiehuanjiexi(value) {
        // 记录接口地址
        tySiteInfo.videoApi = TYBase.decode(value);
        // 更新视屏播放
        refreshVideo();
        // 改变显示的接口名 
        layer.msg("切换接口为 " + TYBase.decode($('#appduan option:selected').data("name")) );
}


// TY解析。。。
function tyjiexi(checked) {
		store.set("tyjx", checked);  // 记录
        layer.msg( checked?"已启用 点击下面的视频吧！":"已关闭" );
}

    //显示解析接口
    var pcduan=document.getElementById('jiexi1');
    var yidong=document.getElementById('jiexi2');

    var isiPad = navigator.userAgent.match(/iPad|iPhone|Linux|Android|iPod/i) != null;
     
	  if (isiPad) {
		 pcduan.style.display='none'; yidong.style.display=''; 
      }else{
   	     yidong.style.display='none'; pcduan.style.display='';
      }	
	  
      pcduan.style.display='none'; yidong.style.display=''; 
// 找到并高亮所用播放源(剧集)
function highlightSource() {
    $(".btn-play-source").each(function () {
        if($(this).data("url") == videoInfo.url) {
            $(this).addClass("am-btn-secondary");
            return false;    // 退出each
        }
    });
}

<?php if($type!="m") {?>
// 刷新上一集、下一集的按钮
function refreshToolBtn() {
    // 上一集、下一集
    if($(".btn-play-source.am-btn-secondary").prev().length == 0) {
        $(".btn-prev-source").hide();
    } else {
        $(".btn-prev-source").show();
    }
    
    if($(".btn-play-source.am-btn-secondary").next().length == 0) {
        $(".btn-next-source").hide();
    } else {
        $(".btn-next-source").show();
    }
}
<?php }?> 
var title=document.title.replace(videoInfo.title,""),text='';
// 刷新视屏播放
function refreshVideo() {
	if(store.get('tyjx')==true && videoInfo.url.indexOf("www.mgtv.com/b/")!=-1){
		$("#ty-vip-player").attr("src", '//www.600m.net/api/?v=' + videoInfo.url);
	}else{
		$("#ty-vip-player").attr("src", tySiteInfo.videoApi + videoInfo.url);
	}
	if(ystype=="tv" || ystype=="ct")text = " 第" +videoInfo.episode + "集";
	else if(ystype=="va")text = " " +videoInfo.episode;
    document.title = videoInfo.title + text + title;
    $(".btn-goto-origin").attr("href", videoInfo.url); //源站播放
	
	<?php if($type!="m") {?> 
    refreshToolBtn();<?php }?> 
    
    // 记录用户数据
    if (store.enabled) {
        store.set("videoApi", tySiteInfo.videoApi);    // 记录所用的api接口
        var temp = {
                    types: ystype,
                    id: videoInfo.id, 
                    title: videoInfo.title,
                    url: videoInfo.url<?php if($type!="m") {?>,
                    episode: videoInfo.episode,
                    site: videoInfo.site<?php } ?> 
                };
        
        // 找到历史播放记录并删除
        var histemp = store.get('history')? store.get('history'): [];
        
        for(var i=0; i<histemp.length; i++) {
            if(histemp[i].types == ystype && histemp[i].id == videoInfo.id) {
                histemp.splice(i, 1); // 删除之前的历史记录
                break;
            }
        }
        
        // 添加到历史记录最开始
        histemp.unshift(temp);
        
        // 限定播放历史最多记录10条
        if(histemp.length > 10) histemp.length = 10; 
        
        store.set('history', histemp);
    }
}

var inputUrl=$("#inputUrl");  
inputUrl.hide();
	
function shortUrl(){
	if($("#share").html()=="[分享]"){
    	$.get("/assets/include/t.php",
    	    {
    		  long_url:window.location.href,
    	    },
    	function(data){
    		inputUrl.show();
    	    if(data['type']==0){
    			inputUrl.val(videoInfo.title + title + " \n" +data['url_short']);
				alert('生成['+videoInfo.title+']短链接成功点击复制 or 手动复制即可');
    	    }else{
    			inputUrl.val(videoInfo.title + title + " \n" +long_url);
                alert('生成['+videoInfo.title+']短链接失败');
    		} 
			$("#share").html("[复制]");
    	},"json"); 		
	}else{
		copyUrl();
	}
}
function copyUrl(){
		inputUrl.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        alert('复制['+videoInfo.title+']当前播放地址成功,如遇复制失败请手动复制');
}
</script>
<?php } ?>
<div class="am-panel am-panel-default">
    <div class="am-panel-hd">简介</div>
    <div class="am-panel-bd">
        <?php 
$jian=getSubstr($info,'style="display:none;"><span>简介 ：</span>', '</p>');
if(!empty($jian)){ echo $jian; }else{echo "error 404 ! 没有这个视频！ 请返回首页搜索你想看的视频";}
?>
    </div>
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">相关推荐</div>
    <div class="am-panel-bd">
        
        <ul data-am-widget="gallery" class="am-gallery am-avg-sm-2 am-avg-md-3 am-avg-lg-5 am-gallery-bordered tuijian-list">
            
                   
 <?php
$ltext=getSubstr($info,'猜你喜欢','</ul>');
preg_match_all("#data-src='(.*?)'#", $ltext,$liimg);
preg_match_all("#<a href='(.*?)' data-index=(.*?)>(.*?)</a>#",$ltext,$liurl); //链接 name
preg_match_all("#<p class='info'>(.*?)</p>#",$ltext,$lifen);
foreach ($liimg[1] as $ii=>$limg){
	//$limg=str_replace('https://','//',$limg);
    echo '
        <li>
            <div class="am-gallery-item tuijian-item">
                <a href="'.$liurl[1][$ii].'">
                    <img data-original="'.$limg.'" alt="'.$liname[1][$ii].'" src="/assets/img/lazy.gif" class="lazyload">
                    <h3 class="am-gallery-title">
                        '.$liurl[3][$ii].'
                        <span class="am-gallery-desc">'.$lifen[1][$ii].'</span>
                    </h3>
                </a>
            </div>
        </li>';
}

if(count($liimg[1])<=0)echo '
                    <div class="am-alert am-alert-secondary" data-am-alert>
                            暂无相关推荐
                    </div>  ';?> 
                                
        </ul>
        
    </div>
</div>

<?php  require '../assets/include/pinglun.php'; ?>

</div>  <!-- 容器 -->


<?php
    //网页页尾
    footer();
?>