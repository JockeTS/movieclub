<?php

session_start();

require_once( 'db_connect.php' );

$username = $_SESSION['user'];

?>

<!DOCTYPE HTML>
	<head>
		<title>Movieclub - Profiles</title>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<script src="js/jquery-1.8.3.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="site-wrapper">
			<div class="header">
				<?php include "menu.php" ?>
			</div>
			<div class="content-wrapper">
				<div class="content-description">
					<h3>Profiles</h3>
				</div>
				<div class="content-text">
					<?php
					$query = "SELECT username FROM users WHERE username != '$username'";
				
					$sth = $dbh->query($query);
				
					$users = $sth->fetchAll();
				
					foreach($users as $user) { ?> 
						<div> <h3><a href="user_profile.php?query=<?php echo $user[0]?>"> <?php echo $user[0] ?> </a></h3> </div>
							<!--'search_db.php?query=$title&submit=S�k'-->
					<?php } ?>
				</div>
			</div>
		</div>
	</body>
</html>