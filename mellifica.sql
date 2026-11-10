-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 27 oct. 2026 à 14:24
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mellifica`
--

-- --------------------------------------------------------

--
-- Structure de la table `miel`
--

CREATE TABLE `miel` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `miel`
--

INSERT INTO `miel` (`id`, `type`, `photo`) VALUES
(1, 'Miel d’acacia', './img/miels/Acacia.png'),
(2, 'Miel de châtaignier', './img/miels/Chataignier.png'),
(3, 'Miel de colza', './img/miels/Colza.png'),
(4, 'Miel de lavande', './img/miels/Lavande.png'),
(5, 'Miel de romarin', './img/miels/Romarin.png'),
(6, 'Miel de toute fleurs', './img/miels/TouteFleurs.png'),
(7, 'Miel de tilleul', './img/miels/Tilleul.png');

-- --------------------------------------------------------

--
-- Structure de la table `photoaccueil`
--

CREATE TABLE `photoaccueil` (
  `id` decimal(10,0) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `alt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `photoaccueil`
--

INSERT INTO `photoaccueil` (`id`, `photo`, `alt`) VALUES
(0, './img/imgAccueil.jpg', 'Photo accueil');

-- --------------------------------------------------------

--
-- Structure de la table `produitderive`
--

CREATE TABLE `produitderive` (
  `id` int(11) NOT NULL,
  `produit` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produitderive`
--

INSERT INTO `produitderive` (`id`, `produit`, `photo`) VALUES
(1, 'Propolis', './img/produitsDerives/propolis.jpg'),
(2, 'Bougies', './img/produitsDerives/bougie.webp'),
(3, 'Gelée royale', './img/produitsDerives/gelee.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `texteaccueil`
--

CREATE TABLE `texteaccueil` (
  `id` decimal(10,0) NOT NULL,
  `texte` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `texteaccueil`
--

INSERT INTO `texteaccueil` (`id`, `texte`) VALUES
(0, 'Mes abeilles et moi faisons du miel ...');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(255) DEFAULT NULL,
  `motdepasse` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `motdepasse`) VALUES
('admin', '$2y$10$JMdXgFuzFB1XjKp83XsZo.//w9tLEZmKVMvJjhl0Q6eYDO.8I.G7a');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `miel`
--
ALTER TABLE `miel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photoaccueil`
--
ALTER TABLE `photoaccueil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produitderive`
--
ALTER TABLE `produitderive`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `texteaccueil`
--
ALTER TABLE `texteaccueil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `miel`
--
ALTER TABLE `miel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `produitderive`
--
ALTER TABLE `produitderive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
