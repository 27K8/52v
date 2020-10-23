<!--
<?php 
    require "admin/home.php";
    require "admin/ini.php";
    require "admin/config.php";
?>
-->
<?php
    // 公共函数文件
	require_once './api.inc.php';
    require './assets/include/function.php';
    // 网页head
    title('','','首页');
    //网页导航栏
    banner();	
function lunfantu($img,$url,$name,$description)
{ ?>
        <li>
            <img src="<?php echo $img;?>">
            <div class="am-slider-desc">
                <div class="am-slider-content">
                    <h2 class="am-slider-title"><?php echo $name;?></h2>
                    <p><?php echo $description;?></p>
                </div>
                <a href="<?php echo $url;?>" target="_blank" class="am-slider-more">立即观看</a>
            </div>
        </li>

<?php } ?>
  

<div class="am-container index-container">

	<?php if(!empty($gonggao))echo $gonggao;?>
	
<!-- 搜索表单 -->
<form action="so.php" class="am-show-sm-only am-margin-bottom">
    <div class="am-input-group am-input-group-primary">
        <input name="so" type="text" class="am-form-field" placeholder="输入影视关键词" required>
        <span class="am-input-group-btn">
            <button class="am-btn am-btn-primary" type="submit">
                <span class="am-icon-search"></span>
            </button>
        </span>
    </div>
</form>

<div class="am-g">
<div class="am-u-sm-12 am-u-lg-9">

    <!-- 上次播放记录 -->
    <div class="index-last-watch am-alert am-alert-secondary am-margin-bottom" data-am-alert hidden>
        <button type="button" class="am-close">&times;</button>
        <p>继续观看 <span id="last-watch"></span></p>
    </div>

    <!-- 顶部轮播图banner -->
    <div data-am-widget="slider" class="am-slider am-slider-d2" 
      data-am-slider='{"directionNav":false}' >
    <ul class="am-slides">
        <!-- 轮播图开始 -->
<?php 
    $broadcast=explode("\n",$home['broadcast']);
    foreach ($broadcast as $i => $infoarr){
    	$info=explode(",",$infoarr);
    	lunfantu($info[0],$info[1],$info[2],$info[3]);
    }
?> 
  
  
        <!--轮播图结束-->
    </ul>
    </div>

    <!-- 影片列表开始 -->
    <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default" >
        <h2 class="am-titlebar-title ">
            电影
        </h2>
    </div>

    <ul class="am-avg-sm-3 am-avg-md-4 am-avg-lg-5 am-thumbnails movie-lists">

<?php
$info=getwy("https://www.360kan.com");
$dylb=getSubstr($info,'<div class="p-mod remendy">', '</ul>');
$vname='#<span class=\'s1\'>(.*?)</span>#';
$vping='#<span class=\'s2\'>(.*?)</span>#';
$vlist="#<a href='(.*?)' data-url='#";
$vimg="#<img src='(.*?)' data-src='(.*?)'#";  
$vtime="#<span class='w-newfigure-hint'>(.*?)</span>#";		
$vdesc="#<p class='w-newfigure-desc'>(.*?)</p>#";	
								
preg_match_all($vname, $dylb,$namearr); 
preg_match_all($vping, $dylb,$vpingf);  
preg_match_all($vlist, $dylb,$listarr);
preg_match_all($vimg,  $dylb,$imgarr); 
preg_match_all($vtime, $dylb,$timearr); 
preg_match_all($vdesc, $dylb,$descarr); 

     foreach ($namearr[1] as $i => $dyname)
       {
		   $dylj=str_replace('https://www.360kan.com','',$listarr[1][$i]);
		   $dypf=$vpingf[1][$i]; 
		   $dysj=$timearr[1][$i]; 
           $dyimg=$imgarr[2][$i];
           $dydesc=$descarr[1][$i]; 
           echo    '<li>
    <a class="movie-item" href="'.$dylj.'" target="_blank">
        <div class="movie-cover">
            <img src="assets/img/lazy.gif" data-original="'.$dyimg.'" class="lazyload">
            <span class="movie-description">
                <i class="description-bg"></i>
                <p>评分：'.$dypf.'</p>
                <p>年代：'.$dysj.'</p>
                <p>&gt; 在线观看</p>
            </span>
        </div>
        <div class="movie-title">
            <p class="movie-name">'.$dyname.'</p>
            <p class="movie-tags">'.$dydesc.'</p>
        </div>
    </a>
    </li>' ;
       }

?>  

	</ul>

    <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default" >
        <h2 class="am-titlebar-title ">
            电视剧
        </h2>
    </div>

    <ul class="am-avg-sm-2 am-avg-md-3 am-avg-lg-5 am-thumbnails tv-lists">
        
<?php 
$dslb=getSubstr($info,'<div class="p-mod dianshi" id=\'js-dianshi\'>', '</ul>');

$tvname='#<span class=\'s1\'>(.*?)</span>#';
$tvping='#<span class=\'s2\'>(.*?)</span>#';
$tvlist="#<a href='(.*?)' data-url='#";
$tvimg="#<img src='(.*?)' data-src='(.*?)'#";  
$tvtime="#<span class='w-newfigure-hint'>(.*?)</span>#";		
$tvdesc="#<p class='w-newfigure-desc'>(.*?)</p>#";	
								
preg_match_all($tvname, $dslb,$tvnamearr); 
preg_match_all($tvping, $dslb,$tvpingf);  
preg_match_all($tvlist, $dslb,$tvlistarr);  
preg_match_all($tvimg,  $dslb,$tvimgarr); 
preg_match_all($tvtime, $dslb,$tvtimearr); 
preg_match_all($tvdesc, $dslb,$tvdescarr); 

     for($i=0;$i<15;$i++)
       {
		   $dslj=str_replace('https://www.360kan.com','',$tvlistarr[1][$i]);
		   $dspf=$tvpingf[1][$i]; 
		   $dsname=$tvnamearr[1][$i]; 
		   $dssj=$tvtimearr[1][$i];  
           $dsimg=$tvimgarr[2][$i];
           $dsdesc=$tvdescarr[1][$i]; 
           echo '<li>
    <a class="movie-item" href="'.$dslj.'" target="_blank">
        <div class="movie-cover">
		    <img src="assets/img/lazy.gif" data-original="'.$dsimg.'" class="lazyload">
            <span class="movie-description">
                <i class="description-bg"></i>
                <p>'.$dssj.'</p>
                <p>评分：'.$dspf.'</p>
                <p>&gt; 在线观看</p>
            </span>
        </div>
        <div class="movie-title">
            <p class="movie-name">'.$dsname.'</p>
            <p class="movie-tags">'.$dsdesc.'</p>
        </div>
    </a>
    </li>' ;
       }

?>  
	
    </ul>
</div>
<div class="am-u-sm-12 am-u-lg-3">

    <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default" style="margin-top: 0">
        <h2 class="am-titlebar-title ">
            热播电影榜
        </h2>
    </div>

    <ul class="right-list">
        
<?php 
$dylb=getSubstr($info,'<span class="p-mod-label">电影榜</span>', '</ul>');
preg_match_all('#<a title="(.*?)" href="(.*?)" class="name"#', $dylb,$vtop); 
preg_match_all('#<span class="vv">(.*?)</span>#', $dylb,$vbfl); 
     foreach ($vtop[1] as $i => $dyname)
       {   $k=$i+1;
           $dyhref=str_replace('https://www.360kan.com','',$vtop[2][$i]);
           echo '        <li>
            <a href="'.$dyhref.'" target="_blank" class="am-text-truncate">
                <span class="r-l-right">'.$vbfl[1][$i].'</span>
                <span class="am-badge am-round">'.$k.'</span>
                '.$dyname.'
            </a>
        </li>' ;
       }
?>		
		
    </ul>

    <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default" style="margin-top: 0">
        <h2 class="am-titlebar-title ">
            热播电视剧榜
        </h2>
    </div>

    <ul class="right-list">

<?php 
$dslb=getSubstr($info,'<span class="p-mod-label">电视剧排行榜</span>', '</ul>');
preg_match_all('#<a title="(.*?)" href="(.*?)" class="name"#', $dslb,$tvtop); 
preg_match_all('#<span class="vv">(.*?)</span>#', $dslb,$tvbfl); 
     foreach ($tvtop[1] as $i => $dsname)
       {   $k=$i+1;
           $dshref=str_replace('https://www.360kan.com','',$tvtop[2][$i]);
           echo '        <li>
            <a href="'.$dshref.'" target="_blank" class="am-text-truncate">
                <span class="r-l-right">'.$tvbfl[1][$i].'</span>
                <span class="am-badge am-round">'.$k.'</span>
                '.$dsname.'
            </a>
        </li>' ;
       }
?>
            
    </ul>
	    <div data-am-widget="titlebar" class="am-titlebar am-titlebar-default" style="margin-top: 0">
        <h2 class="am-titlebar-title ">
            热播综艺榜
        </h2>
    </div>

    <ul class="right-list">

<?php 
$dslb=getSubstr($info,'<span class="p-mod-label">综艺排行榜</span>', '</ul>');
preg_match_all('#<a title="(.*?)" href="(.*?)" class="name"#', $dslb,$tvtop); 
preg_match_all('#<span class="vv">(.*?)</span>#', $dslb,$tvbfl); 
     foreach ($tvtop[1] as $i => $dsname)
       {   $k=$i+1;
           $dshref=str_replace('https://www.360kan.com','',$tvtop[2][$i]);
           echo '        <li>
            <a href="'.$dshref.'" target="_blank" class="am-text-truncate">
                <span class="r-l-right">'.$tvbfl[1][$i].'</span>
                <span class="am-badge am-round">'.$k.'</span>
                '.$dsname.'
            </a>
        </li>' ;
       }
?>
            
    </ul>

</div>
</div>

<div class="am-panel am-panel-default">
    <div class="am-panel-hd">友情链接</div>
    <div class="am-panel-bd">
	    <?php $lianjie=explode("\n",$home['lianjie']);
             foreach ($lianjie as $i => $yqurl){
				 $yurl=explode(",",$yqurl);
				 echo '<a href="'.$yurl[1].'" target="_blank">'.$yurl[0].'</a>&nbsp;&nbsp;&nbsp;';
			 }
		?>
    </div>
</div>

</div>

 <!-- 容器 -->

<script type="text/javascript">
// 上次播放提示
$(function() {
    var store = $.AMUI.store;
    if (store.enabled) {
        var histemp = store.get('history')? store.get('history'): [];
        
        if(histemp.length !== 0) {
            switch(histemp[0].types) {
                case 'm':
                    $("#last-watch").html('<a href="/m/'+histemp[0].id+'.html">《'+histemp[0].title+'》</a>');
                break;
                
                case 'tv':
                    $("#last-watch").html('<a href="/tv/'+histemp[0].id+'.html">《'+histemp[0].title+' [第'+histemp[0].episode+'集]》</a>');
                break;
                
                case 'ct':
                    $("#last-watch").html('<a href="/ct/'+histemp[0].id+'.html">《'+histemp[0].title+' [第'+histemp[0].episode+'集]》</a>');
                break;
				
				case 'va':
				     $("#last-watch").html('<a href="/va/'+histemp[0].id+'.html">《'+histemp[0].title+' ['+histemp[0].episode+']》</a>');
                break;

				case 'mg':
                     $("#last-watch").html('<a href="/mg/'+histemp[0].id+'.html">《'+histemp[0].title+' ['+histemp[0].episode+']》</a>');
                break;
				
				case 'zy':
                     $("#last-watch").html('<a href="/zy/'+histemp[0].site+'-'+histemp[0].id+'.html">《'+histemp[0].title+' ['+histemp[0].episode+']》</a>');
                break;
				
				case '2mm':
                     $("#last-watch").html('<a href="/2mm/'+histemp[0].url+'.html">《'+histemp[0].title+' ['+histemp[0].episode+']》</a>');
                break;				
				
            }
            $(".index-last-watch").slideDown();
        }
    }
});
</script>


<?php
    //网页页尾
    footer();
?>

<script>
<?php echo $ini['script']; ?>
</script> 