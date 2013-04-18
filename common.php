<?php

// ob_start = d�marre un buffer (m�moire tampon) volatile 
// --> permet d'envoer des donn�es header et output en m�me temps, ce qui est normalement impossible
// (les headers devant �tre envoy� avant tout code html !)

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