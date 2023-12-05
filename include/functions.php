<?php	
	session_start();
	$key = 'qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';

	// Database name & Connection
	function db_conn(){
		$db_username = 'root';
		$db_password = '';
		$db = new PDO( 'mysql:host=localhost;dbname=school', $db_username, $db_password );
		if(!$db){
			die("Fatal Error: Connection Failed!");
		}
		return $db;

	}
	
	function encryptthis($data, $key) {
		$encryption_key = base64_decode($key);
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
		return base64_encode($encrypted . '::' . $iv);
	}

	function decryptthis($data, $key) {
		$encryption_key = base64_decode($key);
		list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
		return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
	}

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	
	function resetpd($n) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	  
		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}
	  
		return $randomString;
	}

	

	function logout(){
		session_destroy();
		header("Location: ../index.php");

	}

	function sendSms($phone, $msg){
		$baseUrl="https://bulksms.mobitechtechnologies.com/api/sendsms";

		$ch = curl_init($baseUrl);
		$data= array('api_key' =>'5f9687821a092' ,
		'username' =>'codestar' ,
		'sender_id' =>'UNICOMM' ,
		'message' =>$msg ,
		'phone' =>$phone );
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Accept:application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		//echo $result;
		curl_close($ch);
		$result = trim($result, '[]');
		$sms_res = json_decode($result);
		$status = $sms_res->status;
		return $status;
		
	}
	

	if (isset($_GET['logout'])) {

		logout();

	}

?>