<?php include "function.php";
title("网站配置");
head(3);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>

<div class="container" style="padding-top:70px;">
  <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		if($k=='pwd' || $k=='submit')continue;//当$k=='pwd' 或者 $k=='submit'不做运行下面的语句
		$value=str_replace("'","\'",$value);
		$text.= "'$k'=>'".trim($value)."',\n";
	}
	$admin_pwd=$_POST['pwd'];
	if(!empty($admin_pwd))saveFile("password.php","<?php\n\$admin_user='$admin_user';//后台用户名\n\$admin_pwd='$admin_pwd';//后台密码\n?>");
    FileMSG(saveFile("ini.php","<?php\n\$ini = array(\n$text);\n?>"));
}else{
	include "ini.php";
?>
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">网站配置</h3></div>
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal" role="form">
                 
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站标题</label>
                  <div class="col-sm-10">
                    <input  class="form-control" name="title" value="<?=$ini['title'];?>">
                  </div>
                </div><br/>  
                 
                	<div class="form-group">
                  <label class="col-sm-2 control-label">网站副标题</label>
                  <div class="col-sm-10">
                    <input  class="form-control" name="subtitle" value="<?=$ini['subtitle'];?>">
                  </div>
                </div><br/>  
                 
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站描述</label>
                  <div class="col-sm-10"><textarea class="form-control" name="description" rows="4"><?=$ini['description']; ?></textarea></div>
                </div><br/>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站关键字</label>
                  <div class="col-sm-10"><textarea class="form-control" name="keywords" rows="5"><?=$ini['keywords']; ?></textarea></div>
                </div><br/>	
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">网站页脚</label>
                  <div class="col-sm-10"><textarea class="form-control" name="footer" rows="5"><?=$ini['footer']; ?></textarea></div>
                </div><br/>	
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">附加代码</label>
                  <div class="col-sm-10"><textarea class="form-control" name="addcode" rows="5"><?=$ini['addcode']; ?></textarea></div>
                </div><br/>	
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">顶部菜单</label>
                  <div class="col-sm-10"><textarea class="form-control" name="topmenu" rows="5" placeholder="链接,名字 多个换行分隔"><?=$ini['topmenu'];?></textarea></div>
                </div><br/>		
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">顶部菜单更多</label>
                  <div class="col-sm-10"><textarea class="form-control" name="topmenus" rows="5" placeholder="链接,名字 多个换行分隔 如果要添加分割线在名称后面加|||"><?=$ini['topmenus'];?></textarea></div>
                </div><br/>		
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">底部菜单</label>
                  <div class="col-sm-10"><textarea class="form-control" name="bottommenu" rows="5" placeholder="链接,图片,名字 多个换行分隔"><?=$ini['bottommenu']; ?></textarea></div>
                </div><br/>
                
                <div class="form-group">
                  <label class="col-sm-2 control-label">密码重置</label>
                  <div class="col-sm-10"><input type="text" name="pwd" value="" class="form-control" placeholder="不修改请留空"/></div>
                </div><br/>	
                
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
                 </div>
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