<?php

// ob_start = démarre un buffer (mémoire tampon) volatile 
// --> permet d'envoer des données header et output en même temps, ce qui est normalement impossible
// (les headers devant être envoyé avant tout code html !)

ob_start('ob_gzhandler');

session_start();

include 'config.php';
include 'function.php';
    
try
{
    $pdo_options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
	$bdd = new PDO('mysql:host=localhost;dbname=festival', 'root', '', $pdo_options);
}
catch (Exception $e)
{
    error($e);
}
?>