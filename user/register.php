<?php

// 公共函数文件
require_once '../api.inc.php';

require "conf/function.php";

include "conf/registerini.php";
if(!empty($_GET['action'])){
	$username = $_POST['username'];	$password = $_POST['password'];	$recommend = $_POST['recommend'];
    $email = $_POST['email'];$verification = $_POST['verification'];
	
    $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式  
    if(!preg_match($checkmail,$email)){  
       	$json['code'] = 0;
        $json['msg'] = "电子邮箱格式不正确";	
       exit(json_encode($json));
    }
    if(($_SESSION["verification"]==$verification && $_SESSION["email"]==$email) || $register['limit']=="0" || $register['limit']=="2"){
		require "../config.php";
        require "conf/mysql.php";	
	    $vip = $register['Gift_vip'];$score = floatval($register['Gift_score']);$day=floatval($register['Gift_day']);
		$score2 = floatval($register['Gift_score2']);$day2= floatval($register['Gift_day2']);
		$create_ip = get_client_ip();
		$text=$register['limit']=="2" || $register['limit']=="3"?" or create_ip='$create_ip'":"";
		$row = query("select * from tyys_user where username='$username' or email='$email'$text;");
        if($username==$row['username']){
    		exit( json_encode(array("code"=>0,"msg"=>"用户已经存在！")) );
    	}elseif($email==$row['email']){
    		exit( json_encode(array("code"=>0,"msg"=>"邮箱已有人注册了！")) );
    	}elseif($create_ip==$row['create_ip']){
    		exit( json_encode(array("code"=>0,"msg"=>"此位置已经有人占据了！")) );
    	}
		
		$Rid='null';$expir_time=0;
		if(!empty($recommend)){
            $row = query("select * from tyys_user where id='$recommend' or username='$recommend';");
            if($recommend==$row['id'] || $recommend==$row['username']){
				$recommend=$row['username'];$Rid=$row['id'];
			    $day +=floatval($register['Gift_day1']);
				$score += floatval($register['Gift_score1']);
		    }else{$Rid='null';$expir_time=0;}
		}
        $create_time=time();
        $expir_time += $create_time + (60*60*24)*$day;
        $sqr="INSERT INTO `tyys_user`(`id`, `username`, `password`, `vip`, `recommend`, `email`, `score`, `create_time`, `create_ip`, `expir_time`) VALUES ";
        $sqr.="(null, '$username', '$password', $vip, $Rid, '$email', $score, $create_time, '$create_ip', $expir_time);";
		$installs = modifys($sqr);
        if($installs){
			$json['code']=200;$expir_time = (60*60*24)*$day2;
			if($Rid!='null'){$update = modifys("UPDATE tyys_user SET ".($vip==$row['vip']?"expir_time=expir_time+$expir_time,score=score+$score2":"score=score+".floatval($register['Gift_score3']))." WHERE username='$recommend' and id='$Rid';");}
			$json['msg']="注册成功！系统赠送你 $day 天 VIP$vip 积分$score 免费畅享影视！".($update?"用户$recommend 向你推荐本网站获得".($vip==$row['vip']?"VIP$vip 奖励天数$day2 天 积分$score2":"积分".$register['Gift_score3']):"");
		}else{
			$json['code']=0;$json['msg']="注册失败，请重新注册？请联系截屏管理员！\n$sqr";
		}
    }else{
    	$json['code']=0;$json['msg']="邮箱验证失败！";
    }
	exit(json_encode($json));
}
title('注册');
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
            <a href="./login.php"><span class="glyphicon glyphicon-user"></span> 登陆</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">用户注册</h3></div>
        <div class="panel-body">
		
		  <p id="result" style="color:red;text-align:center;"></p>
          <form action="./register.php" method="post" class="form-horizontal" role="form" name="myform">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="username" type="text" name="username" class="form-control" placeholder="请输入手机号/QQ号" onkeyup="value=value.replace(/[^\da-zA-Z]/g,'')"  required>
            </div><br/>		
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input id="password" type="password" name="password" class="form-control" placeholder="密码" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
              <input id="enpassword" type="password" name="enpassword" class="form-control"  placeholder="确认密码" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input id="recommend" name="recommend" class="form-control" value="<?=$_GET['id']?>" placeholder="推荐人用户名 或者他的ID 没有就不填" />
            </div><br/>	
			
			<div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
              <input id="validate" type="text" name="validate" class="form-control input" placeholder="点击此处显示验证码" autocomplete="off" required>
			  <span class="input-group-addon" style="padding: 0">
	           <img id="imgcode" title="点击刷新" onclick="validateimg()" height="32" title="点击更换验证码"/>
	          </span>
            </div><br/>
			
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
              <input id="email" name="email" class="form-control" placeholder="你的邮箱地址" required />
            </div><br/>	
			<?php if($register['limit']=="1" || $register['limit']=="3"){ ?>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
              <input id="verification" name="verification" class="form-control input" placeholder="邮箱验证码 防止恶意注册" required />
			  <span class="input-group-addon" style="padding: 0">
	           <button type="button" id="tomial" style="height:31px; " class="btn btn-primary form-control">获取验证</button>
	          </span>
            </div><br/>	
			<?php }?>
            <div class="form-group">
              <div class="col-xs-12">
			   <button type="button" class="btn btn-primary form-control" id="register" data-complete-text="Loading finished" >注册账号</button>
			  </div>
            </div>
			<p class="col-sm-8  col-sm-offset-2 text-center" style="margin-top:10px; font-size: 12px;">已有账户？<a style="font-size: 12px; color: #2196f3;" href="login.php" target="_self">立即登录</a></p>
          </form>  
        </div>
      </div>
    </div>
  </div>
<script>  
$(function(){

 
}) 

function ifnull() {   
   	if(myform.username.value.length <=5 ){
		alert("用户名必须大于五个字符！！");
		myform.username.focus();
		return false;
	}else if(myform.password.value.length <= 5){
	    alert("密码必须大于五个字符");
	    myform.password.focus();
	    return false;
	}else if(myform.enpassword.value != myform.password.value){
		alert("两次密码不一致！");
		myform.enpassword.focus();
		return false;
	}else if(myform.validate.value.length < 4){
		alert("请输入右边完整的验证码！");
		myform.validate.focus();
		return false;
	}else if (myform.email.value == "") {
        alert("Email不能为空！");
        return false;
    }else{
		return true;
	}
}
   
   $(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#register").click(); 
       }
   });
   
$(document).ready(function(){ //在文档加载后激活函数：
    var email = document.getElementById("email");

    $('#username').bind('input propertychange', function() { 
  	    var preg = /^\d+$/; //匹配是否是数字
        if (preg.test($(this).val())) {
            $("#email").val($(this).val() + '@qq.com'); 
        }else{
			$("#email").val(""); 
		} 
    });

    $("#imgcode").hide();
    $('#validate').click(function(){
    	$("#imgcode").show();
       if($('#imgcode').attr("src")==undefined)validateimg();
    }); 

    $('#tomial').click(function(){
    	if(ifnull()){
		    var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
            if (!preg.test(email.value)) {
                alert("Email格式错误！");
                return false;
            }
            $("#tomial").button('loading');
    	    $.post("conf/email.php",
    	    {
    	      validate:$('#validate').val(),
    	      email:$('#email').val(),
    	      username:$('#username').val(),
    	    },
    	    function(data){
    	    	if(data['code'] == 200){
    	    		new invokeSettime("#tomial");			
    	    	}
    	      $("#tomial").button('reset');
    	      $('#result').html(data['msg']);
    		  alert(data['msg']);
    	    },"json");
    	}
    });		
		
	$('#register').click(function(){
        if(ifnull()){
			<?php if($register['limit']=="1" || $register['limit']=="3"){ ?>
	        if(myform.verification.value == ""){
	        	alert("请输入邮箱验证码！");
	        	myform.verification.focus();
	        	return false;
	        }
			<?php }?>
		    var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
            if (!preg.test(email.value)) {
                alert("Email格式错误！");
                return false;
            }
	  	    $("#register").button('loading');
	        $.post("register.php?action=save",
	        {
	          username:$('#username').val(),
	          password:$('#password').val(),
		      recommend:$('#recommend').val(),
		      email:$('#email').val(),
		      verification:$('#verification').val(),
		      validate:$('#validate').val(),
	        },
	        function(data){
		        if(data['code'] == 200){
		        	window.location.href="./login.php";
		        }else{
					validateimg();
				}	
	            $("#register").button('reset');
				alert(data['msg']);
		        $('#result').html(data['msg']);
	        },"json");
		}
	});
});

function validateimg(){
    $('#imgcode').attr("src",'conf/captcha.php?'+Math.random()); 
}

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
</script>
<?=footer()?>
</body>
</html>