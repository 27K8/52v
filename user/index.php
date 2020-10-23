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
title("首页");
head(0);
function todate($time) {
   return date("Y年m月d日 H:i:s",$time);
}
?>
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
     
        <div class="panel panel-info">
        	<div class="panel-heading">
        		<h3 class="panel-title">用户信息 ID:<?=$row["id"]?></h3>
        	</div>
        	<ul class="list-group">
        	
        		<li class="list-group-item">
        			<b>用户名：</b><?=$row["username"]?>
        		</li>
				
        		<li class="list-group-item">
        			<b>邮箱：</b><?=$row["email"]?>
        		</li>

        		<li class="list-group-item">
        			<b>VIP等级：</b><?=$row["vip"]?>
        		</li>
				
        		<li class="list-group-item">
        			<b>积分：</b><?=$row["score"]?>
        		</li>				
        		<li class="list-group-item">
        			<b>注册时间：</b><?=todate($row["create_time"])?>
        		</li>				
        		<li class="list-group-item">
        			<b>登录时间：</b><?=todate($row["login_time"])?>
        		</li>
        		<li class="list-group-item">
        			<b>VIP<?=$row["vip"]?>到期时间：</b><?=todate($row["expir_time"])?>
        		</li>
				
        		<li class="list-group-item">
        			<b>最后一次登录时间：</b><?=todate($row["last_login_time"])?>
        		</li>				
        		
        		<li class="list-group-item">
        			<b>登录IP：</b><?=$row["login_ip"]?>
        		</li>
				
        		<li class="list-group-item">
        			<b>最后一次登录IP：</b><?=$row["last_login_ip"]?>
        		</li>
        		<li class="list-group-item">
        			<b>累计登录次数：</b><?=$row["login_count"]?>
        		</li>
        	</ul>
        </div>
    </div>
</div>
<?=footer()?>
</body>
</html>