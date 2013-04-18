<?php
/**
 * &amp;
 * http_build_query(array('page' => 'artiste', 'id' => 1), '', '&amp;');
 */
 
// affichage erreur des blocs try/catch
    function error(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    
// vérifie sur l'utilisateur est loggé
    function isLogged(){
        return !empty($_SESSION['id']);
    }
    
//vérifie si l'utilisateur est un admin
    function isAdmin(){
        return (isLogged() && $_SESSION['admin'] == 1);
    }

// Protège les pages réservées à l'admin
    function reservedAreaToAdmin(){
        if(!isAdmin())
            Header('Location: ?page=error404');
    }

// Protège les pages réservées à l'utilisateur    
    function reservedAreaToUser(){
        if(!isLogged())
            Header('Location: ?page=error404');
    }
    
// Prend en paramètre un nombre indéfinie de variable, et vérifie si elles sont vides ou non   
    function mEmpty(){
        $args = func_get_args(); // récupère tous les (0..n) paramètres envoyé à la fonction
        foreach($args as $arg){
            if(empty($arg))
                return true;
        }
        return false; 
    }

// Cryptage MDP
    function encrypte($password){
        $salt='74e3zrKx205aefgZ133Zr';
        return sha1($salt.md5(sha1($salt.$password.$salt)));
    }
    
// Mise en forme lien artiste    
	function setArtiste($nom, $genre, $pays, $classDiv, $id, $image)
	{
		echo 	'<a href="?page=artistes-id&amp;id=',htmlspecialchars($id),'">
					<div class="', htmlspecialchars($classDiv),'">
						<img src="images/', htmlspecialchars($image), '_mini.jpg" alt="Miniature artiste" />
						<p>
							<span>', htmlspecialchars(ucwords($nom)),'</span><br />
							<em>', htmlspecialchars(ucfirst($genre)), '</em> - ', htmlspecialchars(ucfirst($pays)),
						'</p>
					</div>
				</a>';
	}

// Mise en forme page artiste	
	function createArtistePage($nom, $genre, $pays, $description, $siteWeb, $video, $image)
	{
		echo	'<div class="ficheArtiste">
					<h3>Artistes</h3>
					<h4>',htmlspecialchars($nom),'</h4>

					<p><em>',htmlspecialchars(ucfirst($genre)),'</em> - ',htmlspecialchars(ucfirst($pays)),'<br /><br /></p>

					<div class="body-content">
						<p>',($description!='')? htmlspecialchars($description) : 'Oops, la description de cet artiste n\'existe pas !','<br /><br />
						',(!empty($siteWeb))?'<a href="'.htmlspecialchars($siteWeb).'">Site Officiel</a><br /><br />':null,'
						<a href="?page=',(isLogged())? 'billeterie-reservation' : 'billeterie','">Réserver des places</a><br /><br />
						</p>
					</div>
				</div>

				<div class="imgFicheArtiste">
					<img src="images/', htmlspecialchars($image), '.jpg" alt="Artiste" />
				</div>',
                (!empty($video))?
				'<script>
					video = \'<iframe style="width: 480px; height: 360px; border: none" src="'.htmlspecialchars($video).'" frameborder="0" allowfullscreen="true"></iframe>\';
					document.write(video);
				</script>':null,'';
	}
?>