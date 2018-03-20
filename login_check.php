<?php

if ( isset( $_SESSION['logged_in'] ) )
{
	if ( $_SESSION['logged_in'] == false )
		header("Location: index.php");	
}

else
	header("Location: index.php");
	
?>