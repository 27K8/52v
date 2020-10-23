<?php include "function.php";
title("接口账号配置");
head(3);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>

<div class="container" style="padding-top:70px;">
  <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if(isset($_POST['submit'])) {
	foreach ($_POST as $k => $value) {
		if($k=='submit')continue;
		$value=str_replace("'","\'",$value);
		$text.= "\$$k='".trim($value)."';\n";
	}
    FileMSG(saveFile("apiini.php","<?php\n$text?>"));
}else{
	include "apiini.php";
?>
    <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">接口账号配置</h3></div>
        <div class="panel-body">
            <form action="" method="post" class="form-horizontal" role="form">
                 
                <div class="form-group">
                  <label class="col-sm-2 control-label">接口</label>
                  <div class="col-sm-10">
				    <input class="form-control" name="api_url" placeholder="接口链接" value="<?=$api_url;?>">
                    <input class="form-control" name="api_user" placeholder="账号" value="<?=$api_user;?>">
					<input class="form-control" name="api_pass" placeholder="密码" value="<?=$api_pass;?>">
                  </div>
                </div><br/>  
                <div class="form-group">
          	       <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"><br></div>
          	    </div> 
            </form>
        </div>
		
		<div class="panel-footer">
        <span class="glyphicon glyphicon-info-sign"></span>
		聚合直播与芒果视频解析接口 <a href="http://v.nyqty.com/app/api">http://v.nyqty.com/app/api</a> 请联系QQ3213145200
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