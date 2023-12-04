<!DOCTYPE html>
<html>
<head>
  	<title>Kiriti</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Font Awesome -->
	<link  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
	<!-- MDB -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.css" rel="stylesheet" />
	<!-- MDB -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.10.2/mdb.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../include/css/style.css">
</head>
  
<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border-radius: 6px;
  box-sizing: border-box;
}

button {
  background-color: #402470;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border-radius: 6px;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }

}
</style>

<body>
<div class="container col-md-4 p-6 bg-light">
	<div class="imgcontainer">
		<img src="./images/logo.jpg" alt="Avatar" class="avatar">
	 </div>
	<div class="alert alert-success text-center alert-dismissible" id="success" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
	</div>
	<div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
	</div>
	
	<div id="LoginForm">	 
	<form id="Lform" method="POST">
		  <div class="container">
			<label>Username</label>
			<input type="text" id="username" name="username" placeholder="Username"><br>

			<label>Password</label>
			<input type="password" id="password" name="password" minlength="8" placeholder="Password"><br>
			
			<button type="submit" class="rounded" id="submit" name="submit" value="login">Login</button>
		  </div>

		<div class="container" style="background-color:#f1f1f1">
			<div class="row">
				<div class="col text-center">
				  <button type="button" class="rounded" id="forgot">Forgot password</button>
				</div>
				<div class="col text-right">
				  <button type="button" class="rounded" onclick="showpwd()">Show Password</button>
				</div>
			</div>
		 </div>
	</form>
	</div>
  
	<div id="ResetForm" style="display:none;">
		<form id="ResetForm" method="POST">
			<input type="text" class="rounded" id="userid" name="userid" placeholder="Email Address">
			<button type="submit" class="rounded" id="reset" name="submit" value="reset">Reset</button>
		</form>
	</div>
	
	<div id="OTPForm" style="display:none;">
		<form id="OTPform" method="POST">
			<input type="text" class="rounded" id="otpvar" placeholder="Enter OTP"><br>
			<button type="button" class="rounded" id="otp" name="submit" value="otp" onclick="confirmOTP()">Confirm</button>
		</form>
	</div>
</div>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/656d9747ff45ca7d47869203/1hgq1dsrc';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->


</body>
</html>

<script>
const loginForm = document.querySelector('#Lform');
const otpForm = document.querySelector('#OTPForm');
const resetForm = document.querySelector('#ResetForm');
const forgotLink = document.querySelector('#forgot');
const errorAlert = document.querySelector('#error');
const successAlert = document.querySelector('#success');

let queryString = window.location.search;
const params = new URLSearchParams(queryString);
const affcode = params ==''?0 : params.get('aff');
var otpvalue;

//login
loginForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const username = document.querySelector('#username').value;
  const password = document.querySelector('#password').value;
  const submit = document.querySelector('#submit').value;

  const formData = new FormData();
  formData.append('username', username);
  formData.append('password', password);
  formData.append('submit', submit);

  fetch('include/action.php', {
  method: 'POST',
  body: formData
})
.then(response => response.json()) // Parse response body as JSON
.then(data => {
  if (data.rescode === '200') {
        //window.location.href = data.path;
        otpvalue = data.otp
        successAlert.innerHTML = 'Confirm OTP';
        otpForm.style.display = 'block';
        loginForm.style.display = 'none';
  } else {
	throw new Error('Invalid username or password');
  }
})
.catch(error => {
  errorAlert.innerHTML = error.message;
  errorAlert.style.display = 'block';
});

});

//Reset account password
forgotLink.addEventListener('click', () => {
  loginForm.style.display = 'none';
  otpForm.style.display = 'none';
  errorAlert.style.display = 'none';
  successAlert.style.display = 'none';
  resetForm.style.display = 'block';
});

//Reset password
resetForm.addEventListener('submit', (e) => {
  e.preventDefault();

  const userId = document.querySelector('#userid').value;
  const submitBtn = document.querySelector('#reset').value;

  const formData = new FormData();
  formData.append('userid', userId);
  formData.append('submit', submitBtn);

  fetch('include/action.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.rescode == '200') {
	  let newpd = data.encrykey;
      successAlert.innerHTML = 'New password sent to your email';
      otpForm.style.display = 'none';
      resetForm.style.display = 'none';
      successAlert.style.display = 'block';
	  loginForm.style.display = 'block';
    } else {
      errorAlert.innerHTML = 'Invalid user account!';
      otpForm.style.display = 'none';
      loginForm.style.display = 'none';
      resetForm.style.display = 'block';
      errorAlert.style.display = 'block';
    }
  })
  .catch(error => {
    errorAlert.innerHTML = 'Check your internet connection';
    errorAlert.style.display = 'block';
  });
});

//One time password
function confirmOTP() {
  const otp = document.querySelector('#otpvar').value;
  
  const formData = new FormData();
  formData.append('otp', otp);
  formData.append('submit', 'verifyotp');

  fetch('include/action.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.path != '') {
		window.location.href = data.path;
    } else {
		errorAlert.innerHTML = 'You provided Wrong OTP';
		errorAlert.style.display = 'block';
    }
  })
  .catch(error => {
    errorAlert.innerHTML = error.message;
	errorAlert.style.display = 'block';
  });
}

//show password
function showpwd() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>