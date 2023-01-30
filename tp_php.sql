-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 26 mai 2020 à 21:02
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `numChambre` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `nbLits` int(11) NOT NULL,
  `nbPers` int(11) NOT NULL,
  `confort` varchar(300) NOT NULL,
  `image` varchar(50) NOT NULL,
  `description` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`numChambre`, `prix`, `nbLits`, `nbPers`, `confort`, `image`, `description`) VALUES
(1, 60, 1, 2, 'Navette a&eacute;roport,\r\nParking gratuit,\r\nAnimaux domestiques admis,\r\nChambres familiales,\r\nChambres non-fumeurs,\r\nBar', 'Chambre1.jpg', 'Tour Faidherbe 4 R&eacute;sidence des &icirc;les.\r\n\r\nOffrant une vue sur la ville, le Tour Faidherbe 4 R&eacute;sidence des &icirc;les vous accueille &agrave; Pointe-&agrave;-Pitre. Il propose un bar, une terrasse et un salon commun.\r\n\r\nDonnant sur la mer, les logements comprennent un coin salon, un lave-linge ainsi qu&rsquo;une salle de bains commune pourvue d&rsquo;un s&egrave;che-cheveux. Leur kitchenette &eacute;quip&eacute;e comporte un micro-ondes, un four, un r&eacute;frig&eacute;rateur, une bouilloire et une machine &agrave; caf&eacute;.\r\n\r\nLe Gosier se trouve &agrave; 8 km. Vous rejoindrez Sainte-Anne &agrave; 20 km. L&rsquo;a&eacute;roport de Pointe-&agrave;-Pitre Le Raizet, le plus proche, est accessible &agrave; 3,8 km. Un service de navette a&eacute;roport pourra &ecirc;tre organis&eacute; moyennant des frais suppl&eacute;mentaires.\r\n\r\nNous parlons votre langue !'),
(2, 73, 1, 2, 'Connexion Wi-Fi gratuite, Navette a&eacute;roport, Parking gratuit, Chambres non-fumeurs, Petit-d&eacute;jeuner exceptionnel', 'Chambre2.jpg', 'Les volets bleus A&eacute;roport - Port - CHU - Fac.\r\n\r\nSitu&eacute; &agrave; Pointe-&agrave;-Pitre, l&rsquo;&eacute;tablissement Les volets bleus A&eacute;roport - Port - CHU - Fac poss&egrave;de un salon commun et un jardin. Saint-Fran&ccedil;ois se trouve &agrave; 35 km. Vous profiterez de la climatisation, d&rsquo;une connexion Wi-Fi gratuite et d\\\'un espace de stationnement priv&eacute; sur place.\r\n\r\nDot&eacute; d\\\'une terrasse avec vue sur le jardin, l&rsquo;&eacute;tablissement comprend &eacute;galement la t&eacute;l&eacute;vision par satellite, une cuisine bien &eacute;quip&eacute;e avec un lave-vaisselle, un micro-ondes et un r&eacute;frig&eacute;rateur, ainsi qu\\\'une salle de bains pourvue d&rsquo;une douche et d&rsquo;un s&egrave;che-cheveux.\r\n\r\nLors de ce s&eacute;jour chez l\\\'habitant, vous pourrez prendre un petit-d&eacute;jeuner continental.\r\n\r\nL&rsquo;&eacute;tablissement Les volets bleus A&eacute;roport se trouve &agrave; 7 km du Gosier et &agrave; 20 km de Sainte-Anne. L\\\'a&eacute;roport de Pointe-&agrave;-Pitre &ndash; Le Raizet est le plus proche, &agrave; 4,3 km de l&rsquo;&eacute;tablissement qui propose un service de navette a&eacute;roport payant.\r\n\r\nLes couples appr&eacute;cient particuli&egrave;rement l\\\'emplacement de cet &eacute;tablissement. Ils lui donnent la note de 8,2 pour un s&eacute;jour &agrave; deux.\r\n\r\nNous parlons votre langue !'),
(3, 729, 4, 9, 'Maison enti&egrave;re,\r\nOccupation &times; 12,\r\nSuperficie 140 m&sup2;,\r\nCuisine,\r\nInstallations pour barbecue', 'Chambre3.jpg', 'Holiday home Chemin Pineau Richard.\r\n\r\nSitu&eacute;e &agrave; Bas Vent, la maison de vacances Holiday home Chemin Pineau Richard dispose d\\\'un barbecue. Vous s&eacute;journerez &agrave; 36 km de Pointe-&agrave;-Pitre et b&eacute;n&eacute;ficierez d\\\'un parking priv&eacute; gratuit.\r\n\r\nCette maison de vacances comprend 5 chambres, une t&eacute;l&eacute;vision par satellite ainsi qu\\\'une cuisine enti&egrave;rement &eacute;quip&eacute;e avec un micro-ondes, un r&eacute;frig&eacute;rateur, un lave-linge, un four et des plaques de cuisson.\r\n\r\nVous s&eacute;journerez &agrave; 42 km du Gosier et &agrave; 6 km de Deshaies. L\\\'a&eacute;roport de Pointe-&agrave;-Pitre Le Raizet, le plus proche, est implant&eacute; &agrave; 36 km.\r\n\r\nNous parlons votre langue !'),
(4, 252, 4, 6, 'Maisons,\r\nCuisine,\r\nVue sur la mer,\r\nJardin,\r\nPiscine ext&eacute;rieure,\r\n1 piscine', 'Chambre4.jpg', 'EVASION CARA&Iuml;BES.\r\n\r\nSitu&eacute; &agrave; Bel-Air Desrozi&egrave;res, l\\\'&Eacute;vasion Cara&iuml;be offre une vue sur la mer et poss&egrave;de une piscine ext&eacute;rieure. L\\\'&eacute;tablissement dispose &eacute;galement d\\\'une terrasse, d\\\'un barbecue et d\\\'une connexion Wi-Fi gratuite.\r\n\r\nToutes les villas sont dot&eacute;es de la climatisation, de 3 chambres &agrave; coucher et de 2 salles de bains. Leur cuisine est &eacute;quip&eacute;e d\\\'un micro-ondes, d\\\'un lave-vaisselle, d\\\'un grille-pain et d\\\'une cafeti&egrave;re. Chaque villa comprend aussi un lave-linge, un salon, une t&eacute;l&eacute;vision &agrave; &eacute;cran plat et du linge de lit.\r\n\r\nVous pourrez vous d&eacute;tendre dans le jardin et profiter de la vue sur les montagnes et sur la mer.\r\n\r\nL\\\'&Eacute;vasion Cara&iuml;be se trouve &agrave; 23 km du Gosier et &agrave; 36 km de Sainte-Anne. L\\\'a&eacute;roport de Pointe-&agrave;-Pitre Le Raizet est &agrave; 16 km.\r\n\r\nNous parlons votre langue !'),
(5, 127, 1, 2, 'Maisons,\r\nJardin,\r\nPiscine ext&eacute;rieure,\r\nInstallations pour barbecue,\r\nConnexion Wi-Fi gratuite,\r\n1 piscine,\r\nFront de mer', 'Chambre5.jpg', 'Repaire Jade &amp; Jack.\r\n\r\nLe Repaire Jade &amp; Jack est situ&eacute; &agrave; Bas Vent, dans la r&eacute;gion de Basse-Terre, &agrave; proximit&eacute; des plages de l\\\'Anse du Grand Ba Vent et de l\\\'Anse du Petit Bas Vent. Cet &eacute;tablissement met gratuitement &agrave; votre disposition une connexion Wi-Fi et un parking priv&eacute;. Vous aurez acc&egrave;s &agrave; un centre de spa.\r\n\r\nLe Repaire Jade &amp; Jack sert chaque matin un petit-d&eacute;jeuner continental.\r\n\r\nVous disposerez d&rsquo;un jacuzzi sur place.\r\n\r\nVous pourrez profiter de la piscine ext&eacute;rieure, utiliser le barbecue et vous d&eacute;tendre dans le jardin. Vous aurez aussi l&rsquo;occasion de pratiquer la p&ecirc;che et la randonn&eacute;e dans les environs.\r\n\r\nVous s&eacute;journerez &agrave; moins de 1 km de la plage de la Perle. Enfin, l\\\'a&eacute;roport de Pointe-&agrave;-Pitre Le Raizet, le plus proche, se trouve &agrave; 35 km du Repaire Jade &amp; Jack.\r\n\r\nLes couples appr&eacute;cient particuli&egrave;rement l\\\'emplacement de cet &eacute;tablissement. Ils lui donnent la note de 8,9 pour un s&eacute;jour &agrave; deux.\r\n\r\nNous parlons votre langue !');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `numClient` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `adresse` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`numClient`, `nom`, `prenom`, `tel`, `adresse`) VALUES
(1, 'GRAVE', 'Richard', '0624088481', '6 Rue Alexandre Pottier, 93130, Noisy Le Sec'),
(2, 'OTAKET', 'Florian', '0123456789', '32 Avenue Liberte, 27000, Super Bien Vue l Artiste'),
(3, 'EUPHRAIM', 'Phrakata', '0123456789', 'Ebhuufdj&egrave;dz Dafdsa, 96452, Super Bien Vue'),
(4, 'OKU', 'Simon', '9876543210', '6 Rue Alexandre Pottier, 93100, Montreuil'),
(44, 'VIALATOU', 'Benji', '0123456789', '123 Babacool, 77777, Bobland');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `numClient` int(11) NOT NULL,
  `numChambre` int(11) NOT NULL,
  `dateArrivee` date NOT NULL,
  `dateDepart` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`numClient`, `numChambre`, `dateArrivee`, `dateDepart`) VALUES
(44, 4, '2020-05-09', '2020-05-10');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_util` int(11) NOT NULL,
  `login` varchar(15) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_util`, `login`, `pass`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`numChambre`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`numClient`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`numClient`,`numChambre`),
  ADD KEY `numChambre` (`numChambre`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_util`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `numClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_util` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`numClient`) REFERENCES `client` (`numClient`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`numChambre`) REFERENCES `chambre` (`numChambre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
