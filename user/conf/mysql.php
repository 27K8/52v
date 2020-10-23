<?php
function query($sql){
	global $dbconfig;
	@ $conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname']) or die("数据库连接失败，失败信息:".mysqli_connect_error($conn)); 
	mysqli_set_charset($conn,"utf8");	
	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_array($result);
    mysqli_free_result($result);  //查询完后要释放该表 	
	mysqli_close($conn);//关闭数据库
	return $row;
}

function execute($sql){
	global $dbconfig;
    @ $conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname']) or die("数据库连接失败，失败信息:".mysqli_connect_error($conn));
	mysqli_set_charset($conn,"utf8");
	$result = mysqli_query($conn,$sql);
	mysqli_close($conn);//关闭数据库
	return $result;
}

function modifys($sql){
	global $dbconfig;
    @ $conn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname']) or die("数据库连接失败，失败信息:".mysqli_connect_error($conn));
    mysqli_set_charset($conn,"utf8");
    mysqli_query($conn,$sql);
	$code=mysqli_affected_rows($conn);
	if($code>0){
	 	return true;
	}else{
	 	return false;
	}
	mysql_close($con);//关闭数据库	
}
?>