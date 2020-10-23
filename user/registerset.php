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
title("注册配置");
head(7);

?>

<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		if($k=='submit')continue;
		$value=str_replace("'","\'",$value);
		$text.= "'$k'=>'".trim($value)."',\n";
	}
    FileMSG(saveFile("conf/registerini.php","<?php\n\$register = array(\n$text);\n?>"));

}else{
	include "conf/registerini.php";
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">注册配置</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form"> 	
		
    <div class="form-group">
	  <label class="col-sm-2 control-label">注册限制</label>
	  <div class="col-sm-10">
        <select class="form-control" name="limit" default="<?=$register['limit']?>">
	        <option value="0">关闭</option>
	        <option value="1">验证邮箱</option>
	        <option value="2">验证IP</option>
	        <option value="3">验证邮箱和IP</option>
	    </select>
	  </div>
	</div>	
	
    <div class="form-group">
	  <label class="col-sm-2 control-label">注册赠送</label>
	  <div class="col-sm-10">
	    <select class="form-control" name="Gift_vip" default="<?=$register['Gift_vip']?>">
	        <option value="0">试看用户</option>
	        <option value="1">VIP1</option>
	        <option value="2">VIP2</option>
	        <option value="3">VIP3</option>
	    </select>
	    <input name="Gift_score" value="<?=floatval($register['Gift_score'])?>" class="form-control" placeholder="积分 支持小数" required />
	    <input name="Gift_day" value="<?=floatval($register['Gift_day'])?>" class="form-control" placeholder="时间 单位天 支持小数" required />
	  </div>
	</div>	
    <div class="form-group">
	  <label class="col-sm-2 control-label">推荐奖励</label>
	  <div class="col-sm-10">
	    <input name="Gift_score1" value="<?=floatval($register['Gift_score1'])?>" class="form-control" placeholder="积分 支持小数" required />
	    <input name="Gift_day1" value="<?=floatval($register['Gift_day1'])?>" class="form-control" placeholder="时间 单位天 支持小数" required />
	  </div>
	</div>	
    <div class="form-group">
	  <label class="col-sm-2 control-label">被推荐奖励</label>
	  <div class="col-sm-10">
	    <input name="Gift_score2" value="<?=floatval($register['Gift_score2'])?>" class="form-control" placeholder="积分 支持小数" required />
	    <input name="Gift_day2" value="<?=floatval($register['Gift_day2'])?>" class="form-control" placeholder="时间 单位天 支持小数" required />
        <input name="Gift_score3" value="<?=floatval($register['Gift_score3'])?>" class="form-control" placeholder="如果被推荐人vip等级不等于注册用户vip等级 补偿积分" required />
	  </div>
	</div>	
	
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