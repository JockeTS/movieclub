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
	<script type='text/javascript' src="js/tablesorter/jquery.tablesorter.js"></script>
	<!--
	<link rel="stylesheet" href="js/tablesorter/themes/blue/style.css" type="text/css" id="" media="print, projection, screen" />
-->
</head>

<div class="site-wrapper">
	<body>
		<div class="wrapper">
			<header> <?php include "menu.php" ?> </header>
			
			<div class="content-wrapper">
				<div class="content-description">
					<h2>Sort by:
						<br>
						<a href="home.php">Latest recommended</a> | MC rating | <a href="home_imdbrating.php">IMDB rating</a>
					</h2>

					<?php
						$query = "SELECT movies.*, AVG(ratings.value) AS mcavg FROM movies LEFT OUTER JOIN ratings ON movies.id = ratings.movie_id GROUP BY movies.id ORDER BY mcavg DESC";
						printMovies( $dbh, $query );
					?>
				</div>
			</div>
		</div>
		
	</body>
</div>

</html>