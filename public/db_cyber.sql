-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : dim. 17 août 2025 à 08:08
-- Version du serveur : 8.0.30
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_cyber`
--

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int NOT NULL,
  `montant` int NOT NULL,
  `type_service` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `commentaire` text COLLATE utf8mb4_general_ci,
  `nom_vendeur` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nom_point_vente` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date_heure_paiement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `montant`, `type_service`, `commentaire`, `nom_vendeur`, `nom_point_vente`, `date_heure_paiement`) VALUES
(1, 1500, 'Poste', 'Paiement mensuel', 'Rohan', 'Mini-croc', '2025-08-09 09:30:00'),
(2, 2000, 'Impression/Photocopie', '100 pages A4', 'Rohan', 'Mini-croc', '2025-08-09 10:00:00'),
(3, 500, 'Impression/Photocopie', '20 copies couleur', 'Rohan', 'Mini-croc', '2025-08-09 10:15:00'),
(4, 800, 'Autre', 'Crédit téléphonique', 'Rohan', 'Mini-croc', '2025-08-09 10:30:00'),
(5, 1200, 'Poste', 'Forfait 1 semaine', 'Jerry', 'Mini-croc', '2025-08-09 11:00:00'),
(6, 2500, 'Autre', 'Clavier + Souris', 'Rohan', 'Mini-croc', '2025-08-09 11:15:00'),
(7, 300, 'Impression/Photocopie', '10 copies NB', 'Jerry', 'Mini-croc', '2025-08-09 11:30:00'),
(8, 4000, 'Wifi', 'Forfait illimité', 'Rohan', 'Mini-croc', '2025-08-09 12:00:00'),
(9, 700, 'Impression/Photocopie', '50 pages NB', 'Rohan', 'Mini-croc', '2025-08-09 12:15:00'),
(10, 600, 'Impression/Photocopie', '15 copies couleur', 'Carenne', 'Tok', '2025-08-09 12:30:00'),
(11, 500, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 15:56:50'),
(12, 500, 'Film', 'f', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 15:57:07'),
(13, 300, 'Wifi', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:01:04'),
(14, 300500, 'Wifi', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:05:23'),
(15, 300, 'Wifi', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:09:41'),
(16, 300, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:10:54'),
(17, 400, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:11:15'),
(18, 400, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:11:26'),
(19, 300, 'Film', 'dfdfdfdd', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:12:25'),
(20, 300, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:14:38'),
(21, 400400, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:17:34'),
(22, 300, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:17:46'),
(23, 300, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:17:54'),
(24, 400, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:19:08'),
(25, 666, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:19:18'),
(26, 400, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:26:14'),
(27, 600, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:26:34'),
(28, 1800, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:27:50'),
(29, 1800, 'Wifi', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:28:41'),
(30, 1800, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:39:57'),
(31, 98, 'Wifi', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:40:31'),
(32, 300, 'Film', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 16:41:28'),
(33, 100, 'Impression/Photocopie', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 17:00:03'),
(34, 700, 'Autre', 'normal', 'jerry@cybernet.com', 'Point de vente 1', '2025-08-09 17:02:57'),
(35, 400, 'Autre', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-09 18:54:32'),
(36, 300, 'Poste', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-14 12:58:42'),
(37, 500, 'Film', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-16 20:23:03');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','vendeur') NOT NULL,
  `point_of_sale` tinyint NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `point_of_sale`, `created_at`) VALUES
(1, 'carenne@cybernet.com', '$2y$10$ltNRLTO.J0nGkHDS5Be8Ie.v5IOHc.95C4EnUqAc4tz.tLVE6fJm2', 'admin', 1, '2025-08-08 17:15:41'),
(2, 'jerry@cybernet.com', '$2y$10$dLWkWkwkqyQCNqAVCQLoA.uJyHAzK7aq6RSIBuL65pcXwVR9zg8iG', 'vendeur', 1, '2025-08-08 17:15:42'),
(3, 'rohan@cybernet.com', '$2y$10$D/iTE3ervtCmzvDkmd5c6.9XXknLxd2u9Nbmpbe3ISWR18/ZGADOO', 'vendeur', 2, '2025-08-08 17:15:42');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
