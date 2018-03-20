<?php

session_start();

require_once( 'db_connect.php' );
require_once("print_movies.php");

if (isset($_GET['query'])) {
	$username = $_GET['query'];
	
	$query = "SELECT id FROM users WHERE username = '$username'";
	$sth = $dbh->query($query);
	
	$user_id = $sth->fetchColumn();
	$other_user_id = $user_id;
} else {
	$username = $_SESSION['user'];	
	$user_id = $_SESSION['user_id'];
	$other_user_id = null;
}

?>

<!DOCTYPE HTML>

<head>
	<title>Movieclub - <?php echo $username ?>'s profile </title>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' type='text/css' href='css/style-screen.css' />
	<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="screen and (max-width: 480px)" />
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
	<script src="js/jquery-1.8.3.js"></script>
	<script src="js/jquery-ui.min.js"></script>
</head>

<body>
	<div class="site-wrapper">
		<div class="header">
				<?php include "menu.php" ?>
		</div>
		
		<div class="content-wrapper">
			<div class="content-description">
				<h2><?php echo $username ?>'s Profile</h2>

				<?php 
					$query = "SELECT * FROM movies INNER JOIN 
					ratings ON movies.id = ratings.movie_id WHERE 
					ratings.user_id = '$user_id'";
				
					printMovies( $dbh, $query, $other_user_id ); 
				?>
			</div>
		</div>
	</div>
</body>

</html>