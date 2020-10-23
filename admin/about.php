<?php include "function.php";
title("关于程序");
head(4);
if($_COOKIE['token']!=$token)exit('<script type="text/javascript">window.location.href="login.php";</script>');
?>
  <div class="container" style="padding-top:70px;">
   <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
  							
		<div class="row">
			<div class="col-md-12">
			<div class="panel panel-info">
					<div class="panel-heading"><span class="glyphicon glyphicon-cog"></span> 关于程序</div>
					<div class="panel-body box">
					<div class="alert alert-warning">本程序是来自微宝科技编写 仅供学习参考 切勿用于一切非法活动！QQ3213145200<br>
					更新功能暂未完善 请各位站长自行对比版本</div>
					<div class="alert alert-success"><font color="green">感谢您使用微宝影视本地后台程序！</font><br><font color="red">当前版本：V1.0</font></div>
					<iframe src="http://aty.pw/admin/readme1.0.txt" style="width:100%;height:250px;"></iframe>				
<?php
if(isset($_GET['install'])){
	if(ini_get('allow_url_fopen') &&class_exists('ZipArchive'))	{
		if($file = file_get_contents('http://aty.pw/admin/update.zip')){
			echo '<h4>下载程序成功</h4>';
		}else{
			echo '<h4>下载程序失败</h4>';
			exit;
		}
		if(file_put_contents('update.zip',$file)){
			echo '<h4>保存程序成功 最新更新压缩包目录/inc/update.zip</h4>';
			showmsg('下载时成功！',1);
		}else{
			echo '<h4>保存程序失败！<br/>可能脚本没有写入权限。</h4>';
		}
		echo '<p><a href="./">点击这里返回</a><hr/><pre>'.file_get_contents('/readme.txt').'</pre></p>';
	}else{
		echo '    <p>
     由于功能问题，该脚本无法在您的空间运行。<br/>
     错误：无法打开远程文件或<b>ZipArchive</b>类不存在！
   </p>';
	}
}
?>		    <a class="btn btn-primary btn-block" type="button" href="<?php echo $_SERVER['PHP_SELF'].'?install' ?>" >点击自动更新</a></div>

			</div><!--/.col-->
			</div>
		</div><!--/.row-->
				</div> </div>
			
   
<?=footer()?>
</body>
</html>