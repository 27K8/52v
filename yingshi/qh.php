<?php error_reporting(0); //关闭错误报告 

require_once '../assets/include/referer.php';

header("Content-type: text/html; charset=utf-8"); 
$site=$_GET['site'];
$id=$_GET['id'];
$category=$_GET['category'];

function getSubstr($str, $leftStr, $rightStr)
{
	$left = strpos($str, $leftStr);
	$right = strpos($str, $rightStr,$left);
	if($left == FALSE or $right == FALSE or $right < $left) return '';
	return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}

if(!empty($category)){
   $html = file_get_contents("http://www.360kan.com/cover/switchsite?site=$site&id=$id&category=$category"); 
   $json=json_decode( $html);
   $dataurl = $json->data;
   preg_match_all('#<a data-num="(.*?)" data-daochu="to='.$site.'" href="(.*?)">#',$dataurl,$tvyuan);  //播放源
   
   foreach ($tvyuan[2] as $n=>$tv){
   	echo '<button type="button" class="am-btn am-btn-sm btn-play-source" data-url="'.$tv.'">'.$tvyuan[1][$n].'</button>'."\n";
   }
}else{
   $html = file_get_contents("http://www.360kan.com/cover/zongyilist?id=$id&site=$site&do=switchsite&isByTime=true"); 
   $json=json_decode( $html);
   $dataurl = getSubstr($json->data,'<div id="js-year-all" class="js-month-tab">','<div class="juji-page">'); 
   // echo  $dataurl;
   preg_match_all("#<span class='w-newfigure-hint'>(.*?)</span></div>#",$dataurl,$vaqi);  //播放源期
   preg_match_all("#<a href='(.*?)' data-daochu#",$dataurl,$vaurl);  //播放源 链接
   preg_match_all('#<span class=\'s1\'>(.*?)</span>#',$dataurl,$vaname);  //播放源 名字
   
   foreach ($vaurl[1] as $n=>$va){
   	echo '<button data-alt="'.$vaqi[1][$n].'" type="button" class="am-btn am-btn-sm btn-play-source" data-url="'.$va.'">'.$vaname[1][$n].'</button>'."\n";
   }
}
   

?>