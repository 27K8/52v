<?php include "function.php";
include "./app.php";
include "./live.php";
title("APP设置");
head(1);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>


  <div class="container" style="padding-top:70px;">
  <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		if($k=='live' || $k=='submit')continue;  //当$k=='live' 或者 $k=='submit'不做运行下面的语句
		$value=str_replace("'","\'",$value);
		$text.= "'$k'=>'".trim($value)."',\n";
	}
	/*$text="<?php include './config.php';\n\$app = array(\n$text'jxurl'=>\$jxurl);\nif(!empty(\$_SERVER[\"QUERY_STRING\"])){echo json_encode(\$app);}?>";	*/
	$text="<?php\n\$app = array(\n$text);\n?>";
    FileMSG(saveFile("app.php",$text));
	FileMSG(saveFile("live.php","<?php\n\$live = array(\n".$_POST['live'].");if(isset(\$_GET['url'])){ echo json_encode(\$live);}\n?>"));

}else{?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">APP设置</h3></div>
<div class="panel-body">
  <form action="" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">客服QQ</label>
	  <div class="col-sm-10"><input name="QQ" type="text"  placeholder="QQ" class="form-control" value="<?=$app['QQ']?>" ></div>
	</div><br/>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">QQ群</label>
	  <div class="col-sm-10">
        <input name="qunhao" type="text"  placeholder="Q群号码 427674159" class="form-control" value="<?=$app['qunhao']?>" >
        <input name="qunkey" type="text"  placeholder="Q群key fBNavKnCsPiHxzig_hol6HpUGMuXX5mT" class="form-control" value="<?=$app['qunkey']?>" >
      </div>
	</div><br/>
	
    <div class="form-group">
	  <label class="col-sm-2 control-label">展示页面</label>
	  <div class="col-sm-10">
	    <input name="time" type="text"  placeholder="展示时间 秒数。" class="form-control" value="<?=$app['time']?>" >
	    <input name="url" type="text"  placeholder="启动跳转页面，为空则不显示" class="form-control" value="<?=$app['url']?>" >
	  </div>
	</div><br/>
	
    <div class="form-group">
	  <label class="col-sm-2 control-label">播放</label>
	  <div class="col-sm-10">
	    <input name="playurl" type="text"  placeholder="默认播放页浏览器跳转页面，为空则不跳转" class="form-control" value="<?=$app['playurl']?>" >
	    <input name="mgjx" type="text"  placeholder="芒果解析接口..." class="form-control" value="<?=$app['mgjx']?>" required></div>
	</div><br/>
	
 	<div class="form-group">
	  <label class="col-sm-2 control-label">广告地址</label>
	  <div class="col-sm-10">
	    <input name="guanggaourl" type="text"  placeholder="分享的链接..." class="form-control" value="<?=$app['guanggaourl']?>">
	  </div>
	</div><br/>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">自定义项目</label>
	  <div class="col-sm-10">
	    <textarea class="form-control" name="zdyxm" rows="6" placeholder="项目图片,项目名称,项目链接 多个用换行分隔"><?php echo htmlspecialchars($app['zdyxm']); ?></textarea>
      </div>
	</div><br/>
    
	<div class="form-group">
	  <label class="col-sm-2 control-label">APP版本</label>
	  <div class="col-sm-10"><input name="v" type="text"  placeholder="版本号..." class="form-control" value="<?=$app['v']?>" required></div>
	</div><br/>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">下载地址</label>
	  <div class="col-sm-10"><input name="download" type="text"  placeholder="下载地址..." class="form-control" value="<?=$app['download']?>" required></div>
	</div><br/>

    <div class="form-group">
	  <label class="col-sm-2 control-label">更新说明</label>
	  <div class="col-sm-10"><textarea class="form-control" name="shuoming" rows="6"><?php echo htmlspecialchars($app['shuoming']); ?></textarea></div>
	</div><br/>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">分享</label>
	  <div class="col-sm-10">
	    <input name="shareurl" type="text"  placeholder="分享的链接..." class="form-control" value="<?=$app['shareurl']?>" required>
	    <textarea class="form-control" name="text" rows="6" placeholder="分享的内容..." required><?=htmlspecialchars($app['text'])?></textarea>
		<textarea class="form-control" name="playtext" rows="6" placeholder="分享自定义文本..." ><?=htmlspecialchars($app['playtext'])?></textarea>
	  </div>
	</div><br/>
	
    
	<div class="form-group">
	  <label class="col-sm-2 control-label">APP公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="gonggao" rows="6"><?php echo htmlspecialchars($app['gonggao']); ?></textarea></div>
	</div><br/>
	
	<div class="form-group">
	  <label class="col-sm-2 control-label">直播地址</label>
	  <div class="col-sm-10"><textarea class="form-control" name="live" rows="6"><?php 
	  foreach ($live as $k => $value) { if($k=='0')continue;  echo "'$k' => '$value',\n"; }?></textarea></div>
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
<?php } ?>

    </div>
  </div>
 
<?=footer()?>
</body>
</html>
  