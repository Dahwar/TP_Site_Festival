<?php
    try
    {
        reservedAreaToUser();
       
        $arrayBillet = array();
        
        // récupère le nombre de billets achetées pour un jour données
        $recupBilletVendredi = $bdd->prepare('SELECT SUM(vendredi) as nb FROM users');
        $recupBilletSamedi = $bdd->prepare('SELECT SUM(samedi) as nb FROM users');
        $recupBilletDimanche = $bdd->prepare('SELECT SUM(dimanche) as nb FROM users');
        $recupBilletPass = $bdd->prepare('SELECT SUM(pass) as nb FROM users');
        
        // récupère le nombre de billet disponible pour un jour et le nombre min de billet disponible sur les 3 jours (pour le pass)
        $recupBilletTotal = $bdd->prepare('SELECT nombreBillet FROM billeterie WHERE typeBillet=:jour');
        $recupPassRestant = $bdd->prepare('SELECT MIN(nombreBillet) as nombreBillet FROM billeterie');
        
        // récupère le nombre de billets déjà acquis par l'user pour un type données
        $recupUsersV = $bdd->prepare('SELECT vendredi FROM users WHERE id=:id');
        $recupUsersS = $bdd->prepare('SELECT samedi FROM users WHERE id=:id');
        $recupUsersD = $bdd->prepare('SELECT dimanche FROM users WHERE id=:id');
        $recupUsersP = $bdd->prepare('SELECT pass FROM users WHERE id=:id');

        //MAJ du nombre de billet achetée par l'user
        $majUsersV = $bdd->prepare('UPDATE users SET vendredi=:nombreBillet WHERE id=:id');
        $majUsersS = $bdd->prepare('UPDATE users SET samedi=:nombreBillet WHERE id=:id');
        $majUsersD = $bdd->prepare('UPDATE users SET dimanche=:nombreBillet WHERE id=:id');
        $majUsersP = $bdd->prepare('UPDATE users SET pass=:nombreBillet WHERE id=:id');

       
        if(isset($_POST['formule'], $_POST['billet']) && !mEmpty($_POST['formule'], $_POST['billet'])){
        
            if($_POST['formule'] == 'vendredi'){
                $recupUsersV->execute(array('id'=>$_SESSION['id'])); // récupère le nombre de billet déjà acquis par l'utilisateur pour vendredi
                $donneesRecupUsers = $recupUsersV->fetch();
                $recupUsersV->closeCursor();
            }
            if($_POST['formule'] == 'samedi'){
                $recupUsersS->execute(array('id'=>$_SESSION['id'])); // récupère le nombre de billet déjà acquis par l'utilisateur pour samedi
                $donneesRecupUsers = $recupUsersS->fetch();
                $recupUsersS->closeCursor();
            }
            if($_POST['formule'] == 'dimanche'){
                $recupUsersD->execute(array('id'=>$_SESSION['id'])); // récupère le nombre de billet déjà acquis par l'utilisateur pour dimanche
                $donneesRecupUsers = $recupUsersD->fetch();
                $recupUsersD->closeCursor();
            }
            if($_POST['formule'] == 'pass'){
                $recupUsersP->execute(array('id'=>$_SESSION['id'])); // récupère le nombre de billet déjà acquis par l'utilisateur pour pass 3 jours
                $donneesRecupUsers = $recupUsersP->fetch();
                $recupUsersP->closeCursor();
            }
            
            $recupBilletTotal->execute(array('jour'=>$_POST['formule'])); // recupère le nombre de billet total pour un jour donné
            $donneesBilletTotal = $recupBilletTotal->fetch();
            
            if($recupBilletTotal->rowCount() == 1 && $_POST['formule'] != 'pass'){ // si on réserve autre chose qu'un pass
                $recupBilletTotal->closeCursor();
                
                if(!empty($donneesRecupUsers)){
                
                $recupBilletPass->execute();
                $donneesBilletPass = $recupBilletPass->fetch();
                
                    if($_POST['formule'] == 'vendredi'){
                        $recupBilletVendredi->execute();
                        $donneesBilletVendredi = $recupBilletVendredi->fetch();
                        $recupBilletVendredi->closeCursor();
                        if(($donneesBilletVendredi['nb'] + $donneesBilletPass['nb'] + $_POST['billet']) <= $donneesBilletTotal['nombreBillet']){
                            $majUsersV->execute(array('nombreBillet'=>$_POST['billet'] + $donneesRecupUsers[$_POST['formule']],'id'=>$_SESSION['id']));
                            echo '<p class="validFormulaire">Commande effectuée avec succès !</p>';
                        }
                        else 
                            echo '<p class="erreurFormulaire">Erreur : plus assez de billet disponible pour satisfaire votre commande.</p>';
                    }
                    if($_POST['formule'] == 'samedi'){
                        $recupBilletSamedi->execute();
                        $donneesBilletSamedi = $recupBilletSamedi->fetch();
                        $recupBilletSamedi->closeCursor();
                        if(($donneesBilletSamedi['nb'] + $donneesBilletPass['nb'] + $_POST['billet']) <= $donneesBilletTotal['nombreBillet']){
                            $majUsersS->execute(array('nombreBillet'=>$_POST['billet'] + $donneesRecupUsers[$_POST['formule']],'id'=>$_SESSION['id']));
                            echo '<p class="validFormulaire">Commande effectuée avec succès !</p>';
                        }
                        else 
                            echo '<p class="erreurFormulaire">Erreur : plus assez de billet disponible pour satisfaire votre commande.</p>';
                    }
                    if($_POST['formule'] == 'dimanche'){
                        $recupBilletDimanche->execute();
                        $donneesBilletDimanche = $recupBilletDimanche->fetch();
                        $recupBilletDimanche->closeCursor();
                        if(($donneesBilletDimanche['nb'] + $donneesBilletPass['nb'] + $_POST['billet']) <= $donneesBilletTotal['nombreBillet']){
                            $majUsersD->execute(array('nombreBillet'=>$_POST['billet'] + $donneesRecupUsers[$_POST['formule']],'id'=>$_SESSION['id']));
                            echo '<p class="validFormulaire">Commande effectuée avec succès !</p>';
                        }
                        else 
                            echo '<p class="erreurFormulaire">Erreur : plus assez de billet disponible pour satisfaire votre commande.</p>';
                    }
                }
                else echo '<p class="erreurFormulaire">Erreur 1</p>';
            }
                
            if($_POST['formule'] == 'pass'){ // si on réserve un pass

                $recupBilletVendredi->execute();
                $donneesBilletVendredi = $recupBilletVendredi->fetch();
                $arrayBillet[] = $donneesBilletVendredi['nb'];
                $recupBilletVendredi->closeCursor();
                
                $recupBilletSamedi->execute();
                $donneesBilletSamedi = $recupBilletSamedi->fetch();
                $arrayBillet[] = $donneesBilletSamedi['nb'];
                $recupBilletSamedi->closeCursor();
                
                $recupBilletDimanche->execute();
                $donneesBilletDimanche = $recupBilletDimanche->fetch();
                $arrayBillet[] = $donneesBilletDimanche['nb'];
                $recupBilletDimanche->closeCursor();
                
                $recupBilletPass->execute();
                $donneesBilletPass = $recupBilletPass->fetch();
                
                $recupPassRestant->execute();
                $donneesPassRestant = $recupPassRestant->fetch();
                $recupPassRestant->closeCursor();
                
                if((max($arrayBillet) + $_POST['billet'] + $donneesBilletPass['nb']) <= $donneesPassRestant['nombreBillet']){
                    $majUsersP->execute(array('nombreBillet'=>$_POST['billet'] + $donneesRecupUsers[$_POST['formule']],'id'=>$_SESSION['id']));
                    echo '<p class="validFormulaire">Commande effectuée avec succès !</p>';
                }
                else 
                    echo '<p class="erreurFormulaire">Erreur : plus assez de billet disponible pour satisfaire votre commande.</p>';
            }
        }
    }
    catch(Exception $e)
    {
        error($e);
    }
?>

<h3>Billeterie</h3>
<h4>Réserver vos billets</h4>

<form method="post" action="?page=billeterie-reservation">
    <fieldset>
        <legend>Veuillez sélectionner une formule</legend>
            <div class="input">
                <div class="input-label"><label for="formule">Formule : </label></div>
                <div class="controls"><select name="formule" id="formule">
                    <option value="pass">Pass 3 jours</option>
                    <option value="vendredi">Pass Vendredi (1 jour)</option>
                    <option value="samedi">Pass Samedi (1 jour)</option>
                    <option value="dimanche">Pass Dimanche (1 jour)</option>
                </select></div>
            </div>
            
            <div class="reservation">Veuillez sélectionner le nombre de billets de la formule choisie</div>
            
            <div class="input">
                <div class="input-label"><label for="billet">Nombre de billets : </label></div>
                <div class="controls"><select name="billet" id="billet">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select></div>
            </div>
           <div class="button"><input type="submit" value="Valider" /></div><br />
    </fieldset>
</form>

    
