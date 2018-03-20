<?php

session_start();

require_once( 'login_check.php' );
	
if(isset($_POST['search'])) {
	$search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_MAGIC_QUOTES);
	$search = urlencode($search);
	$base_search = "&type=json&plot=simple&episode=1&limit=5&yg=0&mt=none&lang=en-US&offset=";
	$base_api_url = "http://imdbapi.org/?q=";
	$base_api_url .= $search . $base_search;
	$url = urlencode($base_api_url);
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL,$base_api_url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

	$response = curl_exec($ch);
	curl_close($ch);
	$response = json_decode($response, true);
} 
	
?>

<!DOCTYPE HTML>
	<head>
		<title>Movieclub - Recommend</title>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<script src="js/jquery-1.8.3.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<div class="site-wrapper">
			<div class="header">
				<?php include "menu.php" ?>
			</div>
			<div class="content-wrapper">
				<div class="content-description">
					<h3>Search for a movie, rate and recommend it!</h3>
				</div>
				<div class="search-form">
					<form action="#" method="post">
						<input type="text" name="search" placeholder="Search..." class="search-field"/>
						<button id="submit" value="Search" class="submit-button">Search</button>
					</form>
					
		<?php
			if( !isset($_POST['search']) )
				echo "";
			
			if( isset( $_POST['search'] ) && isset( $response ) )
			{
			
			if($_POST['search'] && $response[0]['title'] == "")
				echo "<p>No match, try again!</p>";
				
			else
			{
				echo "<h2> Search results: </h2>";
				for ( $i = 0; $i < count($response); $i++ )
				// while ( $response[$i]['poster'] != "" )
				{
					// titel
					if ( isset($response[$i]['title']) )
						$title = $response[$i]['title'];
						
					// år	
					if ( isset($response[$i]['year']) )
						$year = $response[$i]['year'];	
					else
						$year = "????";
					
					// filmposter
					if ( isset($response[$i]['poster']) )
						$image = $response[$i]['poster'];
					else
						$image = "img/not_found.GIF";
					
					// imdb-rating
					if ( isset($response[$i]['rating']) )
						$imdb_rating = $response[$i]['rating'];
					else
						$imdb_rating = "?";
					
					// skadespelare
					if ( isset($response[$i]['actors']) )
						$actors = $response[$i]['actors'];
					else
						$actors = "Unknown";	
					
					// regissör
					if ( isset($response[$i]['directors']) )
						$director = $response[$i]['directors'][0];	
					else
						$director = "Unknown";
					
					// språk
					if ( isset($response[$i]['language']) )
						$language = $response[$i]['language'][0];
					else
						$language = "Unknown";
					
					// handling
					if ( isset($response[$i]['plot_simple']) )
						$plot = $response[$i]['plot_simple'];
					else
						$plot = "n/a";	
					
					// längd
					if ( isset($response[$i]['runtime']) )
						$runtime = $response[$i]['runtime'][0];
					else
						$runtime = "Unknown";
					
					// genre
					if ( isset($response[$i]['genres']) )
						$genre = $response[$i]['genres'][1];
					else
						$genre = "Unknown";
			?>				
					
				</div>
				<div class="movies-wrapper">
					<div class="movies-poster">
						<img class='posta' src='<?php echo $image ?>' width="92" height="130" alt="Movie Poster">
					</div>
					<div class="movies-info">
						<h2 rel="movie-title"><?php echo $title . " ($year)"; ?></h2>
						Genre: <?php echo $genre; ?><br/>
						Directed by: <?php echo $director; ?><br/>
						Starring: 
						
							<?php //Actors
								$k = 0;
								foreach ($actors as $actor) {
									echo $actor;
									
									if($k != 2)
										echo ", ";
									if ( $k++ == 2 )
										break;
								} 
							?><br/>
						
						Runtime: <?php echo $runtime; ?><br/>
						Language: <?php echo $language; ?><br/>

						<p>Plot: <?php echo $plot; ?></p> 
					</div>
					<div class="movies-rating-wrapper">
						<div class="movies-rating-center-wrapper">
						<div class="movies-rating-imdb">
							<table>
								<tr>
									<td><img class='rating_logo' src="img/imdb_rating.png"/></td>
									<td><h2 rel="movie-rating"><?php printf( "%.1f", $imdb_rating ); ?></h2></td>
								</tr>
							</table>
						</div>
						</div>
					</div>
					<div class="recommend-button-wrapper">
						<form action="insert.php" method="post">
						<input type='hidden' value='<?php echo $i ?>' name='number' />
						<p><button id="submit" value="Recommend" class="recommend-button">Recommend</button></p></form>
					</div>
					<div class="movies-seperator">
						<img src="img/mov_sep.png"/>
					</div>
		<?php					
				}	
			}
			
			$_SESSION['response'] = $response;
			}
		?> 
				</div>
			</div>
		</div>
	</body>
</html>