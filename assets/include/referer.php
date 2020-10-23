<?php error_reporting(0); //关闭错误报告 
//判断手机客户端
$wap = preg_match("/(iPhone|iPad|iPod|Linux|Android)/i", strtoupper($_SERVER['HTTP_USER_AGENT']));
//防盗链域名，多个用|隔开，如：123.com|abc.com（不会设置盗链请留空）
function is_referer(){
    //获取来路域名
    $uriarr = parse_url($_SERVER['HTTP_REFERER']);
    $host = $uriarr['host'];
    if($host==$_SERVER['SERVER_NAME']){
        return true;
    }else{
		return false;
	}
}
/**/
if(!is_referer()){ 
exit( json_encode( array("code"=>200,"msg"=>$_SERVER['HTTP_REFERER']) ) ); 
}
?>