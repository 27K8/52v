<?php 
if(!empty($_GET['action'])){
	error_reporting(0);
    header('Content-type: application/json');
    session_start();	
    function curl($url,$postdata = ''){
        $curl = curl_init(); // Curl 初始化 
        curl_setopt($curl, CURLOPT_URL, $url); // 设置 Curl 目标  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Curl 请求有返回的值  		
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置抓取超时时间  30秒
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip'); //取消gzip压缩 
    	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts  
    	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);        // 跟踪重定向  
        if($postdata) {
        curl_setopt($curl, CURLOPT_POST, 1);    
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
        }
        $tmpInfo = curl_exec($curl);
        curl_close($curl); 
        return $tmpInfo; 
    }
	
    $validate = strtolower($_POST['validate']);
    $username = $_POST['username'];
    
    if($validate==$_SESSION["authnum_session"] && !empty($username) ){
		include "../config.php";
        include "conf/mysql.php";
        $row = query("select * from tyys_user where username='$username' or email='$username';");
	    if(($username==$row["username"] or $username==$row["email"]) && !empty($row["username"])){
			$username=$row["username"];
			$email = $row["email"];
			$password = $row["password"];
            $title = "用户密码找回";
            $text = "亲爱的".$username."：<br/>由于你遗忘了账号密码所以本邮件将向您发送你的密码。<br/>这是你的密码：$password<br/>如果此次找回密码请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 微宝影视运营团队 敬上</p>";
			$data = json_decode( curl("http://".$_SERVER['SERVER_NAME']."/user/conf/sendsmail.php","email=$email&title=$title&text=$text") );
    	    $code=$data->code;
    	    $msg=$data->msg;
            if($code == 200) {
    	        $json['msg'] = '找回密码成功！请登录你的邮箱查看你的密码！';
    	    	$json['code'] = 200;
            }else{
                $json['msg'] = $msg;
    	    	$json['code'] = 400;
            }
	    }else{
			$json['msg'] = "用户不存在！";
    	    $json['code'] = 400;
		}
    }else{
    	$json = array("code"=> 500,"msg"=>"验证码错误！");
    }
	exit(json_encode($json));
}
?>
<?php 
require_once '../api.inc.php';
// 公共函数文件
require "conf/function.php";
?>
<?php
title('找回密码');
?>
<script>
   $(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#forget").click(); 
       } 
   }); 
   
$(document).ready(function(){
	$('#forget').click(function(){
		if(myform.username.value.length <=5){
			alert("用户名必须大于五个字符！！");
			myform.username.focus();
			return false;
		}else if(myform.validate.value.length < 4){
		alert("请输入右边完整的验证码！");
			myform.validate.focus();
			return false;
		}
		
	  	$("#forget").button('loading');
	    $.post("?action=save",
	    {
	      username:$('#username').val(),
		  validate:$('#validate').val(),
	    },
	    function(data){
		    if(data['code']==200){
				new invokeSettime("#tomial");
		    	//window.location.href="./login.php";
		    }
			alert(data['msg']);
	        $("#forget").button('reset');
		    //$('#result').html(data['msg']);
			validateimg();
	    },"json");		
	});
});
	
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("disabled",false);
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}

function validateimg(){
    $('#imgcode').attr("src",'conf/captcha.php?'+Math.random()); 
}
</script>
<body>	
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../">返回首页</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="./register.php"><span class="glyphicon glyphicon-user"></span> 注册</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">找回密码</h3></div>
        <div class="panel-body">
		
		  <p id="result" style="color:red;text-align:center;"></p>
          <form action="./forget.php" method="post" class="form-horizontal" role="form" name="myform">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="username" type="text" name="username" class="form-control" placeholder="请输入你的账号 或者邮箱" required>
            </div><br/>
			
			<div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
              <input id="validate" type="text" name="validate" class="form-control input" placeholder="输入验证码" autocomplete="off" required>
			  <span class="input-group-addon" style="padding: 0">
	           <img id="imgcode" title="点击刷新" src="conf/captcha.php" onclick="this.src='conf/captcha.php?'+Math.random();" height="32" title="点击更换验证码"/>
	          </span>
            </div><br/>
			
            <div class="form-group">
              <div class="col-xs-12">
			   <button type="button" class="btn btn-primary form-control" id="forget" data-complete-text="Loading finished">找回密码</button>
			  </div>
            </div>
			<p class="col-sm-8  col-sm-offset-2 text-center" style="margin-top:10px; font-size: 12px;">没有账户？<a style="font-size: 12px; color: #2196f3;" href="register.php" target="_self">立即注册</a></p>
          </form>
		  
        </div>
      </div>
    </div>
  </div>
 <?=footer()?>
</body>
</html>