<?php include "function.php";
if(isset($_GET['logout'])){
	setcookie("token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('您已成功注销本次登陆！');window.location.href='./login.php';</script>");
}elseif(($_COOKIE['token']==$token)){
	exit("<script language='javascript'>alert('您已登陆！');window.location.href='./';</script>");	
}elseif(!empty($_GET['action'])){
	if(empty($_POST['user']) or empty($_POST['pass'])){
		echo '喝多了？啥都不写你想干啥？？？<br/>';
	}else{
		if($_POST['user']==$admin_user && $_POST['pass']==$admin_pwd){
			$tokenjm=md5($admin_user.md5($admin_pwd).'tyys');
			/**/echo '<script language="javascript" type="text/javascript">
					document.cookie="token='.$tokenjm.'";
           			window.location.href="index.php";
    			</script>'; 
		}else
			echo '非管理员禁止进入！！！<br/>';
	}
	exit();	 
}	

title('登录');
?>
   <script>
   $(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#login").click(); 
       } 
   }); 
	$(document).ready(function(){
	  $('#login').click(function(){
	  	$("#login").button('loading');
	    $.post("login.php?action=save",
	    {
	      user:$('#user').val(),
	      pass:$('#pass').val(),
	    },
	    function(data,status){
	      $("#login").button('reset');
	      $('#result').html(data);
	    });
	  });
	});
	</script>
<body>	
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../">返回首页</a>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="./login.php"><span class="glyphicon glyphicon-user"></span> 登陆</a>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
  
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">用户登陆</h3></div>
        <div class="panel-body">
		    <p id="result" style="color:red;text-align:center;"></p>
            <form action="./login.php" method="post" class="form-horizontal" role="form">
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input id="user" type="text" name="user" value="<?php echo @$_POST['user'];?>" class="form-control" placeholder="用户名" required="required"/>
                </div><br/>
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input id="pass" type="password" name="pass" class="form-control" placeholder="密码" required="required"/>
                </div><br/>
                <div class="form-group">
                  <div class="col-xs-12">
		  	     <button type="button" class="btn btn-primary form-control" id="login" data-complete-text="Loading finished">登陆后台</button>
		  	    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

<?=footer()?>
</body>
</html>