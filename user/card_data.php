<?php error_reporting(0);
session_start();    
$REFERER=$_SERVER['HTTP_REFERER'];
$HOST=$_SERVER['SERVER_NAME']; //v.nyqty.com
$uriarr = parse_url($REFERER);
if($uriarr['host']==$HOST)$is_referer=true;
else $is_referer=false;

if(!$is_referer)exit(json_encode(array("code"=>400,"msg"=>null)));
if($_SESSION["vip"]<99)exit("禁止访问！");

$username=$_COOKIE['username'];
$tokens = $_COOKIE['tokens'];
$skey=md5($username."TYyingshi&http://$HOST/$tokens");
if($_COOKIE['skey']!=$skey)exit('<script type="text/javascript">window.location.href="login.php";</script>');
    
	include "../config.php";
    include "conf/mysql.php";
    $type = $_POST['type'];
    $id=intval($_POST['id']);
if($type=='delete' && $id!=0){
	$delete = modifys("delete from tyys_card where id='$id';");
    $json['code']=$delete?200:0;$json['msg']=$delete?"删除成功":"删除失败";
    exit(json_encode($json));
}elseif($type=='edit' && $id!=0){
	$status=intval($_POST['status']);
	$update = modifys("UPDATE tyys_card SET status='$status' WHERE id='$id';");
    $json['code']=$update?200:0;$json['msg']=$update?"修改成功":"修改失败";
    exit(json_encode($json));
}

    $card_type_id = $_POST['card_type_id'];
	$card_vip = $_POST['card_vip'];
	$length = intval($_POST['length']);
    $number=intval($_POST['number']);
	$length=$length<8?32:$length;
if(!empty($card_type_id) && !empty($number) && !empty($card_vip)){
    $INSERT = "INSERT INTO `tyys_card` (`id`,`card_number`,`card_type_id`,`card_vip`,`use_user_id`,`use_user`,`use_time`,`use_ip`,`status`) VALUES\n";
    for($i=0;$i<$number;$i++){
        $card_number = randCode($length);
        $INSERT.="(null, '$card_number','$card_type_id',$card_vip,null,null,0,null,1)".($number-1==$i?";":",\n");
		$data.= "<li class='list-group-item'>{$card_number}</li>";
    } 	
	$installs = modifys($INSERT);
    $json['code']=$installs?200:0;$json['msg']=$installs?"生成卡密成功":"生成失败了！";
	$json['data']=$data;
    exit(json_encode($json));
}
function randCode($len = 32){
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str)- 1;$randstr = '';
    for ($i=0;$i<$len;$i++)$randstr .= $str[mt_rand(0, $strlen)];
    return $randstr;
}


$vip=$_POST['vip']==''?-1:intval($_POST['vip']);
$status=$_POST['status']==''?-1:intval($_POST['status']);
$type=$_POST['type']==''?-1:intval($_POST['type']);
$card_number=$_POST['card_number'];

$where=$card_number?"(card_number like '%$card_number%' or use_user like '%$card_number%')":1;
$where.=$vip==-1?'':" and card_vip='$vip'";
$where.=$status==-1?'':" and tyys_card.status='$status'";
$where.=$type==-1?'':" and card_type_id='$type'";

$perNumber=intval($_POST['perNumber']);//每页显示的记录数
$perNumber = $perNumber<10?30:$perNumber;
$page=intval($_POST['page'])<1?1:intval($_POST['page']); //获得当前的页面值
$rs=query("select count(*) as count from tyys_card where $where");//获得记录总数
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数

if(!isset($page))$page=1;
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$field="tyys_card.id,card_number,name,card_vip,use_user_id,use_user,use_time,use_ip,tyys_card.status,unit";//字段列表
$result = execute("select $field FROM tyys_card JOIN tyys_card_type ON tyys_card.card_type_id=tyys_card_type.id where $where ORDER BY tyys_card.id asc limit $startCount,$perNumber;");//根据前面的计算出开始的记录和记录数
    while( $row = mysqli_fetch_array($result) ) {
      $list.= '
      <tr>
        <td>'.$row['id'].'</td>
        <td>'.$row['card_number'].'</td>
        <td>'.$row['name'].'</td>
		<td>'.($row['unit']=="score"?"∞":$row['card_vip']).'</td>
        <td>'.$row['use_user_id'].'</td>
        <td>'.$row['use_user'].'</td>
        <td>'.($row['use_time']==0?'':date('Y-m-d',$row['use_time'])).'</td>
        <td>'.$row['use_ip'].'</td>
		<td id="td'.$row['id'].'">'.($row['status']==1?"正常":($row['status']==2?"已使用":"禁用")).'</td>
		<td>
		    <a class="label label-success" href="javascript:;" onClick="edit(this,\''.$row['id'].'\')">'.($row['status']==1?"停用":($row['status']==2?"":"启用")).'</a> 
			<a href="javascript:;" class="label label-danger" onclick="delone(this,\''.$row['id'].'\')" >删除</a></td>
      </tr>';
	}
	
include "conf/page.php";
$pagetext='
        <li>
            <select id="perNumber" style="height: 32px;" onchange="getlistdata()"> 
                <option value="10">10</option>
        	    <option value="30">30</option>
        	    <option value="50">50</option>
        	    <option value="70">70</option>
        	    <option value="100">100</option>
            </select>
        </li>
        <li>共<strong>'.$totalNumber.'</strong></li>';
$pagetext.=page($page,$totalPage,"javascript:");
echo json_encode(array("code"=>200,"msg"=>"","totalNumber"=>$totalNumber,"perNumber"=>$perNumber,"data"=>array("page"=>$pagetext,"list"=>$list)));	
	
?>