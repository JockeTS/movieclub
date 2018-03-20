<?php

$host = "localhost";
$db = "movieclub";
$db_username = "root";
$db_password = "";

// skapa PDO-objekt
try 
{
	$dbh = new PDO( "mysql:host=$host; dbname=$db", $db_username, $db_password );
}
catch( PDOException $e )
{
	echo $e->getMessage();
}

?>