<?php

require_once( 'db_connect.php' );

?>

<?php

$input = filter_input(INPUT_GET, "input", FILTER_SANITIZE_MAGIC_QUOTES );

// search title
$query = "SELECT title FROM movies WHERE title LIKE '%$input%'";
$sth = $dbh->query( $query );
$titles = $sth->fetchAll();

foreach( $titles as $title ) {
	$title = $title['title'];
?>	

	<a href='search_db.php?query=<?php echo urlencode($title) ?>&submit=Search'> <?php echo $title ?> </a> <br/>

<?php

}

// search genre
$query = "SELECT title, genre FROM movies WHERE genre LIKE '%$input%'";
$sth = $dbh->query( $query );
$genres = $sth->fetchAll();

foreach( $genres as $genre )
{
	$title = $genre['title'];
	$genre = $genre['genre'];
	
	echo "<a href='search_db.php?query=$title&submit=Search'> ( $genre ) $title </a> <br />";
}
?>

<?php

// visa lista på aktörer där namnet liknar input
$query = "SELECT id, name FROM actors WHERE name LIKE '%$input%'";// "SELECT name FROM actors INNER JOIN movies__has__actors ON actors.id = movies__has__actors.actor_id";
$sth = $dbh->query( $query );
$result = $sth->fetchAll();

foreach( $result as $item ) {
	$actorId = $item['id'];
	$name = $item['name'];
	$query = "SELECT title FROM movies INNER JOIN movies__has__actors ON movies.id = movies__has__actors.movie_id WHERE actor_id = '$actorId'";
	$sth = $dbh->query( $query );
	$movies = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach ( $movies as $movie ) {
		$title = $movie['title']; 
?>
		<a href="search_db.php?query=<?php echo $title ?>&submit=Search"> <?php echo "( $name ) $title" ?> </a><br/>
<?php 	
	}

}

?> 
 
<?php
	// search director
	$query = "SELECT title, director FROM movies WHERE director LIKE '%$input%'";
	$sth = $dbh->query( $query );
	$directors = $sth->fetchAll();
		
	foreach( $directors as $director ) {
		$title = $director['title'];
		$director = $director['director'];
		?>
		<a href="search_db.php?query=<?php echo $title ?>&submit=Search"> <?php echo "( $director ) $title"; ?> </a>
<?php	
	} 
?>





