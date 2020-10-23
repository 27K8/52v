<?php
$cat=$_GET['cat'];
if($cat==0)$cat='all';
$year=intval($_GET['year']);
if($year==0)$year='all';
$area=$_GET['area'];
if($area==0)$area='all';
$act=$_GET['act'];
if($act==0)$act='all';
$pageno=intval($_GET['pageno']);
if($pageno==0){$pageno=1;}
$act=$_GET['act'];  //演员

    if($leixing=="dongman"){
		$url="http://www.360kan.com/dongman/list?cat=$cat&year=$year&area=$area&pageno=$pageno";
	}elseif($leixing=="zongyi"){
		$url="http://www.360kan.com/zongyi/list?cat=$cat&area=$area&act=all&pageno=$pageno";
    }else{
		$url="http://www.360kan.com/$leixing/list?rank=rankhot&cat=$cat&area=$area&act=all&year=$year&pageno=$pageno";
    }
    //echo $url;
	$info=getwy($url);	
//echo $info;	
//判断当前页面最大页数
preg_match_all("#<a href='(.*?)pageno=(.*?)'#",$info,$pagearr);
if(count($pagearr[2])>0)$top = array_search( max($pagearr[2]) ,$pagearr[2]);$maxpage=$pagearr[2][$top];
preg_match_all("#<a target='_self' class='on'>(.*?)</a>#", $info,$yearr); 
$top=intval($yearr[1][0]);
if($maxpage<$top)$maxpage=$top;
if(intval($maxpage)==0)$maxpage=1;	
?>
