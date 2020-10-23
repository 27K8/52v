<?php date_default_timezone_set('PRC'); error_reporting(0);

    $email = $_POST['email'];
    $title = $_POST['title'];
    $text = $_POST['text'];
	
    $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式  
    if(!preg_match($checkmail,$email)){  
       	$json['code'] = 400;
        $json['msg'] = "电子邮箱格式不正确";	
       exit(json_encode($json));
    }   	
	
if(!empty($email) && !empty($title) && !empty($text)){
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
    $emailsubject = $title;
    $emailbody = $text;
    $rs = $smtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);
    if ($rs == 1) {
		$json['code'] = 200;
	    $json['msg'] = '发送验证码成功！请登录你的邮箱查看验证码！';
    } else {
		$json['code'] = 400;
        $json['msg'] = $rs;
    }
    echo json_encode($json);
}
?>