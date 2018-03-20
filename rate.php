<?php

session_start();

$rating = $_GET['rating'];
$movieId = $_GET['movieId'];
$userId = $_SESSION['user_id'];

require_once( 'db_connect.php' );

// kolla om användaren redan betygsatt filmen
$query = "SELECT id FROM ratings WHERE user_id = $userId AND movie_id = $movieId";
$sth = $dbh->query($query);
$result = $sth->fetchColumn();
// print_r($result);

if ( $result == "" )
{
	// sätt in betyget
	$query = "INSERT INTO ratings (user_id, movie_id, value) VALUES ($userId, $movieId, $rating)";
	$sth = $dbh->query($query);

	// uppdatera betyget
	$query = "SELECT AVG(value) FROM ratings WHERE movie_id = $movieId";
	$sth = $dbh->query($query);
	$mcRating = $sth->fetchColumn();
	printf( "%.1f", $mcRating );
}

?>