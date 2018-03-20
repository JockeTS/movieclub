<?php

session_start();

require_once "login_check.php";
require_once( 'db_connect.php' );
require_once('pagination.php');
require_once("print_movies.php");
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Movieclub - Search</title>
		<meta charset="UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
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
					<h3>Search for a movie in our database!</h3>
				</div>
				<div class="search-form">
					<form action="#" method="get">
						<input type="text" name="query" id="query" placeholder="Search for title, genre, actors..." class="search-field"/><button id="submit" value="Search" name="submit" class="submit-button">Search</button>
					</form>
					
					<p><div id="ajaxResults"></div></p>
			
					<div class="search_results">
			<?php
				if ( isset ($_GET['submit']) ) {
					$input = filter_input(INPUT_GET, "query", FILTER_SANITIZE_MAGIC_QUOTES ); // print_r($input);

					$query = "SELECT id FROM actors WHERE name LIKE '%$input%'";
					$sth = $dbh->query($query);
					$actor_ids = $sth->fetchAll(PDO::FETCH_COLUMN); // print_r($actor_ids);
					$actor_ids = implode( ",", $actor_ids ); // print_r($actor_ids);
					
					$query = "SELECT id FROM movies INNER JOIN movies__has__actors ON
					movies.id = movies__has__actors.movie_id WHERE actor_id IN (?)";
					$sth = $dbh->prepare($query);
					$data = array($actor_ids);
					$sth->execute($data);
					$movie_ids = $sth->fetchAll(PDO::FETCH_COLUMN); // print_r($movie_ids);
					$movie_ids = implode( ",", $movie_ids ); // print_r($movie_ids);
					
					/*
					$query = "SELECT * FROM movies WHERE title LIKE ? OR genre LIKE ?
								OR director LIKE ? OR id IN (?)";
					$sth = $dbh->prepare($query);
					$data = array( "%$input%", "%$input%", "%$input%", $movie_ids );
					$sth->execute($data);
					$movies = $sth->fetchAll(); print_r($movies);
					*/
					
					if ($movie_ids != "") 
						$query = "SELECT * FROM movies WHERE title LIKE '%$input%' OR genre LIKE '%$input%'
							OR director LIKE '%$input%' OR id IN ($movie_ids)";
					else
						$query = "SELECT * FROM movies WHERE title LIKE '%$input%' OR genre LIKE '%$input%'
							OR director LIKE '%$input%'";
						
					printMovies( $dbh, $query );
				} 
			?>			
		</div>
	  </div>
	</div>
	</div>
	
	<script>
		
		$("#query").keyup( function()
		{
			loadXMLDoc2()
		});

		function loadXMLDoc2()
		{
			if ( $("#query").val().length >= 3 )
			{
				var xmlhttp = new XMLHttpRequest();
				
				xmlhttp.onreadystatechange = function()
				{
					if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
						document.getElementById("ajaxResults").innerHTML = xmlhttp.responseText;
				}
			var input = document.getElementById("query").value;	
			
			xmlhttp.open( "GET", "ajax_search_db.php?input=" + input, true );
			xmlhttp.send();
			}		
		}
	</script>

</body> 

</html>