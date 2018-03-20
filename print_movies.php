<?php	

require_once( "db_connect.php" );
require_once( "Movie.class.php" );
require_once( 'pagination.php' );

function paginate( $dbh, $query ) {
	if(isset($_GET['page']))
	{
		$page = $_GET['page'];
	}
	else
	{
		$page = 1;
	}

	$options = array(
		'results_per_page'              => 5,
		'url'                           => '?page=*VAR*', // 'http://www.mysite.com/example_pdo.php?page=*VAR*',
		'db_handle'                     => $dbh
	);

	try
	{
		$paginate = new pagination($page, $query, $options);
	}
	catch(paginationException $e)
	{
		echo $e;
		exit();
	}

	if($paginate->success == true)
	{
		// $movies = $paginate->resultset->fetchAll(PDO::FETCH_CLASS, "Movie");
	}
	
	return $paginate;
}

function printMovies( $dbh, $query, $other_user_id = null ) {
	$paginate = paginate( $dbh, $query );
	
	$movies = $paginate->resultset->fetchAll(PDO::FETCH_CLASS, "Movie");

	$user_id = $_SESSION['user_id'];
	
	
	/*
	if ( $_GET ) {
		$other_user_name = "heman";// $_GET['query']; print_r($other_user_name);
		$query = "SELECT id FROM users WHERE name = ?"; // print_r($_GET);
		$sth = $dbh->prepare($query);
		$data = array($other_user_name);
		$sth->execute($data);
		$other_user_id = $sth->fetchAll(); print_r($other_user_id);
	}	
	*/
	
	$divNumber = 0;
	
	foreach($movies as $movie) { 
		$movie->setId($dbh);
		$movie->setMcRating($dbh); 
		$movie->setUserRating( $user_id, $dbh );
		$movie->setActors($dbh);
		
		$divNumber++; ?> 
		
		<div class="movies-wrapper">
			<div class="movies-poster"> 
				<img class="posta" src="<?php echo $movie->getPoster(); ?>" width="92" height="130" alt="Movie Poster"/> 
			</div>
			
			<div class="movies-info">
				<h2 rel="movie-title"> <?php echo $movie->getTitle() ?> (<?php echo $movie->getYear(); ?>) </h2>
				
				Genre: <?php echo $movie->getGenre() ?><br/>
				
				Directed by: <?php echo $movie->getDirector() ?> <br/>
				
				Starring:
				
				<?php // actors
					$actors = $movie->getActors();
					
					$numItems = count($actors);
					$asdf = 0;
					foreach ( $actors as $actor )
					{
						if(++$asdf === $numItems)
						{
							echo $actor['name'];
						}
						else
						{
							echo $actor['name'] . ", ";
						}
					}
				?> <br/>
	
				Runtime: <?php echo $movie->getRuntime() ?> <br/>
				
				Language: <?php echo $movie->getLanguage() ?>
				
				<p>Plot: <?php echo $movie->getPlot() ?> </p> 
			</div>
			
			
			<div class="movies-rating-wrapper">
				<div class="movies-rating-center-wrapper">
					<div class="movies-rating-imdb"> 						
						<table> 
							<tr> 
								<td> <img src='img/imdb_rating.png'/> </td> 
								<td> <h2 rel="movie-rating"> <?php printf( "%.1f", $movie->getImdbRating() ); ?> </h2> </td> 
							</tr>
						</table>
					</div>
					
					<div class="movies-rating-seperator">
						<img src="img/rating_sep.png" />
					</div>
					
					<div class="movies-rating-movieclub"> 
						<table>
							<tr> 
								<td> <img src='img/mc_rating.png'/> </td> 
								<td id="mc_rating<?php echo $divNumber ?>" rel="movie-rating"> <h2> <?php printf( "%.1f", $movie->getMcRating() ); ?> </h2> </td> 
							</tr>
						</table>
						<?php
							$userRating = $movie->getUserRating();
							if ( $userRating != 0 )
								echo "<h4>Your rating: <br/>" . $userRating . "</h4>";
							else { ?>
								<div id="tezt<?php echo $divNumber ?>">
									<h3><div class="sliderValue" id="sliderValue<?php echo $divNumber ?>">5.0</div></h3>
									
									<p><div class="slider" id="slider<?php echo $divNumber ?>"></div></p>	
									
									<button class="rate-button" id="rate<?php echo $divNumber ?>" > Rate </button> 
								</div>
								<script>
								// skapa sliders
								$("#slider<?php echo $divNumber ?>").slider({                   
									value: 5,
									min: 0,
									max: 10,
									step: 0.1,
									slide: function(event, ui) 
									{
										$("#sliderValue<?php echo $divNumber ?>").html(parseFloat(ui.value).toFixed(1));
									}
								});
								
								// betygs�tt	
								$("#rate<?php echo $divNumber ?>").click( function()
								{
									var divId = <?php echo $divNumber ?>;
									var movieId = <?php echo $movie->getId(); ?>;
									loadXMLDoc(divId, movieId)
								}); 
								
								function loadXMLDoc(divId, movieId) {
									var xmlhttp = new XMLHttpRequest();
									var rating = $("#sliderValue" + divId).html();
									var rating = parseFloat(rating).toFixed(1);
									var movieId = movieId;
									
									xmlhttp.onreadystatechange = function()
									{
										if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
										{
											if ( xmlhttp.responseText != "" )
											{
												$("#mc_rating" + divId).html( xmlhttp.responseText );
												$("#tezt" + divId).html("Your rating:</br>" + rating);
											}	
										}	
									}	
									xmlhttp.open( "GET", "rate.php?rating=" + rating + "&movieId=" + movieId, true );
									xmlhttp.send();		
									}
								</script> 
							<?php
							}
							if ($other_user_id != null) {
								$other_user_name = $_GET['query'];
								$movie->setUserRating( $other_user_id, $dbh );
								echo "<br/>$other_user_name's rating: <br/>" . $movie->getUserRating();
							}
							?>		
					</div>	
				</div>
			</div>
			
			<div class="movies-seperator">
				<img src="img/mov_sep.png"/>
			</div>
		</div> <?php
	} 
echo $paginate->links_html; 
	
}	
		
?>