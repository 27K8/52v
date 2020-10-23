<?php header("Content-type: text/html; charset=utf-8"); 
include "../admin/live.php";


foreach ($live as $k => $value) 
{  if($k=='0')continue;
   //echo "'$k' => '$value',\n";
    $zhibo=explode("\n",$value);
    for($i=0;$i<count($zhibo);$i++){
        $zblb=explode('|',trim($zhibo[$i])); 
        echo '<a href="http://jx.tyjun.cn/?url='.$zblb[1].'&live=tyys" target="content" >'.$zblb[0].'</a><br/>';
    }  
}

?>

