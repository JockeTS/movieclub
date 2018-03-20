<?php

require_once("fb/src/facebook.php");

$config = array();
$config['appId'] = "315823705198286";
$config['secret'] = "0bb6ff06d8eec0809c52882e880b802f";
$config['fileUpload'] = false; // optional

$facebook = new Facebook($config);

$user = $facebook->getUser();

?>