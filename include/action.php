<?php
include"functions.php";

$db = db_conn();
$n=10;

$otp = rand(1000, 9999);

$action = $_POST['submit'];

switch ($action) {
	case "login":
		//session_start();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$status = "Active";

		$sql = "SELECT * FROM employees WHERE username = ? AND status = ?";
		$query = $db->prepare($sql);
		$query->execute(array($username,$status));
		$row = $query->rowCount();
		$fetch = $query->fetch();
		if($row > 0) {
			if (password_verify($password, $fetch['password'])){
					//session_start();
					if($fetch['username'] == $username and $fetch['position'] == 'Administrator'){
						$_SESSION['id'] = $username;
						$_SESSION["phone"] = $fetch['contact'];
						$_SESSION["account"] = 'Admin';
						$_SESSION["otp"] = $otp;
						$data = array(
						'path' => '../admin/index.php?dashboard',
						'rescode' => '200'
						);
						}
					else if($fetch['username'] == $username and $fetch['position'] == 'Receptionist'){ 
						$_SESSION['id'] = $username;
						$_SESSION["phone"] = $fetch['contact'];
						$_SESSION["account"] = 'Reception';
						$_SESSION["otp"] = $otp;
						$data = array(
						'path' => '../reception/index.php?dashboard',
						'rescode' => '200'
						);
						}
					else if($fetch['username'] == $username and $fetch['position'] == 'Teacher'){ 
						$_SESSION['id'] = $username;
						$_SESSION["phone"] = $fetch['contact'];
						$_SESSION["account"] = 'Teacher';
						$_SESSION["otp"] = $otp;
						$data = array(
						'path' => '../teachers/index.php?dashboard',
						'rescode' => '200'
						);
						}
					else{
						$data = array(
							'otp' => $otp,
							'rescode' => '201'
						);
					}
					$_SESSION["otp"] = $otp;
					$msg = "The OTP code is : ".$otp;
					$sms = sendSms($_SESSION["phone"], $msg);
					//$sms = 200;
					if($sms == 200){
						$data = array(
							'otp' => $otp,
							'rescode' => '200'
						);
					}
					else{
						$data = array(
							'otp' => '0001',
							'rescode' => '201'
						);
					}
				}				
				else{
					$data = array(
						'otp' => '0002',
						'rescode' => '201'
					);
				}			
		}
		else{
			$data = array(
				'otp' => '0003',
				'rescode' => '201'
			);
		}
		$db = null;
		echo json_encode($data);
    break;

	case "verifyotp":
		if($_POST['otp'] == $_SESSION["otp"]){
			if($_SESSION["account"] == 'Admin'){
				$data = array(
				'path' => 'https://localhost/school/admin/index.php?dashboard'
				);
				
			}
			else if($_SESSION["account"] == 'Reception'){
				$data = array(
				'path' => 'https://localhost/school/reception/index.php?dashboard'
				);
			}
			else if($_SESSION["account"] == 'Teacher'){
				$data = array(
				'path' => 'https://localhost/school/teachers/index.php?dashboard'
				);
			}
			else{
				$data = array(
				'path' => 'index.php'
				);
			}
		}
		else{
			$data = array(
				'path' => ''
			);
		}
		
		echo json_encode($data);
	break;
	
	case "reset":
		if($_POST['userid'] != ""){
			$email = str_replace("'", "\'", $_POST['userid']);
			$status ="Yes";
			$newpd = GeneratePassword($n);
			
			$sql = "SELECT * FROM `employees` WHERE `username`=? AND `status`=?";
			$query = $db->prepare($sql);
			$query->execute(array($email,$email,$status));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
			    $phone = $fetch['phone'];
			    $email = $fetch['mail'];
				$action ="reset";
				$npd = GeneratePassword($n);
				$msg = "Dear customer we are glad to notify you that resetting your password has was successful, the new password is : {$npd}";
				$new_password = password_hash($npd, PASSWORD_BCRYPT);
				$sql = $db->query("UPDATE employees SET password = '$new_password' WHERE mail = '$email' ");
				$db = null;
				$sms = sendSms($phone, $msg);
				$data = array(
					'encrykey' => $npd,
					'rescode' => '200'
				);
			}else{
				$data = array(
					'rescode' => '201'
				);
				echo json_encode($data);
			}
			echo json_encode($data);
			echo "<script>window.location = '../include/mail.php?action=$action&mail=$email&npd=$new_password'</script>";
		}
		
	break;
	
  default:
    echo "Invalid operation";
}

