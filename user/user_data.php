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
	$delete = modifys("delete from tyys_user where id='$id';");
    $json['code']=$delete?200:0;$json['msg']=$delete?"删除成功":"删除失败";
    exit(json_encode($json));
}elseif($type=='edit' && $id!=0){
	$status=intval($_POST['status']);
	$update = modifys("UPDATE tyys_user SET status='$status' WHERE id='$id';");
    $json['code']=$update?200:0;$json['msg']=$update?"修改成功":"修改失败";
    exit(json_encode($json));
}

$vip=$_POST['vip']==''?-1:intval($_POST['vip']);
$status=$_POST['status']==''?-1:intval($_POST['status']);
$expir=$_POST['expir']==''?-1:intval($_POST['expir']);
$text=$_POST['text'];

$where=$text?"(username like '%$text%' or email like '%$text%')":1;
$where.=$vip==-1?'':" and vip='$vip'";
$where.=$status==-1?'':" and status='$status'";
$where.=$expir==-1?'':" and expir_time".($expir==1?">":"<").time();

$perNumber=intval($_POST['perNumber']);
$perNumber = $perNumber<10?30:$perNumber;
$page=intval($_POST['page'])<1?1:intval($_POST['page']); //获得当前的页面值
$rs=query("select count(*) as count from tyys_user where $where");//获得记录总数
$totalNumber=$rs[0];
$totalPage=ceil($totalNumber/$perNumber); //计算出总页数

if (!isset($page))$page=1;
$startCount=($page-1)*$perNumber; //分页开始,根据此方法计算出开始的记录
$result = execute("select * from tyys_user where $where ORDER BY id asc limit $startCount,$perNumber;");
 while ( $row = mysqli_fetch_array($result) ) {
    $list.= '
    <tr>
        <td height="20">'.$row["id"].'</td>
		<td>'.$row["username"].'</td>
        <td>'.$row["vip"].'</td>
        <!--<td>'.$row["password"].'</td>-->
		<td>'.$row["recommend"].'</td>
        <td>'.$row["email"].'</td>
        <td>'.$row["score"].'</td>
		<td>'.date("Y年m月d日 H:i:s",$row["expir_time"]).'</td>
		<td><a class="label label-'.($row["status"]==1?"success":"danger").'" href="javascript:;" onclick="edit(this,\''.$row["id"].'\')">'.($row["status"]==1?"正常":"禁用").'</a></td>
		<td>
		    <a class="label label-success" href="?id='.$row["id"].'" >编辑</a>
			<a href="javascript:;" class="label label-danger" onclick="delone(this,\''.$row['id'].'\')" >删除</a></td>
		</td>
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