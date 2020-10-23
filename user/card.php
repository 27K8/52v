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
title("卡密生成");
head(6);
?>

 <div class="container" style="padding-top:70px;">
 
    <div class="col-xs-12 col-sm-12 col-lg-10 center-block" style="float: none;">

<!--卡密生成start-->
            <table class="table table-striped table-hover panel panel-info">
		        <thead>
                <tr>
                    <th>
                       <select id="card_vip" class="form-control">
                        <option value="1">VIP1</option>
        	    		<option value="2">VIP2</option>
        	    		<option value="3">VIP3</option>
                       </select>
                    </th>			
                    <th>
                       <select id="card_type_id" class="form-control">
                        <?php 
						
                        $result = execute("select * from tyys_card_type;");
                        while( $row = mysqli_fetch_array($result) ) {
                    		echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';	  
                    	}
        	    		?>
                       </select>
                    </th>
					
                    <th>
					   <select class="form-control" id="length">
                        <option value="8">8</option> 
						<option value="16">16</option>
						<option value="24">24</option>
        	    		<option value="32"  selected>32</option>
						<option value="40">40</option>
                       </select>
                    </th>
                    <th><input type="text" id="numbers" class="form-control" placeholder="生成数量" /></th>
                    <th>
					    <input type="submit" class="btn btn-primary" value="生成卡密" onClick="setcard()"/>
        		    </th>
				</tr>
                <tr>
			
				    <th>级别
				        <select id="vip" class="form-control">
						    <option value="-1">全部</option>
                            <option value="1">VIP1</option>
        		            <option value="2">VIP2</option>
        		            <option value="3">VIP3</option>
                        </select>
			        </th>

		        	<th>状态
		        	    <select id="status" class="form-control">
		        		    <option value="-1">全部</option>
							<option value="0">禁用</option>
							<option value="1">未使用</option>
                            <option value="2">已使用</option>
                        </select>
		        	</th>				
				
                    <th>类型
                       <select id="type" class="form-control">
					   <option value="-1">全部</option>
                        <?php
                        $result = execute("select * from tyys_card_type;");
                        while( $row = mysqli_fetch_array($result) ) {
                    		echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';	  
                    	}
        	    		?>
                       </select>
                    </th>
                    <th><input type="text" id="card_number" class="form-control" placeholder="卡号 或者 使用用户"/></th>
                    <th><button type="submit" class="btn btn-primary" onClick="getlistdata()">确定</button>
					<button type="submit" class="btn btn-primary" onClick="exportdata()">导出</button><a id="createInvote"></a></th>	
                      					
                </tr>
				</thead>
            </table>
			
			<div id="card"></div>
<!--卡密生成end-->
      	<table class="table table-striped table-hover panel panel-info">
		    <thead>
                <tr>
                    <th height="30"><strong>ID</strong></th>
                    <th><strong>卡号</strong></th>
                    <th><strong>类型</strong></th>
					<th><strong>限制</strong></th>
                    <th><strong>Uid</strong></th>
                    <th><strong>Uname</strong></th>
					<th><strong>Utime</strong></th>
					<th><strong>Uip</strong></th>
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
</div>

<script type="text/javascript">
function delone(otr,id){
    var res = window.confirm('确认删除ID为：'+id+'的卡密吗？');
    if (res) {
		$.post("card_data.php",
	    {
		  type:'delete',
	      id:id,
	    },
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
	var status,text,text2;
	if(otr.innerText=="停用"){
		status = 0;
		text= "禁用";
		text2="启用";
	}else if(otr.innerText=="启用"){
		status = 1;
		text="正常";
		text2= "停用";
	}else{
		return false;
	}
	$.post("card_data.php",
	    {
		  type:'edit',
	      id:id,
		  status:status,
	    },
	function(data){
	    if(data['code'] == 200){
			document.getElementById("td"+id).innerHTML = text ; 
			otr.innerText = text2 ;
	    }else{
			alert(data['msg']);
		}
		   
	},"json");
}

function setcard(){
	var number=$('#numbers').val();
	if(number == 0 || number == ""  || number > 100){
		alert("数量不能为空！ 或不能大于100");
		$('#numbers').focus();
		return false;
	}else{
		$.post("card_data.php",{card_type_id:$('#card_type_id').val(),card_vip:$('#card_vip').val(),length:$('#length').val(),number:number,},
		function(data){ if(data['code'] == 200){ $('#card').html(data['data']); }alert(data['msg']);},"json");
	}
}

function topage(p){
	getlistdata(p);
}

var filename="卡密";
function getlistdata(page = 1){
	$.post("card_data.php", {"referer":"", "time":"1523606146", "vip": $('#vip').val(), "status": $('#status').val(),"type":$('#type').val(),"card_number": $('#card_number').val(),"perNumber" :$('#perNumber').val(),"page":page},
    function(json){
		json = eval('(' + json + ')');
        if(json['code'] == 200){
			$('#tbMain').html(json['data']['list']);
			$('.pagination').html(json['data']['page']);
		    $('#perNumber').val(json['perNumber']);
			filename = $('#vip option:selected').text()+"-"+$('#status option:selected').text()+"-"+$('#type option:selected').text()+"-"+$('#perNumber').val()+"-"+page;
        }else{
            alert(json['msg']);
        }
    });//,"json"
}
function exportdata(){
	var text="";
    $(function() {
        $('#tbMain tr').find('td').each(function() {
            if ($(this).index() == "1") { // 假设要获取第二列的值
			text += $(this).text() + "\r\n"; 
            }
        });
    });
	if(text==""){
		alert("数据为空..");
	}else{
        var isIE = (navigator.userAgent.indexOf('MSIE') >= 0);
        if (isIE) {
             var strHTML = text;
             var winSave = window.open();
             winSave.document.open("text","utf-8");
             winSave.document.write(strHTML);
             winSave.document.execCommand("SaveAs",true,filename+".txt");
             winSave.close();
        } else {
             var elHtml = text;
             var mimeType =  'text/plain';
	    	 $('#createInvote').attr('download',filename+".txt");
             $('#createInvote').attr('href', 'data:' + mimeType  +  ';charset=utf-8,' + encodeURIComponent(elHtml));
             document.getElementById('createInvote').click();
        }
	}
}

getlistdata();
</script>  
<?=footer()?>
</body>
</html>

