<!--
<?php 
    require "../config.php";
?>微宝影视系统 QQ3213145200  http://400rj.com
-->
<?php
// 公共函数文件
require_once '../api.inc.php';
require "conf/mysql.php";
require "conf/function.php";
title("信息修改");
head(2);
$row=proving();
?>

<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<?php $username=$row["username"];
if(isset($_POST['submit'])) {
	$email=$_POST['email'];
	$verification = $_POST['verification']; 
	if($_SESSION["verification"]==$verification && $_SESSION["email"]==$email){
        $update = modifys("UPDATE tyys_user SET email='$email' WHERE username='$username';");
		if($update){
			showmsg("修改成功！新邮箱：$email",1);
			$_SESSION["email"]=$email;
			$_SESSION["verification"]==null;
		}else{
			showmsg("修改失败！",3);
		}	
	
	}else{showmsg("邮箱验证失败！",4);}    
}else{
?>

<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改信息</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form" name="myform">
	
    <div class="input-group">
      <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
      <input id="email" name="email" class="form-control" value="<?=$row["email"]?>" placeholder="你的邮箱地址" required />
    </div><br/>	
	<div class="input-group">
	   <span class="input-group-addon"><span class="glyphicon glyphicon-adjust"></span></span>
       <input id="validate" type="text" name="validate" class="form-control input" placeholder="点击此处显示图片验证码" autocomplete="off" required>
	   <span class="input-group-addon" style="padding: 0">
	    <img id="imgcode" title="点击刷新" onclick="validateimg()" height="32" title="点击更换验证码"/>
	   </span>
     </div><br/>	
    <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
        <input id="verification" name="verification" class="form-control input" placeholder="邮箱验证码 防止恶意注册" required />
	    <span class="input-group-addon" style="padding: 0">
	     <button type="button" id="tomial" style=" height:31px; " class="btn btn-primary form-control">发送验证码</button>
	    </span>
		
    </div><br/>
	
	<!--
    <div class="input-group">
      <span class="input-group-addon">手机</span>
      <input id="mobile" name="mobile" class="form-control" value="<?=$_SESSION["mobile"]?>" placeholder="你的手机号码" required />
    </div><br/>	
	-->
	<div class="form-group">
	  <div class="col-xs-12"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control" required /><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<script>
function ifnull() {   
   	if(myform.email.value == ""){
		alert("邮箱不能为空！！");
		myform.email.focus();
		return false;
	}else if(myform.validate.value == ""){
		alert("请输入验证码！");
		myform.validate.focus();
		return false;
    }else{
		return true;
	}
}  

$(document).ready(function(){ //在文档加载后激活函数：
    $("#imgcode").hide();
    $('#validate').click(function(){
    	$("#imgcode").show();
       if($('#imgcode').attr("src")==undefined)validateimg();
    }); 
    $('#tomial').click(function(){
    	if(ifnull()){
    		var email = document.getElementById("email");
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
    	      username:"<?=$username?>",
    	    },
    	    function(data){
    	    	if(data['code'] == 200){
    	    		new invokeSettime("#tomial");			
    	    	}
    	      $("#tomial").button('reset');
    		   alert(data['msg']);
			   validateimg();
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
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
</script>
<?php
}?>

    </div>
</div>
<?=footer()?>
 </body>
</html> 