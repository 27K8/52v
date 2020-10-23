<?php
require_once '../api.inc.php';
// 公共函数文件
require "conf/function.php";

if(isset($_GET['logout'])){
	$time=time() - 604800;
    @header('Content-Type: text/html; charset=UTF-8');
    setcookie("id", "",$time,'/');
	setcookie("username", "",$time,'/');
	setcookie("email", "",$time,'/');
	setcookie("skey", "",$time,'/');
	setcookie("login_time","",$time,'/');
	setcookie("tokens","",$time,'/');
    session_destroy();// 销毁当前会话中的全部数据
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}else if($_COOKIE['skey']==$skey){
	exit("<script language='javascript'>alert('您已登陆！正在跳转$gotourl');window.location.href='$gotourl';</script>");
}else if(!empty($_GET['action'])){
	$username = $_POST['username'];	$password = $_POST['password'];$validate = strtolower($_POST['validate']);
	if($validate==$_SESSION["authnum_session"]){
		include "../config.php";
	    include "conf/mysql.php";
        $row = query("select * from tyys_user where username='$username' or email='$username';");
	    if(($username==$row["username"] or $username==$row["email"]) && $password==$row["password"] && !empty($row["username"])){
			if($row['status']!=1)exit(json_encode(array("code"=>403,"msg"=>"抱歉你的账号已被管理员禁用！")));
	    	$login_time=time();
	    	$ip = get_client_ip();
	    	$json = array_merge_recursive($json,$row);
	    	$last_login_time = $row['login_time'];
	    	$last_login_ip = $row['login_ip'];
			if($username!=$row["username"]){$username=$row["username"];}
		    $update = modifys("UPDATE tyys_user SET login_time='$login_time',login_ip='$ip',last_login_time='$last_login_time',last_login_ip='$last_login_ip',login_count=login_count+1 WHERE username='$username' and password='$password';");
			if($update){
				$json['code']=200; $json['msg']="$HOST 登录成功";
				$time=time()+3600*24*7;
        	    setcookie("id",$row['id'],$time,'/');
				setcookie("username",$username,$time,'/');//发送一个 7天 过期的 cookie
				setcookie("email",$row["email"],$time,'/');
				setcookie("login_time",$login_time,$time,'/');
				$tokens = md5($row['id'] .$login_time . $password);
				setcookie("tokens",$tokens,$time,'/');
				$skey=md5($username."TYyingshi&http://$HOST/$tokens");
				setcookie("skey",$skey,$time,'/');
				$_SESSION["vip"]=$row["vip"];
				$_SESSION["score"]=$row["score"];
				$_SESSION["expir_time"]=$row["expir_time"];
		    }else{
				$json['code']=403;
	    	    $json['msg']="更新查询失败！";
			}
	    }elseif( ( $username==$row["username"] or $username==$row["email"] ) && !empty($row["username"])){
			$json['code']=0;$json['msg']="密码错误！";
	    }else{
			$json['code']=0;$json['msg']="该用户不存在！";
	    }
	}else{
		$json['code']=403;$json['msg']="验证码错误！";
	}
    exit(json_encode($json));	
}

title('登录');
?>

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
        <div class="panel-heading"><h3 class="panel-title">用户登陆</h3></div>
        <div class="panel-body">
		
		  <p id="result" style="color:red;text-align:center;"></p>
          <form action="./login.php" method="post" class="form-horizontal" role="form" name="myform">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="username" type="text" name="username" class="form-control" placeholder="请输入你的帐号或邮箱" required>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input id="password" type="password" name="password" class="form-control" placeholder="密码" required />
            </div><br/>
			
			<div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
              <input id="validate" type="text" maxlength="5" name="validate" class="form-control input" placeholder="输入验证码" autocomplete="off" required>
			  <span class="input-group-addon" style="padding: 0">
	           <img id="imgcode" title="点击刷新" src="conf/captcha.php" onclick="this.src='conf/captcha.php?'+Math.random();" height="32" title="点击更换验证码"/>
	          </span>
            </div><br/>
			
            <div class="form-group">
              <div class="col-xs-12">
			   <button type="button" class="btn btn-primary form-control" id="login" data-complete-text="Loading finished">登陆</button>
			  </div>
            </div>
			<p class="col-sm-8  col-sm-offset-2 text-center" style="margin-top:10px; font-size: 12px;">没有账户？<a style="font-size: 12px; color: #2196f3;" href="register.php" target="_self">立即注册</a>&nbsp;&nbsp;&nbsp;&nbsp;忘记密码？<a style="font-size: 12px; color: #2196f3;" href="forget.php" target="_self">找回密码</a></p>
          </form>
		  
        </div>
      </div>
    </div>
  </div>
  

<script>

   $(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#login").click(); 
       } 
   }); 
	$(document).ready(function(){ //在文档加载后激活函数：
	   //alert(myform.username.value.length);
	  $('#login').click(function(){
   	    if(myform.username.value.length <=5 ){
	    	alert("用户名必须大于五个字符！！");
	    	myform.username.focus();
	    	return false;
	    }else if(myform.password.value.length <= 5){
		    alert("密码必须大于五个字符");
		    myform.password.focus();
		    return false;
		}else if(myform.validate.value.length < 4){
			alert("请输入完整的验证码！");
			myform.validate.focus();
			return false;
		}
		
	  	$("#login").button('loading');
	    $.post("?action=save",
	    {
	      username:$('#username').val(),
	      password:$('#password').val(),
		  validate:$('#validate').val(),
	    },
	    function(data){
		    if(data['code']==200){
		    	window.location.href="<?=$gotourl?>";
		    }else{
				validateimg();
			}
			alert(data['msg']);
	        $("#login").button('reset');
		    //$('#result').html(data['msg']);
	    },"json");		
	  });
	});
	
function validateimg(){
    $('#imgcode').attr("src",'conf/captcha.php?'+Math.random()); 
}
</script>
<?=footer()?>
</body>
</html>