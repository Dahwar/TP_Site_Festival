<?php
    try
    {  
        $vendredi = $bdd->prepare('SELECT id, nom, genre, pays, image FROM artistes WHERE vendredi=1 ORDER BY id');
        $samedi = $bdd->prepare('SELECT id, nom, genre, pays, image FROM artistes WHERE samedi=1 ORDER BY id');
        $dimanche = $bdd->prepare('SELECT id, nom, genre, pays, image FROM artistes WHERE dimanche=1 ORDER BY id');
        
        echo '  <h3>Programmation</h3>
                <h4>Vendredi</h4>';
        
        $vendredi->execute();
        foreach($vendredi->fetchAll() as $donnees)
            setArtiste($donnees['nom'],$donnees['genre'],$donnees['pays'],'artistes',$donnees['id'], $donnees['image']);
        $vendredi->closeCursor();
        
        echo '<h4>Samedi</h4>';
        
        $samedi->execute();
        foreach($samedi->fetchAll() as $donnees)
            setArtiste($donnees['nom'],$donnees['genre'],$donnees['pays'],'artistes',$donnees['id'], $donnees['image']);
        $samedi->closeCursor();
        
        echo '<h4>Dimanche</h4>';
        
        $dimanche->execute(); 
        foreach($dimanche->fetchAll() as $donnees)
            setArtiste($donnees['nom'],$donnees['genre'],$donnees['pays'],'artistes',$donnees['id'], $donnees['image']);
        $dimanche->closeCursor();
    }
    catch(Exception $e)
    {
        error($e);
    }
?>