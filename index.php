<?php
session_start();
if ( isset( $_SESSION['logged_in'] ) )
{	
	if ( $_SESSION['logged_in'] == true )
		header("Location: home.php"); 
}
?>
<!DOCTYPE html>
	<head>
		<title>Welcome to Movieclub</title>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<script src="js/jquery-1.8.3.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body class="for-mobile">
		<div class="index-wrapper">
			<div class="index-logo">
				<p><img src="img/index_logo.png" alt="Movieclub Logo"/></p>
				<p>Please login to gain full access to Movieclub!</p>
			</div>
			<div class="login-form">
				<form action="#" method="post">
					<p><input type="text" name="username" placeholder="Username" class="login-field" /><br/></p>
					<p><input type="password" name="password" placeholder="Password" class="login-field" /><br/>
					<div class="reminder" id="wrongLogin"></div></p>
					<button type="submit" class="submit-button">Login</button><br/>
					<p>Not a member? <a href="register.php">Sign up!</a></p>
				</form>
			</div>
			<div class="index-break">
				<img src="img/break1.png" alt="Line Break Image"/>
			</div>
			<div class="facebook-login-button">
<?php
require_once( 'db_connect.php' );
require_once( 'PasswordHash.php' );
?>

<?php // vanlig login
	if ( isset($_POST['username']) && isset($_POST['password']) )
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
	}
		
	if( isset($username) && isset($password) ) { 
		$query = "SELECT id, password FROM users WHERE username = '$username'";
		$sth = $dbh->query($query);
		$result = $sth->fetchAll(PDO::FETCH_ASSOC);
		$userId = $result[0]['id'];
		$hash = $result[0]['password'];

		$validate = validate_password($password, $hash);
		
		if ( $validate == true ) 
		{
			$_SESSION['logged_in'] = true; 
			$_SESSION['user'] = $username;
			$_SESSION['user_id'] = $userId;
			
			// header("Location: home.php");
			?>
			<script>
				window.location.href = "home.php";
			</script>
			<?php
		} 
		else
		{
			?>
			<script>
				$("#wrongLogin").html("Wrong Username or Password!");
			</script>
<?php
		}	
	} 

?>
<?php // facebook login
	require_once("facebook.php");

	if ($user) 
	{
		$username = $facebook->api("/me");
		$username = $username['name'];

		$query = "SELECT id FROM users WHERE fb_id = ?";
		$sth = $dbh->prepare( $query );
		$data = array( $user );
		$sth->execute( $data );
		$result = $sth->fetchAll();

		// sätt in fb-användaren i databasen om denne ej existerar där
		if ( count($result) != 1 )
		{
			$query = "INSERT INTO users ( fb_id, username ) VALUES ( ?, ? )";
			
			$sth = $dbh->prepare($query);
			
			$data = array( $user, $username );
			
			$sth->execute($data);
		}
		
		// hämta anv. id från db
		$query = "SELECT id FROM users WHERE username = ?"; 
		$sth = $dbh->prepare($query);
		$data = array($username);
		$sth->execute($data);
		$userId = $sth -> fetchColumn();
		
		$_SESSION['user'] = $username;
		$_SESSION['user_id'] = $userId;
		$_SESSION['logged_in'] = true;
		$_SESSION['fb'] = true;
		$_SESSION['fb_logout'] = $facebook->getLogoutUrl();
		?>
		<script>
			window.location.href = "home.php";
		</script>
		<?php
	}	
	else 
	{
		$loginUrl = $facebook->getLoginUrl();
		echo "<a href='$loginUrl'> <img src='img/facebook_logn_btn.png' alt='Login with Facebook'/></a>";
	}
?>
			</div>
		</div>
		
	</body>
</html>
