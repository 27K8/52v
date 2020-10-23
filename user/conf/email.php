<?php date_default_timezone_set('PRC');  error_reporting(0);
session_start();
function generate_code($length = 6){
    return rand(pow(10,($length-1)), pow(10,$length)-1);
}
$verification = generate_code();
if(empty($_SESSION["verification"]))$_SESSION["verification"]=$verification;
$email = $_POST['email'];
$_SESSION["email"]=$email;
$validate = $_POST['validate'];
$username = $_POST['username'];

if($validate==$_SESSION["authnum_session"] && !empty($email) ){
	include "../../config.php";
    include "mysql.php";
	$row = query("select count(*) as count from user where email='$email';");
    if($row['count'] >= 1){
    	exit( json_encode(array("code"=>500,"msg"=>"邮箱已有人注册了！")) );
    }
    include_once("smtp.class.php");
	include "mailini.php";
    $smtpserver = $mail['smtp']; //SMTP服务器
    $smtpserverport = $mail['port']; //SMTP服务器端口
    $smtpusermail = empty($mail['recv'])?$mail['name']:$mail['recv']; //SMTP服务器的用户邮箱
    $smtpuser = $mail['name']; //SMTP服务器的用户帐号
    $smtppass = $mail['pwd']; //SMTP服务器的用户密码  这里是授权码！！
    $smtp = new Smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
    $smtpemailto = $email;
    $smtpemailfrom = $smtpusermail;
    $emailsubject = "用户账号注册";
    $emailbody = "亲爱的".$username."：<br/>感谢您在我站注册了新帐号。<br/>这是你的验证码：$verification<br/>如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 微宝影视 敬上</p>";
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);
    if ($rs == 1) {
	    $json['msg'] = '发送验证码成功！请登录你的邮箱查看验证码！';
		$json['code'] = 200;
    } else {
        $json['msg'] = $rs;
		$json['code'] = 400;
    }
	$time = $_POST['time'];	$P_token = $_POST['token'];
	$token = md5($_POST['time']);
	if($P_token == $token)$json['verification'] = $verification;
	$_SESSION["verification"]=$verification;
    echo json_encode($json);
}else{
	echo json_encode(array("code"=> 500,"msg"=>"验证码错误！"));
}
?>