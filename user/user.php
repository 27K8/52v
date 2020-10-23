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
if($row["vip"]<99){
	exit("禁止访问！");
}
title("用户管理");
head(5);
?>
<div class="container" style="padding-top:70px;"> 
<?php $id=$_GET['id'];
if(empty($id)){?>
	 <div class="col-xs-12 col-sm-12 col-lg-10 center-block" style="float: none;">
	
           <table class="table table-striped table-hover panel panel-info">
		        <thead>	
		        	<tr>
				        <th>
				            VIP级别：
				            <select id="vip" class="form-control">
							    <option value="-1">全部</option>
								<option value="0">试看用户</option>
                                <option value="1">VIP1</option>
        		                <option value="2">VIP2</option>
        		                <option value="3">VIP3</option>
                            </select>
			            </th>
		        		<th>
		        		    状态筛选：
		        		    <select id="status" class="form-control">
		        			    <option value="-1">全部</option>
								<option value="1">正常</option>
                                <option value="0">禁用</option>
                            </select>
		        	    </th>
		        		<th>
		        		    到期筛选：
                            <select id="expir" class="form-control">
		        			    <option value="-1">全部</option>
								<option value="1">未到期</option>
								<option value="2">到期</option>
                            </select>
		        		</th>
		        		<th><input type="text" id="text" class="form-control" placeholder="邮箱 或者 用户名" /></th>
		        		<th><input type="submit" class="btn btn-primary" value="确定" onClick="getlistdata()"/></th>
		        	</tr>
		        </thead>
            </table>
       
        <table class="table table-striped table-hover panel panel-info">
		    <thead>
                <tr>
                    <th height="30"><strong>ID</strong></th>
			    	<th><strong>用户名</strong></th>
                    <th><strong>VIP等级</strong></th>
                    <!--<th><strong>密码</strong></th>-->
			    	<th><strong>推荐人</strong></th>
                    <th><strong>邮箱</strong></th>
                    <th><strong>积分</strong></th>
			    	<th><strong>到期时间</strong></th>
			    	<th><strong>状态</strong></th>
			    	<th><strong>操作</strong></th>
                </tr>
			<thead>
            <tbody id="tbMain">			
            </tbody>
        </table>
		
		<ul class="pagination">
		</ul>	
    </div>
<?php
}else{	
	echo '       
	<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">';	
	//include "conf/mysql.php";
	if(empty($_POST['submit'])){
	    $row = query("select * from tyys_user where id='$id';");
	    if($id!=$row["id"]){
	    	exit(showmsg("没有此用户！",4));
	    }else{
			$username=$row["username"];
	    }
?> 
        <div class="panel panel-primary">
            <div class="panel-heading"><h3 class="panel-title">修改<?=$username?>信息</h3></div>
            <div class="panel-body">
              <form action="" method="post" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">用户</span>
			  <input name="username" class="form-control" value="<?=$username?>" placeholder="<?=$username?>" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">密码</span>
              <input name="password" class="form-control"  placeholder="密码" value="<?=$row["password"]?>" required />
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">vip等级</span>
              <input name="vip" class="form-control" placeholder="vip等级" value="<?=$row["vip"]?>" required />
            </div><br/>
			
            <div class="input-group">
              <span class="input-group-addon">邮箱</span>
              <input name="email" class="form-control" placeholder="邮箱地址" value="<?=$row["email"]?>" required />
            </div><br/>				
            <div class="input-group">
              <span class="input-group-addon">积分</span>
              <input name="score" class="form-control" placeholder="积分" value="<?=$row["score"]?>" required />
            </div><br/>	
            <div class="input-group">
              <span class="input-group-addon">到期时间</span>
              <input name="expir_time" class="form-control" placeholder="积分" value="<?=date("Y-m-d H:i:s",$row["expir_time"])?>" required />
            </div><br/>		
            <div class="input-group">
              <span class="input-group-addon">到期时间</span>
		            <select name="status" class="form-control">
                        <option value="1" >正常</option>
                        <option<?=$row[0]['status']==0?' selected':'';?> value="0">禁用</option>
                    </select>
            </div><br/>			

			<div class="col-xs-12">
            	<input type="submit" name="submit" value="修改" class="btn btn-primary form-control" required /><br/>
            </div>
              
			 </form>
            </div>
	    
<?php
            }else{
				$username=$_POST['username'];
				$password=$_POST['password'];
				$vip=$_POST['vip'];
				$email=$_POST['email'];
				$score=$_POST['score'];
				$expir_time=strtotime( $_POST['expir_time'] );
				$status=$_POST['status'];
				$text = (empty($username)?"":"username='$username'").(empty($password)?"":",password='$password'").(empty($vip)?"":",vip='$vip'").(empty($email)?"":",email='$email'").(empty($score)?"":",score='$score'").(empty($expir_time)?"":",expir_time='$expir_time',status='$status'");
				$update = modifys("UPDATE tyys_user SET $text WHERE id='$id';");
		        if($update){showmsg("修改成功！",1);}else{showmsg("修改失败！",3);}		
            }
	echo '
	</div>';
} 
?>	
      
</div>
<script type="text/javascript">
function delone(otr,id){
    var res = window.confirm('确认删除ID为：'+id+'的用户吗？');
    if (res) {
		$.post("user_data.php",{type:'delete',id:id,},
	    function(data){
	    	if(data['code'] == 200){
	    		var a=otr.parentNode.parentNode;  
                a.parentNode.removeChild(a);  	
	    	}else{
				alert(data['msg']);
			}
	    },"json");
    }
}
		
function edit(otr,id){
	var status,text;
	if(otr.innerText=="正常"){
		status = 0;
		text= "禁用";
	}else if(otr.innerText=="禁用"){
		status = 1;
		text="正常";
	}else{
		return false;
	}
	$.post("user_data.php",{type:'edit',id:id,status:status,},
	function(data){
	    if(data['code'] == 200){
			
			otr.className="label label-"+(status==0?"danger":"success");
			otr.innerText = text ;
	    }else{
			alert(data['msg']);
		}
		   
	},"json");
}
function topage(p){
	getlistdata(p);
}

function getlistdata(page = 1){
	$.post("user_data.php", {"referer":"", "time":"1523606146", "vip": $('#vip').val(), "status": $('#status').val(),"expir":$('#expir').val(),"text": $('#text').val(),"perNumber" :$('#perNumber').val(),"page":page},
    function(json){
        if(json['code'] == 200){
			$('#tbMain').html(json['data']['list']);
			$('.pagination').html(json['data']['page']);
		    $('#perNumber').val(json['perNumber']);
        }else{
            alert(json['msg']);
        }
    },"json");
}
getlistdata();
</script> 

<?=footer()?>
</body>
</html> 
