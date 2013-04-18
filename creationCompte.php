<?php
    try
    {
        $insert = $bdd->prepare('INSERT INTO users(nom, prenom, mail, mdp, admin) VALUES(:nom, :prenom, :mail, :mdp, :admin)');
        $verif = $bdd->prepare('SELECT mail FROM users WHERE mail=:mail');

        $error = 0;
        $errorEmailExist = -1;
        $errorEmail = 0;
        $errorPassword = 0;
        
        // Vérification formulaire
        if  (isset($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['password'],$_POST['passwordConfirme']) && 
            !mEmpty($_POST['nom'],$_POST['prenom'],$_POST['email'],$_POST['password'],$_POST['passwordConfirme'])){
            
            if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                $errorEmail = 1;
                $error = 1;
            }
            
            if($_POST['password'] != $_POST['passwordConfirme']){
                $errorPassword = 1;
                $error = 1;
            }
            
            // Validation formulaire
            if($error == 0){
                $verif->execute(array('mail' => strtolower($_POST['email'])));
                if($verif->rowCount() == 0){
                    $insert->execute(array(
                        'nom' => strtolower($_POST['nom']),
                        'prenom' => strtolower($_POST['prenom']),
                        'mail' => strtolower($_POST['email']),
                        'mdp' => encrypte($_POST['password']),
                        'admin' => 0,
                    ));
                    $errorEmailExist = 0;
                    $_POST = array();
                }
                else
                    $errorEmailExist = 1;
                    
                $verif->closeCursor();
            }
        }
    }
    catch(Exception $e)
    {
       error($e);
    }
?>

<h3>Créer votre compte festivalier</h3>

<div class="body-content">
	<p>
		Être inscrit sur le site du Festival, vous permet d'accéder à la billeterie. Toutes
		les informations demandées et obligatoires lors de la création de "votre compte" sont 
		nécessaires au bon traitement de votre commande.<br />
		Elles vous permettront en effet de pouvoir : 
		<ul>
			<li>recevoir vos billets,</li>
			<li>être prévenu en cas d'annulation de la manifestation,</li>
			<li>consulter l'état de vos commandes en ligne,</li>
			<li>faire votre prochaine réservation en quelques clics.</li>
		</ul>
	</p>
</div>

<form method="post" action="?page=billeterie-creationCompte">
	<fieldset>
		<legend>Entrer les informations demandées</legend>
        
<?php 
    echo ($errorEmailExist == 1)? '<p class="erreurFormulaire">Erreur : cette adresse mail existe déjà !</p>' : null; 
    echo ($errorEmailExist == 0)? '<p class="validFormulaire">Compte créé avec succès ! Vous pouvez dès à présent vous connecter !</p>' : null; 
    echo ($errorEmail == 1)? '<p class="erreurFormulaire">Erreur : adresse email non valide !</p>' : null ;
    echo ($errorPassword == 1)? '<p class="erreurFormulaire">Erreur : confirmation mot de passe invalide !</p>' : null ;
?>
        
            <div class="input">
                <div class="input-label"><label for="nom">Nom : *</label></div>
                <div class="controls"><input type="text" name="nom" id="nom" required="true" value="<?php echo (isset($_POST['nom']))? htmlspecialchars($_POST['nom']) : null ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="prenom">Prénom : *</label></div>
                <div class="controls"><input type="text" name="prenom" id="prenom" required="true" value="<?php echo (isset($_POST['prenom']))? htmlspecialchars($_POST['prenom']) : null ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="email">Adresse mail : *</label></div>
                <div class="controls"><input type="email" name="email" id="email" required="true" value="<?php echo (isset($_POST['email']))? htmlspecialchars($_POST['email']) : null ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="password">Choisissez un mot de passe : *</label></div>
                <div class="controls"><input type="password" name="password" id="password" required="true" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="password">Confirmer le mot de passe : *</label></div>
                <div class="controls"><input type="password" name="passwordConfirme" id="password" required="true" /></div>
            </div>
            
            <p class="petit">Les champs marqués d'un étoile * sont obligatoires.</p>
            <div class="button"><input type="submit" value="Valider" /></div><br />
            <p class="petit">
                Votre adresse e-mail restera strictement confidentielle, ne sera divulguée 
                à un tiers ni spammée. Conformément à la loi Informatique et Liberté de 6 janvier 
                1978, vous disposez d'un droit d'accès, de rectification et d'opposition relatif aux
                informations vous concernant. Pour plus de détails, <a href="#">cliquez ici</a><br /><br />
            </p>
	</fieldset>
</form>