<?php

class Movie
{
	var $id;
	var $title;
	var $imdb_id;
	
	var $imdb_rating;
	var $mc_rating;
	var $user_rating;
	
	var $year;
	var $country;
	var $genre;
	
	var $runtime;
	var $language;
	var $actors;
	
	var $director;
	var $plot;
	var $poster;
	
	/*
	function __construct( $id, $title, $sv_title, $imdb_id, $imdb_rating, $imdb_id, $year,  
		$country, $genre, $runtime, $language, $director, $actors, $plot, $poster) {
		//$this->id = $id;
		//$this->title = $title;
	}
	*/
	
	// id
	function setId($dbh) {
		$query = "SELECT id FROM movies WHERE imdb_id = ?";
		$sth = $dbh->prepare($query);
		$data = array($this->getImdbId());
		
		$sth->execute($data);
		$id = $sth->fetchColumn();
		$this->id = $id;
	}
	function getId() {
		return $this->id;
	}
	
	// title
	function setTitle($title) {
		$this->title = $title;
	}
	function getTitle() {
		return $this->title;
	}
	
	// imdb_id
	function setImdbId($imdb_id) {
		$this->imdb_id = $imdb_id;
	}
	function getImdbId() {
		return $this->imdb_id;
	}
	
	// imdb_rating
	function setImdbRating($imdb_rating) {
		$this->imdb_rating = $imdb_rating;
	}
	function getImdbRating() {
		return $this->imdb_rating;
	}
	
	// mc_rating
	function setMcRating($dbh) {
		$query = "SELECT AVG(value) FROM ratings WHERE movie_id = ?";
		$sth = $dbh->prepare($query);
		$data = array($this->getId());
		
		$sth->execute($data);
		$mc_rating = $sth->fetchColumn();
		$this->mc_rating = $mc_rating;
	}
	function getMcRating() {
		return $this->mc_rating;
	}
	
	// user_rating
	function setUserRating($user_id, $dbh) {
		$query = "SELECT value FROM ratings WHERE user_id = ? AND movie_id = ?";
		$sth = $dbh->prepare($query);
		$data = array($user_id, $this->getId());
		
		$sth->execute($data);
		$user_rating = $sth->fetchColumn();
		$user_rating = number_format( $user_rating, 1, ".", "" );
		$this->user_rating = $user_rating;
	}
	function getUserRating() {
		return $this->user_rating;
	}
	
	// year
	function setYear($year) {
		$this->year = $year;
	}
	function getYear() {
		return $this->year;
	}
	
	// country
	function setCountry($country) {
		$this->country = $country;
	}
	function getCountry() {
		return $this->country;
	}
	
	// genre
	function setGenre($genre) {
		$this->genre = $genre;
	}
	function getGenre() {
		return $this->genre;
	}
	
	// runtime
	function setRuntime($runtime) {
		$this->runtime = $runtime;
	}
	function getRuntime() {
		return $this->runtime;
	}
	
	// language
	function setLanguage($language) {
		$this->language = $language;
	}
	function getLanguage() {
		return $this->language;
	}
	
	// actors
	function setActors($dbh) {
		$movie_id = $this->getId();
		
		$query = "SELECT name FROM actors INNER JOIN 
		movies__has__actors ON actors.id = movies__has__actors.actor_id
		WHERE movie_id = '$movie_id'";
		
		$sth = $dbh->query($query);
		$actors = $sth->fetchAll(PDO::FETCH_ASSOC);
	
		$this->actors = $actors;
	}
	function getActors() {
		return $this->actors;
	}
	
	// director
	function setDirector($director) {
		$this->director = $director;
	}
	function getDirector() {
		return $this->director;
	}
	
	// plot
	function setPlot($plot) {
		$this->plot = $plot;
	}
	function getPlot() {
		return $this->plot;
	}
	
	// poster
	function setPoster($poster) {
		$this->poster = $poster;
	}
	function getPoster() {
		return $this->poster;
	}
}

?>