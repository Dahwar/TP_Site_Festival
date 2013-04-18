<?php
    try
    { 
        $nombreMinBillet = array();
        
        $recupBilletVendredi = $bdd->prepare('SELECT SUM(vendredi) as nb FROM users');
        $recupBilletSamedi = $bdd->prepare('SELECT SUM(samedi) as nb FROM users');
        $recupBilletDimanche = $bdd->prepare('SELECT SUM(dimanche) as nb FROM users');
        $recupBilletPass = $bdd->prepare('SELECT SUM(pass) as nb FROM users');
        
        $recupBilletTotal = $bdd->prepare('SELECT nombreBillet FROM billeterie WHERE typeBillet=:jour');
        
        $droite = $bdd->prepare('SELECT id, nom, genre, pays, image FROM artistes WHERE CHAR_LENGTH(nom) < 18 ORDER BY RAND() LIMIT 0,1');
    
        $recupBilletPass->execute();
        $donneesBilletPass = $recupBilletPass->fetch();
    
    
        echo    '<h4 class="droite">Et aussi...</h4>
                <h5 class="droite">Places restantes</h5>
                    <div class="placesRestantes">
                        <ul>
                            <li>Pass Vendredi : ';
        
        $recupBilletVendredi->execute();
        $donneesVendredi = $recupBilletVendredi->fetch();
        $recupBilletVendredi->closeCursor();
        
        $recupBilletTotal->execute(array('jour'=>'vendredi'));
        $donneesBilletTotalV = $recupBilletTotal->fetch();
        $recupBilletTotal->closeCursor();
        
        echo htmlspecialchars($donneesBilletTotalV['nombreBillet'] - $donneesVendredi['nb'] - $donneesBilletPass['nb']);
        $nombreMinBillet[] = htmlspecialchars($donneesBilletTotalV['nombreBillet'] - $donneesVendredi['nb'] - $donneesBilletPass['nb']);
               
                
        echo    '</li>
                            <li>Pass Samedi : ';
                
        $recupBilletSamedi->execute();
        $donneesSamedi = $recupBilletSamedi->fetch();
        $recupBilletSamedi->closeCursor();
        
        $recupBilletTotal->execute(array('jour'=>'samedi'));
        $donneesBilletTotalS = $recupBilletTotal->fetch();
        $recupBilletTotal->closeCursor();
        
        echo htmlspecialchars($donneesBilletTotalS['nombreBillet'] - $donneesSamedi['nb'] - $donneesBilletPass['nb']);
        $nombreMinBillet[] = htmlspecialchars($donneesBilletTotalS['nombreBillet'] - $donneesSamedi['nb'] - $donneesBilletPass['nb']);                
                
        echo    '</li>
                            <li>Pass Dimanche : ';
                
        $recupBilletDimanche->execute();
        $donneesDimanche = $recupBilletDimanche->fetch();
        $recupBilletDimanche->closeCursor();
        
        $recupBilletTotal->execute(array('jour'=>'dimanche'));
        $donneesBilletTotalD = $recupBilletTotal->fetch();
        $recupBilletTotal->closeCursor();
        
        echo htmlspecialchars($donneesBilletTotalD['nombreBillet'] - $donneesDimanche['nb'] - $donneesBilletPass['nb']);
        $nombreMinBillet[] = htmlspecialchars($donneesBilletTotalD['nombreBillet'] - $donneesDimanche['nb'] - $donneesBilletPass['nb']);
        
        echo    '</li>
                            <li>Pass 3 jours : ',min($nombreMinBillet),'</li>
                        </ul>
                    </div>
                <h5 class="droite">La sélection du jour</h5>';
        
        $droite->execute();
        
        foreach($droite->fetchAll() as $donnees)
            setArtiste($donnees['nom'],$donnees['genre'],$donnees['pays'],'artistes-droite',$donnees['id'], $donnees['image']);
        $droite->closeCursor();
    }
    catch(Exception $e)
    {
        error($e);
    }
?>

<h5 class="droite">Et ailleurs...</h5>
	<div class="ailleurs">
		<ul>
			<li><a href="#">Festival les inRocks</a></li>
			<li><a href="#">Les Eurockéennes</a></li>
			<li><a href="#">Les Francomanias</a></li>
			<li><a href="#">Bêtes de scène</a></li>
		</ul>
	</div>
