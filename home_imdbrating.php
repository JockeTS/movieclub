<?php

session_start();

require_once( 'login_check.php' );
require_once("print_movies.php");

?>

<!DOCTYPE HTML>

<html>

<head>
	<title>Movieclub - Home</title>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel='stylesheet' type='text/css' href='css/style-screen.css' />
	<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="screen and (max-width: 480px)" />
	<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
	<link rel="stylesheet" href="css/jquery-ui.css" /> 
	<script type='text/javascript' src="js/jquery-1.8.3.js"></script>
	<script type='text/javascript' src="js/jquery-ui.min.js"></script>
</head>

<div class="site-wrapper">
	<body>
		<div class="wrapper">
			<header> <?php include "menu.php" ?> </header>
			
			<div class="content-wrapper">
				<div class="content-description">
					<h2>
						Sort by:
						<br>
						<a href="home.php">Latest recommended</a> | <a href="home_mcrating.php">MC rating</a> | IMDB rating
					</h2>

					<?php 
						$query = "SELECT * FROM movies ORDER BY imdb_rating DESC";
					
						printMovies( $dbh, $query ); 
					?>
				</div>
			</div>
		</div>	
	</body>
</div>

</html>