<?php include "function.php";include "./analysis.php";
include "./config.php";
title("公告&接口设置");
head(3);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>

<div class="container" style="padding-top:70px;">
  <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
 

if(isset($_POST['submit'])) {
	$gonggao=str_replace("'","\'",$_POST['gonggao']);
	$analysis = explode("\n",$_POST['analysis']);
	foreach ($analysis as $i => $value) {
	   $arr = explode(",",$value);
	   $text.= 'array("name"=>"'.trim($arr[0]).'","url"=>"'.trim($arr[1]).'"'.(count($arr)>2?',"js"=>"'.trim($arr[2]).'"':'').(count($analysis)==$i+1?")":"),")."\n";
	}
	
    FileMSG(saveFile("config.php","﻿<?php\n\$gonggao='$gonggao';\n?>"));
	FileMSG(saveFile("analysis.php","<?php\n\$analysis=array(\n$text)\n?>"));
}else{?>
    <div class="panel panel-primary">
    <div class="panel-heading"><h3 class="panel-title">公告&接口设置</h3></div>
    <div class="panel-body">
      <form action="" method="post" class="form-horizontal" role="form">
    
    	<div class="form-group">
    	  <label class="col-sm-2 control-label">解析接口</label>
    	  <div class="col-sm-10"><textarea class="form-control" name="analysis" rows="10" required><?php
    	  foreach ($analysis as $i => $value) {
    		echo $value["name"].','.$value["url"].(empty($value["js"])?'':','.$value["js"]).(count($analysis)==$i+1?"":"\n");
    	  }	?></textarea></div>
    	</div><br/>
    	
    	<div class="form-group">
    	  <label class="col-sm-2 control-label">公告</label>
    	  <div class="col-sm-10"><textarea class="form-control" name="gonggao" rows="6"><?php echo htmlspecialchars($gonggao); ?></textarea></div>
    	</div><br/>
		
		<div class="form-group">
    	  <label class="col-sm-2 control-label">屏蔽关键词</label>
    	  <div class="col-sm-10"><textarea class="form-control" name="pinbi" rows="6"><?php echo htmlspecialchars($pinbi); ?></textarea></div>
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