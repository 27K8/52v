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
title("关于程序");
head(9);
?>
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
  							
		<div class="row">
			<div class="col-md-12">
			<div class="panel panel-info">
					<div class="panel-heading"><span class="glyphicon glyphicon-cog"></span> 关于程序</div>
					<div class="panel-body box">
					<div class="alert alert-warning">
					   本程序是来自微宝科技编写 仅供学习参考 切勿用于一切非法活动！QQ3213145200<br>
					   更多功能后期添加！</div>
					<div class="alert alert-success"><font color="green">感谢您使用微宝影视程序</font><br><font color="red">当前版本：V1.0</font></div>
			
                    </div>

			</div><!--/.col-->
			</div>
		</div><!--/.row-->
	</div> 
</div>
<?=footer()?>
</body>
</html>

