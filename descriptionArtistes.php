<?php
    try
    {
        if(isset($_GET['id']) && is_numeric($_GET['id'])){
            $displayOK = 0;
                    
            $artisteBDD = $bdd->prepare('SELECT nom, genre, pays, description, siteWeb, video, image FROM artistes WHERE id=:id');
            $artisteBDD->execute(array(':id' => htmlspecialchars($_GET['id'])));
            
            if($artisteBDD->rowCount() == 1){
                    $donnees = $artisteBDD->fetch();
                    createArtistePage($donnees['nom'], $donnees['genre'], $donnees['pays'], $donnees['description'], $donnees['siteWeb'], $donnees['video'], $donnees['image']);
                    $displayOK = 1;
            }
            
            if($displayOK == 0)
                include 'error404.php';
            
            $artisteBDD->closeCursor();
        }
        else{
            include 'error404.php';
        }
    }
    catch(Exception $e)
    {
        error($e);
    }
?>
