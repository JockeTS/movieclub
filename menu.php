<?php
	if ( isset($_SESSION['user']) )
		$user = $_SESSION['user'];
	
	if ( isset($_SESSION['fb']) && $_SESSION['fb'] == true )
	{
		$logout = "fb_logout.php";
		$text = "Log out ( Facebook )";
	}
	else	
	{
		$logout = "logout.php";
		$text = "Log out";
	}
?>
	
<!DOCTYPE html>
	<head>
		<link rel="stylesheet" href="css/style-screen.css"/>
		<link rel='stylesheet' type='text/css' href='css/style-mobile.css' media="only screen and (max-width: 480px)" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8"/>
	</head>
		<body>
			<div class="login-nav">
				<a href="user_profile.php"> <?php echo $user ?></a> | <a href='<?php echo $logout ?>'> <?php echo $text ?></a>
			</div>
			<div class="logo">
				<div id="screen-logo"><a href="home.php" ><img src="img/mc_logo1.png" alt="Movieclub logotype"/></a></div>
				<div id="mobile-logo"><a href="home.php" ><img src="img/mc_mobile_logo.png" alt="Movieclub logotype"/></a></div>
			</div>
			<div class="menu">
				<div class="nav-screen-wrapper">	
					<ul>
 						<li><a href='home.php'>Home</a></li>
  						<li><a href='about.php'>About</a></li>
  						<li><a href='profiles.php'>Profiles</a></li>
  						<li><a href='search_db.php'>Search</a></li>
  						<li><a href='search.php'>Recommend</a></li>
					</ul>
				</div>
				<div class="nav-mobile-wrapper">
					<ul>
						<li><div class="menu-button-wrapper"><a href='home.php'>Home</a></div></li>
						<li><div class="menu-button-wrapper"><a href='profiles.php'>Profiles</a></div></li>
  						<li><div class="menu-button-wrapper"><a href='search_db.php'>Search</a></div></li>
  						<li><div class="menu-button-wrapper"><a href='search.php'>Recommend</a></div></li>
					</ul>
				</div>
			</div>
	</body>
</html>	