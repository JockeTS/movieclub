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
					<h4>
						Sort by:
						
						 <a href="home.php">Latest recommended</a> | <a href="home.php?query=mc_rating">MC rating</a> | <a href="home.php?query=imdb_rating">IMDB rating</a>
					</h4>

					<?php 
						if ( $_GET && $_GET['query'] == "mc_rating" )
							$query = "SELECT movies.*, AVG(ratings.value) AS mcavg FROM movies LEFT OUTER JOIN ratings ON movies.id = ratings.movie_id GROUP BY movies.id ORDER BY mcavg DESC";
						else if ( $_GET && $_GET['query'] == "imdb_rating" )
							$query = "SELECT * FROM movies ORDER BY imdb_rating DESC";
						else
							$query = "SELECT * FROM movies ORDER BY id DESC";
					
						printMovies( $dbh, $query ); 
					?>
				</div>
			</div>
		</div>	
	</body>
</div>
</html>

