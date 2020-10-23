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
$row=proving();
if($row["vip"]<99){
	exit("禁止访问！");
}
title("发信邮箱配置");
head(8);
?>

<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">	
	
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		if($k=='submit')continue;
		$value=str_replace("'","\'",$value);
		$text.= "'$k'=>'".trim($value)."',\n";
	}
    FileMSG(saveFile("conf/mailini.php","<?php\n\$mail = array(\n$text);\n?>"));

}else{
	include "conf/mailini.php";
?>

<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">发信邮箱配置</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form">

	<div class="form-group">
	  <label class="col-sm-2 control-label">SMTP服务器</label>
	  <div class="col-sm-10"><input type="text" name="smtp" value="<?=$mail['smtp']?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">SMTP端口</label>
	  <div class="col-sm-10"><input type="text" name="port" value="<?=$mail['port']?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">邮箱账号</label>
	  <div class="col-sm-10"><input type="text" name="name" value="<?=$mail['name']?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">邮箱密码</label>
	  <div class="col-sm-10"><input type="text" name="pwd" value="<?=$mail['pwd']?>" class="form-control"/></div>
	</div><br/>

	<div class="form-group">
	  <label class="col-sm-2 control-label">收信邮箱</label>
	  <div class="col-sm-10"><input type="text" name="recv" value="<?=$mail['recv']?>" class="form-control" placeholder="不填默认为发信邮箱"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>	 </div><br/>
	</div>
  </form>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span>
此功能为用户注册和忘记密码时给自己发邮件验证或者密码。<br/>QQ邮箱，SMTP服务器smtp.qq.com，端口465，密码不是QQ密码也不是邮箱独立密码，是QQ邮箱设置界面生成的<a href="http://service.mail.qq.com/cgi-bin/help?subtype=1&&no=1001256&&id=28"  target="_blank" rel="noreferrer">授权码</a>。
<br/>网页，SMTP服务器smtp.163.com，端口25，邮箱密码是邮箱独立授权码，是网易邮箱设置→客户端授权密码 界面生成的授权码</a>。为确保发信成功率，发信邮箱和收信邮箱最好同一个
</div>
</div>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>

<?php
}?>

    </div>
  </div>
<?=footer()?>
 </body>
</html> 