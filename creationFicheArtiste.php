<?php 
    try
    {
        reservedAreaToAdmin();

        $insert = $bdd->prepare('INSERT INTO artistes(nom, description, genre, pays, siteWeb, video, vendredi, samedi, dimanche, image) VALUES(:nom, :description, :genre, :pays, :siteWeb, :video, :vendredi, :samedi, :dimanche, :image)');    
        $verif = $bdd->prepare('SELECT image FROM artistes WHERE image=:image');
        $allArtistes = $bdd->prepare('SELECT nom, image FROM artistes');
        $deleteArtiste = $bdd->prepare('DELETE FROM artistes WHERE image=:image');
        
        $reaffiche = 1;
        $errorImage = 0;
        $error = 0;

        // Suppression artiste
        if(!empty($_POST['artiste'])){
            unlink('images/'.$_POST['artiste'].'.jpg');
            unlink('images/'.$_POST['artiste'].'_mini.jpg');
            
        $deleteArtiste->execute(array('image' => $_POST['artiste']));
        
        echo '<p class="validFormulaire">Artiste supprimé</p>';
            
        }  
        
        // Vérification image upload
        if(isset($_FILES['image']) && !empty($_FILES['image'])){
            if($_FILES['image']['error'] != 0){
                echo '<p class="erreurFormulaire">Erreur : échec lors de la transmission du ficher !</p>';
                $errorImage = 1;
            }
            
            if($errorImage == 0 && $_FILES['image']['size'] >= 1200000)
            {
                echo '<p class="erreurFormulaire">Erreur : fichier trop lourd, taille limitée à 1Mo</p>';
                $errorImage = 1;
            }
            
            if($errorImage == 0){
                $image_sizes = getimagesize($_FILES['image']['tmp_name']); 
                if ($image_sizes[0] != 150 OR $image_sizes[1] != 150){
                    echo '<p class="erreurFormulaire">Erreur : l\'image doit faire 150x150px !</p>';
                    $errorImage = 1;
                }
            }
            
            if($errorImage == 0){
                $infosfichier = pathinfo($_FILES['image']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg');

                if (!in_array($extension_upload, $extensions_autorisees)){
                    echo '<p class="erreurFormulaire">Erreur : l\'extension du fichier n\'est pas supportée (autorisé seulement : .jpg)</p>';
                    $errorImage = 1;
                }
            }
        }
        
        // Vérification formulaire
        if ($errorImage == 0 &&  
            isset($_POST['nom'], $_POST['description'], $_POST['genre'], $_POST['pays']) && 
            !mEmpty($_POST['nom'], $_POST['description'], $_POST['genre'], $_POST['pays']) &&
            ((isset($_POST['vendredi']) && $_POST['vendredi'] == 'on') || (isset($_POST['samedi']) && $_POST['samedi'] == 'on') || (isset($_POST['dimanche']) && $_POST['dimanche'] == 'on'))){
            
            if(!empty($_POST['siteWeb']) && !filter_var($_POST['siteWeb'], FILTER_VALIDATE_URL)){
                echo '<p class="erreurFormulaire">Erreur : URL site web invalide !</p>';
                $error = 1;
            }
            
            if(!empty($_POST['video']) && !filter_var($_POST['video'], FILTER_VALIDATE_URL)){
                echo '<p class="erreurFormulaire">Erreur : URL vidéo invalide !</p>';
                $error = 1;
            }
            
            if($error == 0){
            
                $nomFichier = 'images/' . str_replace(' ','',strtolower($_POST['nom'])) . '.jpg';
                move_uploaded_file($_FILES['image']['tmp_name'], $nomFichier);
                
                // Création image miniature
                $source = imagecreatefromjpeg($nomFichier); // source image
                $destination = imagecreatetruecolor(60, 60); // création image vide

                $largeur_source = imagesx($source); // imagesx renvoie la largeur de l'image
                $hauteur_source = imagesy($source); // imagesy renvoie la hauteur de l'image
                $largeur_destination = imagesx($destination);
                $hauteur_destination = imagesy($destination);

                imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source); // création miniature

                imagejpeg($destination, 'images/' . str_replace(' ','',strtolower($_POST['nom'])) . '_mini.jpg'); // enregistrement miniature
                
                $verif->execute(array('image' => str_replace(' ','',strtolower($_POST['nom']))));
                
                // Validation formulaire
                if($verif->rowCount() == 0){
                    $insert->execute(array(
                        'nom' => strtolower($_POST['nom']),
                        'description' => $_POST['description'],
                        'genre' => strtolower($_POST['genre']),
                        'pays' => strtolower($_POST['pays']),
                        'siteWeb' => isset($_POST['siteWeb'])? $_POST['siteWeb'] : null,
                        'video' => isset($_POST['video'])? $_POST['video'] : null,
                        'vendredi' => isset($_POST['vendredi'])? '1':'0',
                        'samedi' => isset($_POST['samedi'])? '1':'0',
                        'dimanche' => isset($_POST['dimanche'])? '1':'0',
                        'image' => str_replace(' ','',strtolower($_POST['nom'])),
                    ));
                        echo '<p class="validFormulaire">Nouvel artiste créé !</p>';
                        $_POST = array();
                }
                else
                    echo '<p class="erreurFormulaire">Erreur : l\'artiste ',htmlspecialchars($_POST['nom']),' existe déjà !</p>';
                
                $verif->closeCursor();
            }
        }
        else
            echo '<p class="erreurFormulaire">Aucun artiste crée.</p>';
    }
    catch(Exception $e)
    {
        error($e);
    }
?>

<h3>Billeterie - Espace administration</h3>
<h4>Édition des fiches artistes</h4>
                
<form method="post" action="?page=billeterie-creationFicheArtiste" enctype="multipart/form-data">
    <fieldset>
        <legend>Veuillez saisir les informations</legend>
            <div class="input">
                <div class="input-label"><label for="nom">Nom : </label></div>
                <div class="controls"><input type="text" name="nom" id="nom" required="required" value="<?php echo (isset($_POST['nom']))? htmlspecialchars($_POST['nom']) : null; ?>" /></div>
            </div>
       
            <div class="input">
                <div class="input-label"><label for="description">Description : </label></div>
                <div class="controls">
                    <textarea name="description" id="description" required="required"><?php echo (isset($_POST['description']))? htmlspecialchars($_POST['description']) : null; ?></textarea>
                </div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="genre">Genre : </label></div>
                <div class="controls"><input type="text" name="genre" id="genre" required="required" value="<?php echo (isset($_POST['genre']))? htmlspecialchars($_POST['genre']) : null; ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="pays">Pays : </label></div>
                <div class="controls"><input type="text" name="pays" id="pays" required="required" value="<?php echo (isset($_POST['pays']))? htmlspecialchars($_POST['pays']) : null; ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="siteWeb">Site Web : </label></div>
                <div class="controls"><input type="url" name="siteWeb" id="siteWeb" value="<?php echo (isset($_POST['siteWeb']))? htmlspecialchars($_POST['siteWeb']) : null; ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="video">Vidéo : </label></div>
                <div class="controls"><input type="url" name="video" id="video" value="<?php echo (isset($_POST['video']))? htmlspecialchars($_POST['video']) : null; ?>" /></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label>Date : </label></div>
                <div class="divCheckbox"><input type="checkbox" name="vendredi" id="vendredi" class="checkbox" <?php echo (isset($_POST['vendredi']))? 'checked="checked"' : null; ?>/></div>
                <div class="divCheckbox"><label for="vendredi" class="checkboxLabel">Vendredi</label></div>
                <div class="divCheckbox"><input type="checkbox" name="samedi" id="samedi" class="checkbox" <?php echo (isset($_POST['samedi']))? 'checked="checked"' : null; ?> /></div>
                <div class="divCheckbox"><label for="samedi" class="checkboxLabel">Samedi</label></div>
                <div class="divCheckbox"><input type="checkbox" name="dimanche" id="dimanche" class="checkbox" <?php echo (isset($_POST['dimanche']))? 'checked="checked"' : null; ?> /></div>
                <div class="divCheckbox"><label for="dimanche" class="checkboxLabel">Dimanche</label></div>
            </div>
            
            <div class="input">
                <div class="input-label"><label for="image">Image : </label></div>
                <div class="controls"><input type="file" name="image" id="image" class="envoiImage" required="required" /></div>
            </div>
            <div class="button"><input type="submit" value="Valider" /></div><br />
    </fieldset>
</form>

<h4>Supprimer un artiste</h4>

<form method="post" action="?page=billeterie-creationFicheArtiste">
    <fieldset>
        <legend>Supprimer un artiste</legend>  
            <div class="input">
            <div class="input-label"><label for="artiste">Choisissez l'artiste : </label></div>
                <div class="controls"><select name="artiste" id="artiste">
                    <option value="0"></option>

<?php
    $allArtistes->execute();
    foreach($allArtistes->fetchAll() as $donnees)
            echo '<option value="',$donnees['image'],'">',htmlspecialchars(ucwords($donnees['nom'])),'</option>';
    $allArtistes->closeCursor();
?>
                </select>
                </div>
            </div>
            <div class="button"><input type="submit" value="Valider" /></div><br />
    </fieldset>
</form>