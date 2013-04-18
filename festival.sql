-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Mar 29 Mai 2012 à 07:56
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `festival`
--

-- --------------------------------------------------------

--
-- Structure de la table `artistes`
--

CREATE TABLE IF NOT EXISTS `artistes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  `siteWeb` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `vendredi` int(10) NOT NULL,
  `samedi` int(11) NOT NULL,
  `dimanche` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `artistes`
--

INSERT INTO `artistes` (`id`, `nom`, `genre`, `pays`, `description`, `siteWeb`, `video`, `vendredi`, `samedi`, `dimanche`, `image`) VALUES
(1, 'liz green', 'folk', 'royaume-uni', 'Liz Green est apparue une première fois en 2008, pour disparaître presque instantanément. Repérée l''année précédente au festival de Glastonbury, l''Anglaise était venue à Paris jouer en épilogue d''un concert organisé dans un appartement montmartrois par la Blogothque, le site musical qui se lanait alors dans ce genre de moments privilégiés offerts à quelques-uns.\r\n\r\nBon Iver était la star du soir, mais c''est avec Liz Green qu''on avait fini la nuit dans un petit bar de la Butte. Elle avait chanté seule des complaintes blues-folk, avec une guitare pourrie et une voix de grand-mre du Lancashire. La bière aidant, Liz Green avait raconté des histoires de fantômes, d''oiseaux inquiétants et de french singer.\r\n\r\nParcimonie. Elle est revenue chanter en France quelquefois par la suite, puis elle s''est noyée dans le paysage sans me laisser d''album. Plus de trois ans plus tard, revoilà Liz Green avec ce premier disque, O, Devotion ! où elle évolue dans sa zone de confort en mettant au propre les chansons qu''on l''entendait déjà chanter en 2008.', 'http://www.liz-green-music.fr/', 'http://www.youtube.com/embed/0E9BJkTRnmQ', 1, 0, 0, 'liz-green'),
(2, 'david bowie', 'pop', 'royaume-uni', 'David Bowie, de son vrai nom David Robert Jones, né le 8 janvier 1947 à Londres, dans le quartier de Brixton est un chanteur, compositeur, producteur de disques et acteur britannique. Au long de plus de quatre décennies d''''une carrière marquée par les changements fréquents de direction et de style, il s''est imposé comme un des personnages les plus originaux et imprévisibles de la musique rock, et de très nombreux artistes se sont réclamés de son influence. Il a écoulé plus de 140 millions d''''albums dans le monde 1.\r\n\r\nAprès des débuts hésitants entre le folk et la variété dans la deuxime moitié des années 60 et un détour par le mime, Bowie devient une vedette en 1972 par l''intermédiaire de son alter ego décadent Ziggy Stardust, et impose un glam rock sophistiqué et apocalyptique et des spectacles flamboyants. A cette époque, il participe aussi aux carrires solo de Lou Reed et d''Iggy Pop en tant que collaborateur et producteur. Pendant le reste de la décennie, il s''intéresse aux musiques noires (soul, funk et disco) et à la musique électronique émergente, créant des mélanges nouveaux notamment avec la complicité du producteur et musicien Brian Eno. Dans les années 80, il devient une vedette grand public et remplit les stades avec une pop efficace, puis finit la décennie avec un revirement complet, intégrant le groupe de garage rock Tin Machine. Les années 90 l''''ont vu retourner à un style plus expérimental intégrant des musiques contemporaines telles la techno et le drum''n''bass. Depuis 2004 ses apparitions se font plus rares.', 'http://www.davidbowie.com/', 'http://www.youtube.com/embed/YYjBQKIOb-w', 0, 1, 0, 'david-bowie'),
(3, 'brigitte fontaine', 'chanson', 'france', 'Disques d''or, ses albums Kékéland (2001) et Rue Saint Louis en l''île (2004) ont bénéficié de collaborations prestigieuses (Noir Désir, Sonic Youth, Archie Shepp, -M-, Gotan Project, Zebda, etc.). En 2005, après avoir donné une série de concerts avec son groupe habituel, mais aussi avec la Compagnie des musiques à ouir, elle publie chez Flammarion un nouveau roman, La Bête curieuse, dont l''ambiance érotique annonce un peu la tonalité de son quinzième album, Libido (2006). Ce nouveau disque, orchestré par Dondieu Divin, renoue avec l''énergie vivante de ses concerts dans une ambiance très "baroque''n''roll", où sont convoqués Thérèse d''Avila, les soufis, les films hollywoodiens, Melody Nelson, et beaucoup de paradoxes ! Seules collaborations pour cet album : Jean-Claude Vannier et -M- qui fait sa troisième apparition dans le fantasque univers de la Reine des Kékés.', 'http://brigittefontaine.artiste.universalmusic.fr/', 'http://www.youtube.com/embed/IlLJqORNu2Q', 1, 0, 0, 'brigitte-fontaine'),
(4, 'queen', 'rock', 'royaume-uni', 'Queen est un groupe de rock britannique, formé en 1970 à Londres par Freddie Mercury, Brian May et Roger Taylor, ces deux derniers étant issus du groupe Smile. L''année suivante, le bassiste John Deacon vient compléter la formation.\r\nGroupe britannique qui a connu le plus grand succès commercial ces trente dernières années, Queen aurait vendu plus de 300 millions d''albums à l''échelle internationale en 2009, dont 32,5 millions aux États-Unis. Un sondage d''opinion commandé en Grande-Bretagne par la BBC Two et paru en 2007 fait de Queen le "meilleur groupe britannique de tous les temps", devanant de peu les Beatles et les Rolling Stones. Queen est également l''un des pionniers du clip vidéo, ayant exploité avec succès ce mode de communication ds 1975. Queen a conservé, malgré la mort de son leader Freddie Mercury en 1991, de très nombreux admirateurs inconditionnels dans le monde entier.', 'http://www.queenonline.com/', 'http://www.youtube.com/embed/xtrEN-YKLBM', 0, 0, 1, 'Queen'),
(5, '2pac', 'hip-hop', 'usa', 'Tupac Amaru Shakur, connu sous les noms de scne de 2Pac et Makaveli, né le 16 juin 1971 à New York et mort assassiné le 13 septembre 1996 à Las Vegas, est un rappeur, pote, activiste et acteur américain.\r\n\r\nIssu d''une famille qui a milité dans les rangs des Black Panthers, Tupac Shakur a vendu plus de 75 millions d''albums dans le monde entier, faisant de lui l''un des musiciens ayant vendu le plus de disques dans le monde. Le magazine Rolling Stone l''a classé 86e dans son classement des plus grands artistes musicaux de tous les temps.\r\n\r\nParallèlement à sa carrire musicale, il était un acteur prometteur et un activiste social. La plupart des chansons de 2Pac parlent d''une enfance au milieu de la violence et de la misère dans les ghettos, du racisme, des problèmes de société et des conflits avec d''autres rappeurs. Il a milité tout au long de sa carrière pour l''égalitarisme raciale. Shakur fut d''abord un "roadie" et un danseur pour le groupe de hip-hop alternatif Digital Underground. Il a ensuite fait partie des groupes Outlawz, Digital Underground et Thug Life. Son succès a largement contribué à l''explosion commerciale mondiale du rap au cours des années 1990. Son charisme, son "flow", ses paroles travaillées et sa mort prématurée en ont fait l''une des icônes majeures de ce genre musical et une franchise rentable : il est l''un des artistes qui a sorti le plus d''albums aprs sa mort, il est classé 8e célébrité morte rapportant le plus d''argent, devanant notamment James Brown et Bob Marley en 2007.', 'http://www.2pac.com/', 'http://www.youtube.com/embed/40OmfwPaCcc', 0, 0, 1, '2pac'),
(6, 'metallica', 'metal', 'usa', 'Metallica est un groupe américain de heavy metal, pionnier du thrash metal, formé le 28 octobre 1981.\r\n\r\nMetallica est l''un des groupes du Big Four of Thrash (le Big four désigne les quatre plus importants groupes de thrash metal), aux côtés de Megadeth, Slayer et Anthrax.\r\n\r\nLe groupe a obtenu un très grand succès avec plus de 200 millions de disques vendus à travers le monde, dont 60 millions aux États-Unis. L''album Metallica (souvent appelé Black Album), sorti en 1991, fut vendu à plus de 30 millions d''exemplaires dans le monde et fut certifié 15 fois disque de platine par la RIAA.\r\n\r\nLe groupe a reçu jusqu''à maintenant 9 Grammy Awards et a reçu les honneurs de MTV les intronisant "Icônes du Rock".', 'http://www.metallica.com', 'http://www.youtube.com/embed/scDdiHIP4ag', 0, 1, 0, 'Metallica'),
(7, 'creedence clearwater revival', 'rock', 'usa', 'Creedence Clearwater Revival (souvent appelé simplement Creedence ou désigné par ses initiales CCR) est un groupe de rock aux influences blues et country, originaire de Berkeley dans la région de San Francisco. Formé en 1958 à l''initiative de l''auteur, compositeur, chanteur et guitariste, John Fogerty, du batteur Doug Clifford, du bassiste Stu Cook ; et rapidement rejoint par le frère aîné de John, Tom Fogerty ; il prendra d''abord le nom des Blue Velvets puis des Golliwogs, avant de se révéler en 1967 avec l''album Creedence Clearwater Revival.\r\n\r\nA sa séparation en 1972, Creedence Clearwater Revival aura marqué de son empreinte l''histoire du rock. Des succès planétaires comme Proud Mary, Green River ou Fortunate Son font encore partie des "cinq cents chansons qui ont forgé le rock''n''roll", six des sept albums (à l''exception de Mardi Gras) et les diverses compilations, font encore recette et sont aujourd''hui certifiés disques de platine.\r\n\r\nSon inscription au Rock and Roll Hall of Fame en 1993 consacre Creedence parmi les groupes américains les plus marquants des cinquante dernires années.', 'http://www.creedence-online.net/', 'http://www.youtube.com/embed/4Kn4ASeRaPg', 0, 1, 0, 'Creedence'),
(8, 'deadmau5', 'electro', 'canada', 'Deadmau5 (prononcé comme dead mouse en anglais, et qui veut dire "souris morte" en franais) est un artiste canadien de musique électronique, orienté vers les styles Electro House, Progressive House et Techno. Son vrai nom est Joel Zimmerman mais il a aussi utilisé Halcyon441 comme pseudonyme. Il s''est fait connaître pour des titres tels que Faxing Berlin, Not Exactly ou encore Arguru qui ont été appréciés de grands artistes et inclus dans de nombreuses compilations.', 'http://www.deadmau5.com', 'http://www.youtube.com/embed/M4LOZ9VH9sM', 1, 0, 0, 'Deadmau5'),
(9, 'florence + the machine', 'pop', 'royaume-uni', '', 'http://www.florenceandthemachine.net/', 'http://www.youtube.com/embed/j8vbZ6Mp7eg', 0, 0, 1, 'Florence');

-- --------------------------------------------------------

--
-- Structure de la table `billeterie`
--

CREATE TABLE IF NOT EXISTS `billeterie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeBillet` varchar(255) NOT NULL,
  `nombreBillet` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `billeterie`
--

INSERT INTO `billeterie` (`id`, `typeBillet`, `nombreBillet`) VALUES
(1, 'vendredi', 1000),
(2, 'samedi', 1000),
(3, 'dimanche', 1000);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `vendredi` int(11) NOT NULL DEFAULT '0',
  `samedi` int(11) NOT NULL DEFAULT '0',
  `dimanche` int(11) NOT NULL DEFAULT '0',
  `pass` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `nom`, `prenom`, `mail`, `mdp`, `admin`, `vendredi`, `samedi`, `dimanche`, `pass`) VALUES
(1, 'lacroix', 'florent', 'florent.lacroix91@gmail.com', '877ba9651fd297617bbe923ceb196e341c2d90e1', 1, 0, 0, 0, 0),
(2, 'dupont', 'jean', 'dupont-jean@orange.fr', '0cddc8db0e6763b5a8bd4d267277fda7ac229fd9', 0, 4, 0, 0, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
