<?php include "function.php";
title("首页配置");
head(2);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>

<div class="container" style="padding-top:70px;">
   <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		$value=str_replace("'","\'",$value);
		$text.= "'$k'=>'".trim($value)."',\n";
	}
    FileMSG(saveFile("home.php","<?php\n\$home = array(\n$text);\n?>"));	
}else{
	include "home.php";
?>
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">首页配置</h3></div>
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal" role="form">
            
          	    <div class="form-group">
          	       <label class="col-sm-2 control-label">首页轮播</label>
          	       <div class="col-sm-10"><textarea class="form-control" name="broadcast" rows="10" placeholder="图片,链接,剧名,信息 多个换行分隔"><?=$home['broadcast']; ?></textarea></div>
          	    </div><br/>
          	    
          	    <div class="form-group">
          	       <label class="col-sm-2 control-label">首页底部script</label>
          	       <div class="col-sm-10"><textarea class="form-control" name="script" rows="10" placeholder="script 代码"><?=$home['script']; ?></textarea></div>
          	    </div><br/>
                
          	    <div class="form-group">
          	       <label class="col-sm-2 control-label">友情链接</label>
          	       <div class="col-sm-10"><textarea class="form-control" name="lianjie" rows="5" placeholder="名字,链接 多个换行分隔"><?=$home['lianjie']; ?></textarea></div>
          	    </div><br/>
          	    
          	    <div class="form-group">
          	       <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/></div>
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