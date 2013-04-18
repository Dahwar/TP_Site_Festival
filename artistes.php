<?php
    try
    {
        $allGenre = array();
        $afficheArtistes = array();
        $recherche = array();
        $execute = array();
        $jour = array();
        $vendredi = 0;
        $samedi = 0;
        $dimanche = 0;
        
        if(!empty($_POST['genre']) && $_POST['genre'] != '0'){
            $recherche[] = 'genre = :genre';
            $execute['genre'] = $_POST['genre'];
        }
        
        $sql = 'SELECT id, nom, genre, pays, image FROM artistes';
        
        if($recherche)
            $sql .= ' WHERE ' . implode(' AND ', $recherche);
        
        if(isset($_POST['vendredi']) && $_POST['vendredi'] == 'on')
            $jour[] = 'vendredi = 1';
        if(isset($_POST['samedi']) && $_POST['samedi'] == 'on')
            $jour[] = 'samedi = 1';
        if(isset($_POST['dimanche']) && $_POST['dimanche'] == 'on')
            $jour[] = 'dimanche = 1';
        
        if($jour){
            if($recherche)
                $sql .= ' AND (' . implode(' OR ', $jour). ' )';
            if(!$recherche)
                $sql .= ' WHERE ' . implode(' OR ', $jour);
        }
            
        $affiche = $bdd->prepare($sql);
        $genreMenu = $bdd->prepare('SELECT DISTINCT genre FROM artistes');
    
        $genreMenu->execute();
        foreach($genreMenu->fetchAll() as $donnees){
            $allGenre[$donnees['genre']] = ucfirst(strtolower($donnees['genre']));
        }   
        $genreMenu->closeCursor();
        
        $affiche->execute($execute);
        foreach($affiche->fetchAll() as $donnees){
            $afficheArtistes[] = $donnees;
        }   
        $affiche->closeCursor();

    }
    
    catch(Exception $e)
    {
        error($e);
    }    
?>

<h3>Artistes</h3>
<h4>Pour tous les goûts, ou presque...</h4>

    <form method="post" action="?page=artistes">
        <fieldset>
            <legend>Recherche</legend>  
                <div class="input">
                <div class="input-label"><label for="genre">Par genre : </label></div>
                <div class="controls"><select name="genre" id="genre">
                    <option value="0">Tous les genres</option>

<?php
    $last_genre = isset($_POST['genre']) ? htmlspecialchars($_POST['genre']) : null;
    

    foreach($allGenre as $value => $text)
        echo '<option value="', urlencode($value),'"',($last_genre == $value ? ' selected="selected"' : null),'>',$text,'</option>';
?>

                    </select></div>
                </div>
                <div class="input">
                    <div class="input-label"><label>Par date : </label></div>
                    <div class="divCheckbox"><input type="checkbox" name="vendredi" id="vendredi" class="checkbox" <?php echo (isset($_POST['vendredi']) && $_POST['vendredi'] == 'on')? 'checked="checked"':null; ?> /></div>
                    <div class="divCheckbox"><label for="vendredi" class="checkboxLabel">Vendredi</label></div>
                    <div class="divCheckbox"><input type="checkbox" name="samedi" id="samedi" class="checkbox" <?php echo (isset($_POST['samedi']) && $_POST['samedi'] == 'on')? 'checked="checked"':null; ?> /></div>
                    <div class="divCheckbox"><label for="samedi" class="checkboxLabel">Samedi</label></div>
                    <div class="divCheckbox"><input type="checkbox" name="dimanche" id="dimanche" class="checkbox" <?php echo (isset($_POST['dimanche']) && $_POST['dimanche'] == 'on')? 'checked="checked"':null; ?> /></div>
                    <div class="divCheckbox"><label for="dimanche" class="checkboxLabel">Dimanche</label></div>
                </div>
            <div class="button"><input type="submit" value="Valider" /></div><br />
        </fieldset>
    </form>
    
<?php
    foreach($afficheArtistes as $donnees)
        setArtiste($donnees['nom'],$donnees['genre'],$donnees['pays'],'artistes',$donnees['id'], $donnees['image']);
?>
  