<?php date_default_timezone_set('PRC');error_reporting(0);
	header('Content-type: application/json'); //json
function getwy($url){ 
    $ch = curl_init();  
    curl_setopt ($ch, CURLOPT_URL,$url);  
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  // Curl 请求有返回的值  
    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36');  
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);  //设置超时10秒
    return curl_exec($ch);    // 函数返回内容  
    curl_close($ch);    // 结束 Curl  	
}
 
    $so=$_POST['so'];
	$id=$_POST['id'];

    if( empty($id) ){
        $info=getwy("http://www.btbtdy.com/search/$so.html");
    	preg_match_all('#<a class="so_pic" href="/btdy/dy(\d+).html" title="(.*?)" target="_blank"><img class="lazy" data-src="(.*?)"#',$info,$title);
		preg_match_all('#alt=".*?"/><span>(.*?)</span>#',$info,$span);
		preg_match_all('#</strong><span>(.*?)</span></p><p>(.*?)</p><p>(.*?)</p><p>(.*?)</p></dd></dl>#',$info,$types);
		
		foreach ($title[1] as $i => $id){
		    $data[$i]=array(
		    "title"=>$title[2][$i],	
		    "image"=>$title[3][$i],
		    "id"=>$id,	
            "tab"=>$span[1][$i],	
		    "type"=>$types[1][$i],
			"show"=>$types[2][$i],
			"star"=>$types[3][$i],
		    "synopsis"=>$types[4][$i]
		    );
	    }
    	echo json_encode(array("code"=> 200,"msg"=>"获取列表成功","total"=>count($data),"utime"=>"","data"=>$data));
    }else{
        $info=getwy("http://www.btbtdy.com/vidlist/$id.html");
    	preg_match_all('#target="_blank" class="ico_1">(.*?)<span class="bt">详情</span></a><span><a class="d1" href="([a-zA-Z0-9:?=]*)">#',$info,$text);		
		foreach ($text[2] as $i => $down){
		    $data[$i]=array(
		    "title"=>$text[1][$i],	
		    "down"=>$down
		    );
	    }
    	echo json_encode(array("code"=> 200,"msg"=>"获取列表成功","total"=>count($data),"utime"=>"","data"=>$data));
    }

?>