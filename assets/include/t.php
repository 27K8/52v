<?php
$json= file_get_contents("http://api-t-sina.mouto.org/sorturl.php?url=".urlencode($_GET['long_url']));
$url_short = $json;
$type = 0;
echo json_encode(array("url_short"=>"$url_short","type"=>"$type"));
?>