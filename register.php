<!DOCTYPE html>
	<head>
		<meta charset="utf-8" />
		<title>Movieclub - Signup</title>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<script src="js/jquery-1.8.3.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="js/jquery-1.8.3.js"></script>
	</head>
	
	<body>		
		<div class="index-wrapper">
			<div class="index-logo">
				<p><img src="img/index_logo.png" alt="Movieclub Logo"/></p>
				<h3>Register an account</h3>
			</div>
			<div class="login-form">
				<form action="#" method="post" id="register" onsubmit="checkForm()">

					<p><input type="text" size="40" name="username" id="fcuk" placeholder="Desired username" class="login-field"/>
					<div class="reminder" id="1"></div></p>
					
					<p><input type="password" size="40" name="password" placeholder="Desired password" class="login-field"/>
					<div class="reminder" id="2"></div></p>
					
					<p><input type="password" size="40" name="passwordConfirm" placeholder="Re-type password" class="login-field"/>
					<div class="reminder" id="no_match"></div></p>

					<button type="submit" id="submit" class="submit-button"> Register </button>
				</form>
			</div>
		</div>
				
		<script>
			function checkForm() {
				if ( $("[name='username']").val() == "" )
					$("#1").html("Forgot something?");
				
				if ( $("[name='password']").val() == "" )
					$("#2").html("You need a password!");	
			
				var password = $("[name='password']").val();
				var passwordConfirm = $("[name='passwordConfirm']").val();

				if ( password != passwordConfirm )
					$("#no_match").html("The passwords doesn't match!");
			
				if ( $("[name='username']").val() != "" && $("[name='password']").val() != "" && $("[name='passwordConfirm']").val() != "" 
					&& password == passwordConfirm )
					$("#register").submit();
				}
			$("#submit").click(function(){
				checkForm();
				return false;
			});
			$("#register").submit(function() {
				checkForm();
				return false;
			});
		</script>


<?php

require_once('db_connect.php');
require_once('PasswordHash.php'); 

if (isset($_POST['username']) && isset($_POST['password']) )
{
	$username = $_POST['username'];
	$password = $_POST['password'];

		// se om anv redan finns i db
		$query = "SELECT id FROM users WHERE username = '$username'";

		$sth = $dbh->query($query);

		$result = $sth->fetchAll();

		if (count($result)==1)
		{
		?>
			<script>
				$("#1").html("Username "+ <?php echo "\"" .$_POST['username'] . "\""; ?>+" already taken!");
    		</script>

    	<?php
    	}	
		// om ej, sätt in anv i db
		else
			{					
				$password = create_hash($password);
				
				$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
				
				$sth = $dbh->query($query);
				
				?>
				<div class="login-form">
					<h2>Succesfully registered!</h2>
					<h1><a href ="home.php">Log in!</a></h1>
				</div>
<?php
			}
}
?>
	</body>

</html>