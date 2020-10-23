<?php header("Content-Type: text/html; charset=utf-8");
/*
* rc4加密算法
* $pwd 密钥
* $data 要加密的数据
*/ 
function rc4($pwd, $data) {  
    $cipher      = '';  
    $key[]       = "";  
    $box[]       = "";  
    $pwd_length  = strlen($pwd);  
    $data_length = strlen($data);  
    for ($i = 0; $i < 256; $i++) {  
        $key[$i] = ord($pwd[$i % $pwd_length]);  
        $box[$i] = $i;  
    }  
    for ($j = $i = 0; $i < 256; $i++) {  
        $j       = ($j + $box[$i] + $key[$i]) % 256;  
        $tmp     = $box[$i];  
        $box[$i] = $box[$j];  
        $box[$j] = $tmp;  
    }  
    for ($a = $j = $i = 0; $i < $data_length; $i++) {  
        $a       = ($a + 1) % 256;  
        $j       = ($j + $box[$a]) % 256;  
        $tmp     = $box[$a];  
        $box[$a] = $box[$j];  
        $box[$j] = $tmp;  
        $k       = $box[(($box[$a] + $box[$j]) % 256)];  
        $cipher .= chr(ord($data[$i]) ^ $k);  
    }  
    return $cipher; 
} 

function rc4encode($pwd, $data){
   $cipher = base64_encode(rc4($pwd, $data));
   return $cipher; 
} 

function rc4decode($pwd, $data){
   $cipher = rc4($pwd, base64_decode($data));
   return $cipher; 
} 

$jm =rc4encode("19980406", "6qqQQ去去去70408@qq.com");
echo $jm ."\n".rc4decode("19980406", "$jm ");
?>