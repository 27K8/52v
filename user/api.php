<?php date_default_timezone_set('PRC'); error_reporting(0);
function get_client_ip($type = 0) { 
   $type = $type ? 1 : 0; static $ip  =  NULL;    
   if ($ip !== NULL) return $ip[$type];    
   if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
       $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);  $pos = array_search('unknown',$arr);        
       if(false !== $pos) unset($arr[$pos]); $ip = trim($arr[0]);    
   }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) { 
       $ip = $_SERVER['HTTP_CLIENT_IP'];    
   }elseif (isset($_SERVER['REMOTE_ADDR'])) {  
       $ip = $_SERVER['REMOTE_ADDR']; }    // IP地址合法验证    
   $long = sprintf("%u",ip2long($ip));  
   $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
   return $ip[$type];
}

$P_token = 1;
$token = 1;
$type=$_POST['type'];

if( $P_token == $token ){
	include "../config.php";
	include "conf/mysql.php";
	$username = $_POST['username'];
	$password = $_POST['password'];
	$recommend = $_POST['recommend'];
        switch($type) {
        	case 'login':
				$row = query("select * from tyys_user where username='$username' or email='$username';");
	            if(($username==$row["username"] or $username==$row["email"]) && $password==$row["password"] && !empty($row["username"])){
					if($row['status']!=1)exit(json_encode(array("code"=>403,"msg"=>"抱歉你的账号已被管理员禁用！")));
					$time=time();
					$ip = get_client_ip();
					$last_login_time = $row['login_time'];
					$last_login_ip = $row['login_ip'];
					if($username!=$row["username"]){$username=$row["username"];}
	                $UPDATE = modifys("UPDATE tyys_user SET login_time='$time',login_ip='$ip',last_login_time='$last_login_time',last_login_ip='$last_login_ip',login_count=login_count+1 WHERE username='$username' and password='$password';");					
					$json['code']=$UPDATE?200:0;$json['msg']=$UPDATE?"登录成功!":"更新数据失败！请联系管理员修复！";
					$json = array_merge_recursive($json,$row );
	            }elseif( ($username==$row["username"] or $username==$row["email"] ) && !empty($row["username"])){
		        	$json['code']=0;$json['msg']="密码错误！";
	            }else{
		        	$json['code']=0;$json['msg']="该用户不存在！";
	            }
            break;
			
        	case 'register':
			    include "conf/registerini.php";$email = $_POST['email'];  
                $checkmail="/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/";//定义正则表达式  
                if(!preg_match($checkmail,$email)){  
                   	$json['code'] = 0;
                    $json['msg'] = "电子邮箱格式不正确";	
                   exit(json_encode($json));
                }
                if(($_SESSION["verification"]==$verification && $_SESSION["email"]==$email) || $register['limit']=="0" || $register['limit']=="2"){		
	                $vip = $register['Gift_vip'];$score = floatval($register['Gift_score']);$day=floatval($register['Gift_day']);
		            $score2 = floatval($register['Gift_score2']);$day2= floatval($register['Gift_day2']);
		            $create_ip = get_client_ip();
		            $text=$register['limit']=="2" || $register['limit']=="3"?" or create_ip='$create_ip'":"";
		            $row = query("select * from tyys_user where username='$username' or email='$email'$text;");
                    if($username==$row['username']){
    	            	exit( json_encode(array("code"=>0,"msg"=>"用户已经存在！")) );
    	            }elseif($email==$row['email']){
    	            	exit( json_encode(array("code"=>0,"msg"=>"邮箱已有人注册了！")) );
    	            }elseif($create_ip==$row['create_ip']){
    	            	exit( json_encode(array("code"=>0,"msg"=>"此位置已经有人占据了！")) );
    	            }
		            
		            $Rid='null';$expir_time=0;
		            if(!empty($recommend)){
                        $row = query("select * from tyys_user where id='$recommend' or username='$recommend';");
                        if($recommend==$row['id'] || $recommend==$row['username']){
		            		$recommend=$row['username'];$Rid=$row['id'];
		            	    $day +=floatval($register['Gift_day1']);
		            		$score += floatval($register['Gift_score1']);
		                }else{$Rid='null';$expir_time=0;}
		            }
                    $create_time=time();
                    $expir_time += $create_time + (60*60*24)*$day;
                    $sqr="INSERT INTO `tyys_user`(`id`, `username`, `password`, `vip`, `recommend`, `email`, `score`, `create_time`, `create_ip`, `expir_time`) VALUES ";
                    $sqr.="(null, '$username', '$password', $vip, $Rid, '$email', $score, $create_time, '$create_ip', $expir_time);";
		            $installs = modifys($sqr);
                    if($installs){
		            	$json['code']=200;$expir_time = (60*60*24)*$day2;
		            	if($Rid!='null'){$update = modifys("UPDATE tyys_user SET ".($vip==$row['vip']?"expir_time=expir_time+$expir_time,score=score+$score2":"score=score+".floatval($register['Gift_score3']))." WHERE username='$recommend' and id='$Rid';");}
		            	$json['msg']="注册成功！系统赠送你 $day 天 VIP$vip 积分$score 免费畅享影视！".($update?"用户$recommend 向你推荐本网站获得".($vip==$row['vip']?"VIP$vip 奖励天数$day2 天 积分$score2":"积分".$register['Gift_score3']):"");
		            }else{
		            	$json['code']=0;$json['msg']="注册失败，请重新注册？请联系截屏管理员！\n$sqr";
		            }
                }else{
                	$json['code']=0;$json['msg']="邮箱验证失败！";
                }
	            exit(json_encode($json));
            break;
			
			case 'recommend':			
	            $row = query("select COUNT(create_ip) as count,COUNT( DISTINCT create_ip ) as valid from tyys_user where recommend='$recommend' and recommend!=null or recommend!=0;");
	            $json['code']=200;$json['msg']="获取成功";$json=array_merge($json,$row);
			break;
			case 'ranking':
				$result = execute("SELECT COUNT(create_ip) as count,COUNT( DISTINCT create_ip ) as valid, recommend as id FROM tyys_user GROUP BY recommend having id!=null or id!=0 order by valid desc;");
	            $json['code']=200;$json['msg']="获取成功";
				$i=0;
				while ( $row = mysqli_fetch_array($result) ) {
                    $json['data'][$i]=	$row;
					$i+=1;
        	    }
			break;
			
			case 'recharge':
	            $card_number = urldecode($_POST['card_number']);
	            $row = query("select * from tyys_card where card_number='$card_number';");
	            $card_type_id=$row['card_type_id'];
	            $card_vip=$row['card_vip'];
	            $status=$row['status'];
	            if($card_number==$row['card_number'] && !empty($card_number)){
	            	if($status==1){
	            	    $rows = query("select * from tyys_card_type where id='$card_type_id';");
	            	    if($rows['id']==$card_type_id){
	            			$name=$rows['name'];
	            			$value=$rows['value'];
	            			$unit=$rows['unit'];
	            	        $comment=$rows['comment'];	            			
	            			switch($unit) {
                                //case 'day':
                                //break;
                                case 'month':
	            				    $day = 30*$value;
	            					$expir_time = 60*60*24*$day;
                                break;
                                case 'year':
	            				    $day = 365*$value;
	            					$expir_time = 60*60*24*$day;
                                break;
                                case 'score':
	            					$score = $value;
                                break;				
                                default:
	            				    $day = $value;
	            					$expir_time = 60*60*24*$day;				
	            			}
	                        $user = query("select * from tyys_user where username='$username';");
	            			if($user['username']==$username){
								$expir_time += ( $user['expir_time']>=time() ? $user['expir_time'] : time() );
							    $score += $user['score'];
	            				$vip=$user['vip'];
	            				if($card_vip==$vip || $unit=="score"){
	            				    $userid=$user['id'];
	            				    $update = modifys("UPDATE tyys_user SET ".($unit=="score"?"score='$score'":"expir_time='$expir_time'")." WHERE username='$username';");
	            				    
	                                if($update){
	            			        	if($unit=="score"){
	            			        		$msg="操作成功！ \n积分：".$user['score']."\n增加积分$value 共：$score";
	            			        	}else{
	            			        		$msg="操作成功！ \n原来到期时间：".date("Y年m月d日 H:i:s",$user['expir_time'])."\n增加天数$day : ".date("Y年m月d日 H:i:s",$expir_time);
	            			        	}
	            				    	$use_time=time();$use_ip=get_client_ip();
                                        $update = modifys("UPDATE tyys_card SET use_user_id='$userid',use_user='$username',use_time='$use_time',use_ip='$use_ip',status='2' where card_number='$card_number';");
	            				    	$json['code']=$update?200:400;$json['msg']=$update?$msg:"卡密更新错误请联系管理员！";
	                                }else{$json['code']=400;$json['msg']="用户更新时间错误！";}
	            				}else{
	            					$json['code']=400;$json['msg']="检测到你的VIP等级为$vip 级 而与卡密的使用$card_vip 等级不相同，所以不能跨级使用";
	            				}
	            			}else{$json['code']=400;$json['msg']="用户不存在！";}
	            	    }else{$json['code']=400;$json['msg']="类型错误 请类型管理员修复！类型ID；$card_type_id "; }
	            	}elseif($status==2){
	            		$json['code']=400;$json['msg']="该卡号已被使用！";
	            	}else{
	            		$json['code']=400;$json['msg']="该卡号已被停用";}
	            }else{$json['code']=400;$json['msg']="该卡号不存在";}
	
			break;
			
			case 'modifypassword':
	            $oldpassword=$_POST['oldpassword'];
	            $password=$_POST['password'];
	            $enpassword=$_POST['enpassword'];
	            if($password==$enpassword){
	            	if($oldpassword==$password){
	            		$json['code']=400;$json['msg']="你是来消遣我的么？";
	            	}else{
						$row = query("select * from tyys_user where username='$username' or email='$username';");
	                    if(($username==$row["username"] or $username==$row["email"]) && $password==$row["password"] && !empty($row["username"])){
							if($username!=$row["username"]){$username=$row["username"];}
							$update = modifys("UPDATE tyys_user SET password='$password' WHERE username='$username' and password='$oldpassword';");
	            	        if($update){
								$json['code']=200;$json['msg']="修改密码成功！";
	            	        }else{
								$json['code']=400;$json['msg']="密码错误";
							}
						}elseif( ( $username==$row["username"] or $username==$row["email"] ) && !empty($row["username"])){
			                      $json['code']=0;$json['msg']="密码错误！";
	                    }else{
		                	$json['code']=0;$json['msg']="该用户不存在！";
	                    }
	            	}
	            }else{$json['code']=400;$json['msg']="俩次密码不一致！";}  
			break;	
	
			
        	default:
			    $json = array("code"=> 404,"msg"=>"未找到该类型 $type");
            break;
        }
		echo json_encode($json);
	mysqli_close($conn);//关闭数据库
}else{
   echo json_encode(array("code"=> 500,"msg"=>$msg));
}	
?>