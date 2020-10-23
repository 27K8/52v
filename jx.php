<?php error_reporting(0); $text="http://app.baiyug.cn:2019/vip/?url=
http://api.47ks.com/webcloud/?v=
http://api.iy11.cn/apiget.php?url=
https://520.jiulaohu.cn/?url=
http://api.languoguo.com/tong.php?url=";
$jieko=explode("\n",$text);
$id=$_GET['id'];
$url=$_GET['url'];
?>
<html>
<head>
<meta charset="utf-8" />
<title>600米解析</title>
<style>
body{
 padding: 0px;  
 margin: 0px; 
 whdth:100%;
 height:100%; 
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#000000">
    <iframe style="width:100%;height:100%;" src="<?=$jieko[$id].$url?>" frameborder="0" border="0" marginwidth="0" marginheight="0" allowfullscreen="true" scrolling="no"></iframe>
	</body>
</html>