<?php
require_once '../api.inc.php';
// 公共函数文件
require "conf/function.php";
title("充值");
head(4);
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
		        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">卡密兑换</h3></div>
            <div class="panel-body">
              <form action="" method="post" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
			  <input name="username" id="username" class="form-control" value="<?=$_COOKIE["username"]?>" placeholder="输入需要充值的用户" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-credit-card"></span></span>
              <input name="card_number" id="card_number" class="form-control"  placeholder="卡密" required />
            </div><br/>
	
            	<div class="form-group">
            	  <div class="col-xs-12"><input type="button" id="button" value="充值" class="btn btn-primary form-control" required /><br/>
            	 </div>
            	</div>
              </form>
			  
			    <div class="form-group">
            	  <div class="col-xs-12"> <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3213145200&amp;site=qq&amp;menu=yes"><input type="button" value="卡密购买" class="btn btn-primary form-control" /></a><br/>
            	 </div>
            	</div>
				
            </div>
	    </div>

    </div>
</div>

<script> 
$(document).keypress(function(e) { 
    // 回车键事件 
    if(e.which == 13) { 
   		jQuery("#button").click(); 
       } 
}); 

$(document).ready(function(){ //在文档加载后激活函数：
    $('#button').click(function(){
    	if($('#username').val() == ""){
    		alert("用户名不能为空！！");
    		$('#username').focus();
    		return false;
    	}
    	if($('#card_number').val() == ""){
    		alert("卡密不能为空！");
    		$('#card_number').focus();
    		return false;
    	}
		
        $("#button").button('loading');
		$.post("api.php", {type:'recharge',username:$('#username').val(),card_number:$('#card_number').val()},
        function(json){
            if(json['code'] == 200){
	    		$('#card_number').val("");
            }
			alert(json['msg']);
		$("#button").button('reset');
        },"json");
	});
});
</script>
<?=footer()?>
</body>
</html>