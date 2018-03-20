<?php

session_start();

require_once( 'db_connect.php' );

$number = $_POST['number'];
$response = $_SESSION['response'];

$imdb_id = $response[$number]['imdb_id'];
$query = "SELECT imdb_id FROM movies WHERE imdb_id = ?";
$sth = $dbh->prepare($query);
$data = array($imdb_id);
$sth->execute($data);
$exists = $sth->fetchColumn();

if ( $exists != "" )
	echo "Movie already recommended!";
else {
	// titel
	if ( isset($response[$number]['title']) )
		$title = $response[$number]['title'];
		
	// år	
	if ( isset($response[$number]['year']) )
		$year = $response[$number]['year'];	
	else
		$year = "?";
	
	// filmposter
	if ( isset($response[$number]['poster']) )
		$poster = $response[$number]['poster'];
	else
		$poster = "img/not_found.GIF";
	
	// imdb-rating
	if ( isset($response[$number]['rating']) )
		$imdb_rating = $response[$number]['rating'];
	else
		$imdb_rating = "?";
	
	// skådespelare
	if ( isset($response[$number]['actors']) )
		$actors = $response[$number]['actors'];
	else
		$actors = "Unknown";	
	
	// regissör
	if ( isset($response[$number]['directors']) )
		$director = $response[$number]['directors'][0];	
	else
		$director = "Unknown";
	
	// språk
	if ( isset($response[$number]['language']) )
		$language = $response[$number]['language'][0];
	else
		$language = "Unknown";
	
	// handling
	if ( isset($response[$number]['plot_simple']) )
		$plot = $response[$number]['plot_simple'];
	else
		$plot = "";	
	
	// längd
	if ( isset($response[$number]['runtime']) )
		$runtime = $response[$number]['runtime'][0];
	else
		$runtime = "Unknown";
	
	// genre
	if ( isset($response[$number]['genres'][0]) )
		$genre = $response[$number]['genres'][0];
	else
		$genre = "Unknown";
	
	// land
	if ( isset($response[$number]['country'][0]) )	
		$country = $response[$number]['country'][0];
	else
		$country = "Unknown";
		
	// kolla om filmens skådespelare finns i db, om inte, sätt in dem
	for ( $i = 0; $i < 3; $i++ ) {
		$name = array($actors[$i]);
		$query = "SELECT name FROM actors WHERE name = ?";
		$sth = $dbh->prepare($query);
		$sth->execute($name);
		$result = $sth->fetchColumn();

		if ( $result == "" ) {
			$query = "INSERT INTO actors ( name ) VALUES ( ? )";
			$sth = $dbh->prepare($query);
			$sth->execute($name);
		}	
	}

	$data = array( "title" => $title, 
		"imdb_id" => $imdb_id, 
		"imdb_rating" => $imdb_rating, 
		"year" => $year, 
		"country" => $country, 
		"genre" => $genre, 
		"runtime" => $runtime, 
		"language" => $language, 
		"director" => $director, 
		"plot_simple" => $plot,
		"poster" => $poster );
												
	$sth = $dbh -> prepare( "INSERT INTO movies ( title, imdb_id, imdb_rating, year, country, genre, runtime, language, director, plot, poster ) VALUES ( :title, :imdb_id, :imdb_rating, :year, :country, :genre, :runtime, :language, :director, :plot_simple, :poster )" );
	
	// sätt in filmen i databasen	
	$sth -> execute( $data );

	// koppla filmens skådespelare till filmen i kopplingstabellen movies__has__actors
	$query = "SELECT id FROM movies WHERE imdb_id = ?";
	$data = array($imdb_id);
	$sth = $dbh->prepare($query);
	$sth->execute($data);
	$movieId = $sth->fetchColumn();
	
	for ( $i = 0; $i < 3; $i++ ) {
		$name = $actors[$i];
		$query = "SELECT id FROM actors WHERE name = ?";
		$data = array($name);
		$sth = $dbh->prepare($query);
		$sth->execute($data);
		$actorId = $sth->fetchColumn();

		$query = "INSERT INTO movies__has__actors ( movie_id, actor_id ) VALUES ( ?, ? )";
		$data = array($movieId, $actorId);
		$sth = $dbh->prepare($query);
		$sth->execute($data);
	}
}
// session_unset( $_SESSION['response'] );

?>

<html>

<head>
	<script src="js/jquery-1.8.3.js"/> </script>
	
	<title> Insert </title>
</head>

<body>
	<script>
		window.location.href = "home.php";
	</script>
</body>

</html>
