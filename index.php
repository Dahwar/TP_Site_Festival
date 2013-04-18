<?php include 'common.php'; ?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
        
		<link rel="shortcut icon" href="images/favicon.png" />
        
<?php 
    // Définition constante d'index inclus
    define('INCLUDED', true);
    // Module changement css
    if(isset($_GET['css']) && !empty($_GET['css']))
        (in_array($_GET['css'], $designAutorisees))? ($_SESSION['css'] = $_GET['css']) : ($_SESSION['css'] = 'design');
    else
        isset($_SESSION['css'])?: $_SESSION['css'] = 'design';
?>        
 
		<link rel="stylesheet" href="css/<?php echo $_SESSION['css'] ?>.css" />
		
		<link rel="stylesheet" href="css/slider/default.css" />
		<link rel="stylesheet" href="css/slider/nivo-slider.css" />
		
		<title>Festival Improbable et Intemporel</title>
	</head>
	<body>
		<header>
			<div class="title">
                <a href="index.php"><div class="float"></div></a> <!-- Insertion logo en CSS -->
				<hgroup class="titleWrite">
                    <h1>Le Festival</h1>
                    <h2>Improbable et Intemporel</h2>
                </hgroup>
			</div>
			<div class="connection">
                <?php // Gestion bouton de connexion
                    if(isLogged()){
                        if(isAdmin())
                            echo '<a href="?page=billeterie-connexion">Zone Admin</a><br />(<a href="?page=deconnexion" style="font-size: .75em">Déconnexion</a>)';
                        else
                            echo '<a href="?page=billeterie-connexion">Zone Membre</a><br />(<a href="?page=deconnexion" style="font-size: .75em">Déconnexion</a>)';
                    }
                    else
                        echo '<a href="?page=billeterie-connexion">Connexion</a>'; 
                ?>
			</div>
			<nav>
				<ul>
					<?php // Affichage du menu		  
						$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'accueil';				
					  
						foreach($menuPages as $href => $text)
						  echo '<li><a href="?page=', urlencode($href), '"', (preg_match('#^'.preg_quote($href).'#si', $page) ? ' class="in"' : null), '>', $text, '</a></li>';
					?>
				</ul>
			</nav>
		</header>
		 
		<div class="global">
			<section>
				<article>
					<?php // Autorisation page
                        try
                        {
                            if(isset($pagesAutorisees[$page]))
                                include $pagesAutorisees[$page];
                            else
                                include 'error404.php';
                        }
                        catch(Exception $e)
                        {
                            error($e);
                        }
					?>
				</article>
				<aside>
					<?php if($page != 'accueil') include 'droite.php'; ?>
				</aside>
			</section>
				
			<footer>
				<div class="copyright">
                    &copy; Copyright 2012 | Original design by Dahwar | Mentions Légales
                    <p> <!-- Choix css -->
                        <a href="?page=<?php echo $page.((isset($_GET['id']))?'&amp;id='.$_GET['id']:null).'&amp;css=design' ?>"><img src="images/designBleu.png" alt="designBleu" /></a> 
                        <a href="?page=<?php echo $page.((isset($_GET['id']))?'&amp;id='.$_GET['id']:null).'&amp;css=designAlt' ?>"><img src="images/designRouge.png" alt="designRouge" /></a>
                    </p>
                </div>
                <ul>
                    <li><a href="http://fr-fr.facebook.com/" class="facebook"></a></li>
                    <li><a href="https://twitter.com/" class="twitter"></a></li>
                    <li><a href="http://vimeo.com/" class="vimeo"></a></li>
                    <li><a href="http://www.youtube.com/" class="youtube"></a></li>
                </ul>
			</footer>
		</div>	
	</body>
</html>