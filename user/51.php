<?php
if(!empty($_POST['username'])){
    header('Content-type: application/json');error_reporting(0);	
	include "conf/config.php";
	include "conf/mysql.php";	
    $username = $_POST['username'];	
	$Password = $_POST['Password'];
	
	/*
	$row = query("select * from tyys_card where Password='$Password';");
	$card_type_id=$row['card_type_id'];
	$card_vip=$row['card_vip'];
	$status=$row['status'];
	*/
	$status=1;
	if($Password=="51happy"){
		if($status==1){
	        $user = query("select * from tyys_user where username='$username' or id='$username';");
			if($user['vip']!=1)exit(json_encode(array("code"=>400,"msg"=>"抱歉该活动只限VIP1的用户使用哦！")));
			if($user['expir_time']>=1526054400)exit(json_encode(array("code"=>400,"msg"=>"你的到期时间超过了5月12号哦")));
			if($user['username']==$username || $user['id']==$username){
				$username=$user['username'];$id=$user['id'];
				$expir_time = 1526054400;$time=time();
	            if(modifys("UPDATE tyys_user SET update_time='$time',expir_time='$expir_time' WHERE id='$id' and username='$username' and expir_time<1526054400;")){
					$json['code']=200;$json['msg']="操作超过，你的VIP1到期时间是5月12号哦！";
	            }else{$json['code']=400;$json['msg']="用户更新失败！";}
			}else{$json['code']=400;$json['msg']="用户不存在！";}
		}elseif($status==2){
			$json['code']=400;$json['msg']="该卡号已被使用！";
		}else{
			$json['code']=400;$json['msg']="该卡号已被停用";}
			
	}else{$json['code']=400;$json['msg']="该口令不存在";}	
	
    exit(json_encode($json));
}
?>
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
title("51快乐");
head();
?>
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
		        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">51活动</h3></div>
            <div class="panel-body">
              <form action="" method="post" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">用户</span>
			  <input name="username" id="username" class="form-control" value="<?=$_COOKIE["username"]?>" placeholder="输入用户名 or ID" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">口令</span>
              <input name="Password" id="Password" class="form-control"  placeholder="口令" required />
            </div><br/>
	
            	<div class="form-group">
            	  <div class="col-xs-12"><input type="button" id="button" value="提交" class="btn btn-primary form-control" required /><br/>
            	 </div>
            	</div>
              </form>

				
            </div>
	    </div>

    </div>
</div>

<script> 
$(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#button").click(); 
       } 
}); 

$(document).ready(function(){ //在文档加载后激活函数：
    $('#button').click(function(){
    	if($('#username').val() == ""){
    		alert("用户名不能为空！！");
    		$('#username').focus();
    		return false;
    	}
    	if($('#Password').val() == ""){
    		alert("卡号不能为空！");
    		$('#Password').focus();
    		return false;
    	}	
        $("#button").button('loading');
        $.post("",{
    		username:$('#username').val(),
            Password:$('#Password').val(),
    	},
          function(data){
      	    if(data['code']==200){
    			$('#Password').val("");
    		}
    		alert(data['msg']);
            $("#button").button('reset');
          },"json");
	});
});
</script>
<?=footer()?>
</body>
</html>

