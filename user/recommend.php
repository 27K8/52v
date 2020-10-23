<?php
require "../config.php";
require_once "conf/mysql.php";
require_once '../api.inc.php';
// 公共函数文件
require ROOT."user/conf/function.php";

$username=$row["username"];
if(!empty($_GET['action'])){
	$row = query("select count(*) as count from tyys_user where recommend=$id;");
	$json['code']=200;$json['msg']="获取成功";
    exit(json_encode(array_merge($json,$row)));
}
$row=proving();
if(!empty($_POST['vip'])){
	
	$vip=$_POST['vip'];
	$day=$_POST['day'];
	
	$score = $day * ($vip=="1"?1:($vip=="2"?2:3));
	$expir_time = ( $row["expir_time"]>=time() ? $row["expir_time"] : time() )+ 60*60*24*$day;
	if($row["score"]>=$score && $row["vip"]==$vip){
		$score = $row["score"] - $score;
		$update = modifys("UPDATE tyys_user SET expir_time='$expir_time',score='$score' WHERE username='$username';");
	    if($update){
			$json['code']=200;$json['msg']="操作成功！ \n原来到期时间：".date("Y年m月d日 H:i:s",$row["expir_time"])."\n增加天数$day : ".date("Y年m月d日 H:i:s",$expir_time);
			$_SESSION["score"] = $score;
            $_SESSION["expir_time"]=$expir_time;
	    }else{
			$json['code']=400;$json['msg']="未知错误！";
		}		
	}else{
		$json['code']=400;
		$json['msg']="积分不足 或者 不能跨VIP等级兑换时间";
	}
    exit(json_encode($json));
}

title("推荐");
head(3);
function todate($time) { 
   return date("Y年m月d日 H:i:s",$time);
}
?>
<script>
   var vip="1";
   $(document).keypress(function(e) { 
    // 回车键事件 
        if(e.which == 13) { 
	        $.post("",{vip:vip,day:$('#day').val(),},function(data){	if(data['code']==200)window.location.href="./"; alert(data['msg']); },"json");
        } 
   });
</script>
	
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 center-block" style="float: none;">
     
        <div class="panel panel-info">
		    <?php if($_GET['Ranking']=='Ranking'){
				echo '        	<div class="panel-heading">
        		<h3 class="panel-title">排行信息</h3> <a href="?"><span class="glyphicon glyphicon-arrow-left" style="float:right;margin-top: -18px;">返回</span></a>
        	</div>';
				
				//include "conf/mysql.php";
				$result = execute("SELECT COUNT(a.create_ip) as count,COUNT( DISTINCT a.create_ip ) as valid, a.recommend,b.username FROM tyys_user as a JOIN tyys_user as b ON a.recommend=b.id GROUP BY a.recommend having a.recommend!=null or a.recommend!=0 order by valid desc;");
                echo '
			<table class="table table-striped table-hover panel panel-info">
		        <thead>	

                <tr>
                    <th height="30"><strong>ID</strong></th>
					<th><strong>用户名</strong></th>
                    <th><strong>一共</strong></th>
                    <th><strong>有效</strong></th>
                </tr>	
        
                </thead>
				<tbody>';
                while ( $row = mysqli_fetch_array($result) ) {
                    echo '
					<tr>
                    <td height="20">'.$row['recommend'].'</td>
					<td height="20">'.$row['username'].'</td>
                    <td>'.$row['count'].'</td>
                    <td>'.$row['valid'].'</td>
                </tr>';			
        	    }
			echo '
			</tbody>		
            </table>
';	
		   }else{?>
		
        	<div class="panel-heading">
        		<h3 class="panel-title">推荐信息  
				<button type="button" id="Refresh" style="width:80px;float:right;margin-top: -8px;margin-bottom: 0px;" class="btn btn-primary form-control">刷新</button>
				<a href="?Ranking=Ranking"><button type="button" style="width:80px;float:right;margin-top: -8px;margin-bottom: 0px;margin-right:10px;" class="btn btn-primary form-control">排行</button></a></h3>
        	</div>
        	<ul class="list-group">
        		<li class="list-group-item">
        			<b>邀请你的用户：</b><?=$row["recommend"]==""||$row["recommend"]=="0"?"无":$row["recommend"];?>
        		</li>
				
        		<li class="list-group-item">
        			<b>已推荐人数：</b><span id="recommend"></span>
        		</li>
				
        		<li class="list-group-item">
        			<b>你的推荐链接：</b><a href="<?=$siteurl?>register.php?id=<?=$row["id"]?>" ><?=$siteurl?>register.php?id=<?=$row["id"]?></a>
        		</li>

				
				<li class="list-group-item">
        			<b>积分：</b><?=$row["score"]?>
        		</li>
				
				<li class="list-group-item">
        			<b>积分兑换规则：</b>VIP1：1积分 1天 VIP2：2积分 1天 VIP3：3积分 1天
        		</li>
				
				<li class="list-group-item">
				    <select name="vip" placeholder="积分兑换" class="form-control" style="width:80px; float:left;" >
		                <option selected value="1">VIP1</option>
				    	<option value="2">VIP2</option>
						<option value="3">VIP3</option>
				    </select>
					<span id="info" style="float:right;height:32px;line-height:32px"></span>
					<input id="day"  name="day" class="form-control" style="width:100px;" placeholder="兑换天数" onkeyup="value=value.replace(/[^\d]/g,'')" required />
				</li>

				<li class="list-group-item">
        			<b>1.您的专属推荐ID号：</b> <?=$row["id"]?>
        		</li>
				
				<li class="list-group-item">
        			<b>2.邀请好友注册时填写您的ID双方都会增加天数</b>
        		</li>

				<li class="list-group-item">
        			<b>3.邀请码被填写一次可奖励3天会员,邀请每满30人即可获得半年会员！</b>
        		</li>

				<li class="list-group-item">
        			<b>4.恶意刷邀请人数会被清空数据！</b>
        		</li>
            <?php } ?>				
        	</ul>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){ //在文档加载后激活函数：
   $('#Refresh').click(function(){
    	recommend();
   });
   $('select').click(function(){
   	    vip = $(this).val();
	    info();
   }); 
   $('#day').bind('input propertychange', function() {  
        info();	  
   }); 

   recommend();   
});

function info() { 
     if(vip==1){
	    $("#info").html( '所需：'+$('#day').val() * 1);
    }else if(vip==2){
	    $("#info").html( '所需：'+$('#day').val() * 2);	
	}else{
		$("#info").html( '所需：'+$('#day').val() * 3);
	}	
}
 
function recommend(){
    $("#Refresh").button('loading');
    $.post("?action=save",{},
      function(data){
  	    if(data['code']==200){
  	    	$("#recommend").html(data['count']);
  	    }else{
			alert(data['msg']);
		}
          $("#Refresh").button('reset');
      },"json");
}
</script>
<?=footer()?>
</body>
</html>