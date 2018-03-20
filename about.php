<?php

session_start();

require_once( 'login_check.php' );
require_once( 'db_connect.php' );

?>

<!DOCTYPE HTML>
	<head>
		<title>Movieclub - About</title>
		<meta charset="UTF-8"/>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<script src="js/jquery-1.8.3.js"></script>
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" />
		<link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<div class="site-wrapper">
			<div class="header">
				<?php include "menu.php" ?>
			</div>
			<div class="content-wrapper">
				<div class="content-description">
					<h3>About Movieclub</h3>
				</div>
				<div class="content-text">
					<p>Have you ever wanted to watch a movie and not being quite sure of what type of movie you want to see? 
					Or maybe you want to let other people know what movie they should watch? Well, in this day and age
					digital phenomenons make this possible with applications and web pages but very few of them let you
					combine everything into one thing. Movieclub was developed for people who want an exclusive club
					to hang out in and search, rate and recommend thier favorite movies in. We love movies, do you?</p>
					
					<h3>The team</h3>
					Movieclub was developed and designed by <span style="font-weight:bold;">Jocke Sjölin, Jesper Bergström, 
					Thomas Björk</span> and <span style="font-weight:bold;">Marcus Liljehammar</span> as part of an assignment at 
					Nackademin in mobile webapplication development written in PHP, SQL, HTML, CSS3 and jQuery. The site/application 
					was finished in the wake of a horrible blizzard, just before Christmas in 2012.
				</div>
			</div>
		</div>
	</body>
</html>