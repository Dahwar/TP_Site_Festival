<?php
    try
    {   
        $donneesPass = array();
    
        $recupPassVendredi = $bdd->prepare('SELECT vendredi FROM users WHERE id=:id');
        $recupPassSamedi = $bdd->prepare('SELECT samedi FROM users WHERE id=:id');
        $recupPassDimanche = $bdd->prepare('SELECT dimanche FROM users WHERE id=:id');
        $recupPassVSD = $bdd->prepare('SELECT pass FROM users WHERE id=:id');
    
        $verif = $bdd->prepare('SELECT id, nom, prenom, admin FROM users WHERE mail=:mail AND mdp=:mdp');

        if(isLogged()){
            $recupPassVendredi->execute(array('id'=>$_SESSION['id']));
            $recupPassSamedi->execute(array('id'=>$_SESSION['id']));
            $recupPassDimanche->execute(array('id'=>$_SESSION['id']));
            $recupPassVSD->execute(array('id'=>$_SESSION['id']));
            
            $donneesPassVendredi = $recupPassVendredi->fetch();
            $donneesPassSamedi = $recupPassSamedi->fetch();
            $donneesPassDimanche = $recupPassDimanche->fetch();
            $donneesPass3 = $recupPassVSD->fetch();
        }
        
        // Vérification formulaire
        if(!isLogged()){
            if(!empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) //@link http://fr.php.net/filter_var
                $email = htmlspecialchars($_POST['email']);
                
            if(!empty($_POST['password']))
                $password = encrypte(htmlspecialchars($_POST['password']));
                
            if(isset($email) && isset($password)){
                $verif->execute(array('mail' => $email, 'mdp'=>$password));
                
                // Connexion
                if($verif->rowCount() == 1) {
                    $donnees = $verif->fetch(PDO::FETCH_ASSOC); // met sous forme de tableau
                    $_SESSION = array_merge($_SESSION, $donnees); // met sous la forme $_SESSION['id'] = $donnees['id'],...
                    Header('Location: ?page=' . $page); // mets à jour la page, car modification des données
                }
            }
            $verif->closeCursor();
        }
    }
    catch(Exception $e)
    {
        error($e);
    }
?>

<h3>Billeterie</h3>

<?php // Gestion de l'affichage en fonction du mode de connexion
    if($page == 'billeterie-connexion')
        echo '<h4>Connexion à l\'espace admin</h4>';
    
    if($page == 'billeterie')
        echo '<h4>Connexion à la billeterie</h4>';
    
    if(isLogged()){
        echo    '<p>Vous êtes connecté en tant qu\'', ($_SESSION['admin']==1)?'administrateur':'utilisateur',', que souhaitez vous faire ?</p>
                <div class="lienPucePage">   
                    <ul>
                        <li><a href="?page=billeterie-reservation">Réserver des billets</a></li>',
                        ($_SESSION['admin']==1)?'<li><a href="?page=billeterie-creationFicheArtiste">Accéder à l\'espace administrateur</a></li>':null,'
                        <li><a href="?page=deconnexion">Se déconnecter</a></li>
                    </ul>
                </div>
                <div>
                    <ul>
                        <li>Nombre de passe vendredi acheté : ',$donneesPassVendredi['vendredi'],'</li>
                        <li>Nombre de passe samedi acheté : ',$donneesPassSamedi['samedi'],'</li>
                        <li>Nombre de passe dimanche acheté : ',$donneesPassDimanche['dimanche'],'</li>
                        <li>Nombre de passe 3 jours acheté : ',$donneesPass3['pass'],'</li>
                    </ul>
                </div>';
    }
    
    if(!isLogged() && $page == 'billeterie-connexion')
        echo '<p>Pour accéder à l\'espace administration, vous devez vous connecter.</p>';
    
    if(!isLogged() && $page == 'billeterie')
        echo '<p>Pour accéder à la billeterie, vous devez vous connecter.</p><h5>Vous avez déjà un compte ?</h5>';
        
        
    if(!isLogged()){
        
        echo    '<form method="post" action="?page=billeterie-connexion">
                    <fieldset>
                        <legend>Veuillez vous identifier</legend>
                            <div class="input">
                                ',(isset($_POST['email']) || isset($_POST['password']))? '<p class="erreurFormulaire">Erreur dans la saisie des données, veuillez recommencer.</p>':null,'
                                <div class="input-label"><label for="email">Adresse mail : </label></div>
                                <div class="controls"><input type="email" name="email" id="email" required="required" value="',(!empty($_POST['email']))?htmlspecialchars($_POST['email']):null,'"/></div>
                            </div>
                            
                            <div class="input">
                                <div class="input-label"><label for="password">Mot de passe : </label></div>
                                <div class="controls"><input type="password" name="password" id="password" required="required" /></div>
                            </div>
                        <div class="button"><input type="submit" value="Valider" /></div><br />
                        <p class="petit">Si vous avez oublié votre mot de passe, <a href="#">cliquez ici</a></p>
                    </fieldset>
                </form>';
    }
    
    if(!isLogged() && $page == 'billeterie'){
        echo    '<h5>Vous êtes un nouveau festivalier ?</h5>
                <p>Bienvenue !<br />Enregistrez-vous pour commander et accéder à nos services.<br /><br />
                <a href="?page=billeterie-creationCompte" class="gros">Créer un compte</a><br /><br />
                Nous nous engageons à sécuriser vos informations et à les garder strictement confidentielles.<br /><br />
                Pour en savoir plus et connaître nos services, <a href="#">cliquez ici</a>
                </p>';
    }
?>

