-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 14 nov. 2025 à 23:11
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
-- Base de données : `bibliotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `lecteurs`
--

CREATE TABLE `lecteurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lecteurs`
--

INSERT INTO `lecteurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`) VALUES
(1, 'mathieu', 'Olmedo', 'mathieuolmedo6@gmail.com', ''),
(2, 'POUNA', 'Mathias', 'mathieuolmedo6@gmail.com', '$2y$10$cb9AdktE3B0hJ8NtaZx0IeVJBXruZbV.RZxxlIZJrWCdrEGrda6hC'),
(3, 'POUNA', 'Mathias', 'olmedomathieu922@gmail.com', '$2y$10$bE2inTaI9cnKqMMfdo27LOh19ltpH8rskDxeYIUg6898oEGfZ1zMu');

-- --------------------------------------------------------

--
-- Structure de la table `liste_lecture`
--

CREATE TABLE `liste_lecture` (
  `id` int(11) NOT NULL,
  `id_livre` int(11) NOT NULL,
  `id_lecteur` int(11) NOT NULL,
  `date_emprunt` datetime NOT NULL,
  `date_retour` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `liste_lecture`
--

INSERT INTO `liste_lecture` (`id`, `id_livre`, `id_lecteur`, `date_emprunt`, `date_retour`) VALUES
(1, 1, 2, '2025-11-14 20:43:48', '2025-11-14 20:44:39'),
(2, 3, 2, '2025-11-14 20:44:07', '2025-11-14 21:13:35'),
(3, 4, 2, '2025-11-14 20:44:13', '2025-11-14 21:13:36'),
(4, 6, 2, '2025-11-14 20:44:18', '2025-11-14 21:13:37'),
(5, 6, 3, '2025-11-14 20:46:43', '2025-11-14 20:47:35'),
(6, 10, 3, '2025-11-14 20:46:47', '2025-11-14 20:47:34'),
(7, 5, 3, '2025-11-14 20:46:53', NULL),
(8, 9, 2, '2025-11-14 22:04:11', NULL),
(9, 2, 2, '2025-11-14 22:04:27', NULL),
(10, 5, 2, '2025-11-14 22:04:36', NULL),
(11, 6, 2, '2025-11-14 22:04:42', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `livres`
--

CREATE TABLE `livres` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) DEFAULT NULL,
  `auteur` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `maison_edition` varchar(100) DEFAULT NULL,
  `nombre_exemplaire` int(11) DEFAULT NULL,
  `couverture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livres`
--

INSERT INTO `livres` (`id`, `titre`, `auteur`, `description`, `maison_edition`, `nombre_exemplaire`, `couverture`) VALUES
(1, 'Dune', 'Frank Herbert', 'Un classique de la science-fiction.', 'Pocket', 5, 'dune.jpg'),
(2, '1984', 'George Orwell', 'Un roman dystopique.', 'Folio', 12, '1984.jpg'),
(3, 'Le Petit Prince', 'Antoine de Saint-Exupéry', 'Un conte philosophique.', 'Gallimard', 20, 'petit_prince.jpg'),
(4, 'Fondation', 'Isaac Asimov', 'Le cycle fondateur de la science-fiction.', 'Gallimard', 8, 'fondation.jpg'),
(5, 'Orgueil et Préjugés', 'Jane Austen', 'Un classique de la littérature anglaise.', 'Penguin', 15, 'orgueil.jpg'),
(6, 'Le Nom de la rose', 'Umberto Eco', 'Un thriller médiéval philosophique.', 'Grasset', 6, 'nom_rose.jpg'),
(7, 'Sapiens', 'Yuval Noah Harari', 'Une brève histoire de l\'humanité.', 'Albin Michel', 18, 'sapiens.jpg'),
(8, 'L\'Étranger', 'Albert Camus', 'Roman sur l\'absurdité de l\'existence.', 'Gallimard', 9, 'etranger.jpg'),
(9, 'Vingt mille lieues sous les mers', 'Jules Verne', 'Voyage sous-marin à bord du Nautilus.', 'Hachette', 10, 'verne.jpg'),
(10, 'Harry Potter à l\'école des sorciers', 'J.K. Rowling', 'Le début de la saga magique.', 'Gallimard', 25, 'hp.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_active_loan` (`id_livre`,`id_lecteur`,`date_retour`),
  ADD KEY `id_lecteur` (`id_lecteur`);

--
-- Index pour la table `livres`
--
ALTER TABLE `livres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lecteurs`
--
ALTER TABLE `lecteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `livres`
--
ALTER TABLE `livres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `liste_lecture`
--
ALTER TABLE `liste_lecture`
  ADD CONSTRAINT `liste_lecture_ibfk_1` FOREIGN KEY (`id_livre`) REFERENCES `livres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liste_lecture_ibfk_2` FOREIGN KEY (`id_lecteur`) REFERENCES `lecteurs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
