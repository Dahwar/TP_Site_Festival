<?php
    $cssTemp = $_SESSION['css']; // récupération du style avant destruction session
    $_SESSION = array();
    session_destroy();

    Header('Refresh: 3;URL=?page=accueil&css='.$cssTemp);

?>

<h3>Déconnexion en cours...</h3><p>Vous allez être redirigé dans quelques secondes.</p>