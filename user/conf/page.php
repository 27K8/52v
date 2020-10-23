<?php
	function page($page,$pagenum,$url){
		$pagetexe="";
	    $xzv_6=5;$page=$page<1?1:$page;$page=$page>$pagenum?$pagenum:$page;
	    $pagenum=$pagenum<$page?$page:$pagenum;$xzv_3=$page-floor($xzv_6/2);
	    $xzv_3=$xzv_3<1?1:$xzv_3;$xzv_2=$page+floor($xzv_6/2);
	    $xzv_2=$xzv_2>$pagenum?$pagenum:$xzv_2;$xzv_5=$xzv_2-$xzv_3+1;
	    if($xzv_5<$xzv_6&& $xzv_3>1){
	    	$xzv_3=$xzv_3-($xzv_6-$xzv_5);$xzv_3=$xzv_3<1?1:$xzv_3;$xzv_5=$xzv_2-$xzv_3+1;}
	    if($xzv_5<$xzv_6&& $xzv_2<$pagenum){
	    	$xzv_2=$xzv_2+($xzv_6-$xzv_5);$xzv_2=$xzv_2>$pagenum?$pagenum:$xzv_2;}
			

	    if($page>1){ $pagetexe.="<li><a href='$url topage(1)'>首页</a></li>"; $pagetexe.="<li><a href='$url topage(".($page-1).")'><span aria-hidden=\"true\">&laquo;</span></a></li>";}
	    for($xzv_8=$xzv_3;$xzv_8<=$xzv_2;$xzv_8++){
	    	if($xzv_8==$page){
	    		$pagetexe.= '<li class="active"><a href="#">'.$xzv_8.'</a></li>';
	    	}else{
	    		$pagetexe.= "<li><a href='$url topage($xzv_8);'>$xzv_8</a></li>";
			}
			
	    }
	    	if($page<$xzv_2){
	    		$pagetexe.= "<li><a href='$url topage(".($page+1).");'><span aria-hidden=\"true\">&raquo;</span></a></li>";
			}
			if($page<$pagenum)$pagetexe.="<li><a href='$url topage($pagenum);'>$pagenum</a></li>";
	    		return $pagetexe;	
	}
?>