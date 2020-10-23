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
title("系统设置");
head(1);
$row=proving();
?>

<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	$oldpassword=$_POST['oldpassword'];
	$password=$_POST['password'];
	$enpassword=$_POST['enpassword'];
	if($password==$enpassword){
		if($oldpassword==$password){
			showmsg("你是来消遣我的么。",4);
		}else{
			//include "conf/mysql.php";
		    $username=$row["username"];
            $update = modifys("UPDATE tyys_user SET password='$password' WHERE username='$username' and password='$oldpassword';");
		    if($update){showmsg("修改成功！",1);
		    }else{showmsg("密码错误！",3);}		
		}
	
	}else{showmsg("俩次密码不一致！",4);}    
}else{
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改密码</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form">
  
    <div class="input-group">
        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
        <input type="password" name="oldpassword" value="" class="form-control" placeholder="旧密码" required />
    </div><br/>	  
	
	<div class="input-group">
	    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
	    <input type="password" name="password" value="" class="form-control" placeholder="新密码" required />
	</div><br/>	
	
	<div class="input-group">
	    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
	    <input type="password" name="enpassword" value="" class="form-control" placeholder="确认新密码" required />
	</div><br/>	
	
	<div class="col-xs-12">
	     <input type="submit" name="submit" value="修改" class="btn btn-primary form-control" required /><br/>
	</div>
  </form>
</div>
</div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>
<?php
}?>

    </div>
  </div>
<?=footer()?>
 </body>
</html> 