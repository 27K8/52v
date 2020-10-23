<?php 
$liebiao='#<div class="s-tab-main">(.*?)<script type="text/template"#s';
preg_match_all($liebiao,$info,$liebiao1);
$info=$liebiao1[0][0];
$vimg = "#<div class=\"cover g-playicon\">\r\n                                <img src=\"(.*?)\">\r\n#";	 
preg_match_all('#<span class="s1">(.*?)</span>#', $info,$namearr); 
preg_match_all('#<span class="s2">(.*?)</span>#', $info,$vpingf);  
preg_match_all('#<a class="js-tongjic" href="(.*?)">#', $info,$listarr); 
preg_match_all('#<p class="star">(.*?)</p>#', $info,$stararr);  
preg_match_all($vimg ,$info,$imgarr); 
preg_match_all('#<span class="hint">(.*?)</span>#', $info,$timearr); 

     foreach ($namearr[1] as $i => $value)
       {
           $yshref=$listarr[1][$i];//base64_encode(getSubstr($listarr[1][$i],'/','.html'));
		   $dypf=$vpingf[1][$i]; 
		   $dysj=$timearr[1][$i]; 
           $dyxq=$listarr[1][$i];  
           $dyimg=$imgarr[1][$i];
$dystar=$stararr[1][$i]; 
		   if($leixing=="dianying"){$text="评分：$dypf</p>\n                <p>年代：$dysj";}else{$text="$dysj</p>\n                <p>";}
        echo '    <li>
	<a href="'.$yshref.'" class="movie-item" target="_blank">
        <div class="movie-cover">
            <img src="/assets/img/lazy.gif" data-original="'.$dyimg.'" class="lazyload">
            <span class="movie-description">
                <i class="description-bg"></i>
                <p>'.$text.'</p>
                <p>&gt; 在线观看</p>
            </span>
        </div>
        <div class="movie-title">
            <p class="movie-name">'.$value.'</p>
            <p class="movie-tags">'.$dystar.'</p>
        </div>
    </a>
	</li>'."\n";
	   }
	   
if(count($namearr[1]) <=0 ){ echo '         <div class="am-alert am-alert-warning am-margin-top-sm am-margin-bottom-xl" data-am-alert>
                没找到符合条件的电影，请尝试其他分类！
        </div>';}	   
		
?>  