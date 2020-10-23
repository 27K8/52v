
<?php
//error_reporting(0);
$html="http://cj.okzy.tv/inc/feifei3s_subname/";
$q=$so;
//$q="功夫";
$zyso = file_get_contents($html.'?wd='.$q); 
$data = json_decode($zyso, true);
?>
 
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
