<?php

session_start();

$logoutUrl = $_SESSION['fb_logout'];

session_destroy();

header( "Location: $logoutUrl" );

?>