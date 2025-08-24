-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 24 août 2025 à 13:15
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
-- Structure de la table `bonus`
--

CREATE TABLE `bonus` (
  `id` int NOT NULL,
  `id_paiement` int NOT NULL,
  `montant_bonus` int NOT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nom_point_vente` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bonus`
--

INSERT INTO `bonus` (`id`, `id_paiement`, `montant_bonus`, `date_enregistrement`, `nom_point_vente`) VALUES
(12, 175, 600, '2025-08-24 15:15:17', 'Mini-croc'),
(13, 176, 0, '2025-08-24 15:25:32', 'Mini-croc'),
(14, 177, 600, '2025-08-24 15:57:06', 'Mini-croc');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int NOT NULL,
  `montant` int NOT NULL,
  `type_service` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `commentaire` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nom_vendeur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nom_point_vente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_heure_paiement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('encours','valider') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'encours',
  `versement_pure` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `montant`, `type_service`, `commentaire`, `nom_vendeur`, `nom_point_vente`, `date_heure_paiement`, `statut`, `versement_pure`) VALUES
(175, 1800, 'Film', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 14:13:52', 'encours', 1200),
(176, 1000, 'Poste', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 15:25:32', 'encours', 1000),
(177, 1800, 'Saisie', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 15:56:35', 'encours', 1200);

--
-- Déclencheurs `paiement`
--
DELIMITER $$
CREATE TRIGGER `after_delete_paiement` AFTER DELETE ON `paiement` FOR EACH ROW BEGIN
    -- suppression du bonus lié à ce paiement
    DELETE FROM bonus WHERE id_paiement = OLD.id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_paiement` AFTER INSERT ON `paiement` FOR EACH ROW BEGIN
    DECLARE montant_bonus INT;

    -- calcul du bonus
    SET montant_bonus = NEW.montant - NEW.versement_pure;

    -- insertion dans la table bonus
    INSERT INTO bonus (id_paiement, montant_bonus, nom_point_vente)
    VALUES (NEW.id, montant_bonus, NEW.nom_point_vente);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_paiement` AFTER UPDATE ON `paiement` FOR EACH ROW BEGIN
    DECLARE montant_bonus INT;

    -- recalcul du bonus
    SET montant_bonus = NEW.montant - NEW.versement_pure;

    -- mise à jour du bonus lié à ce paiement
    UPDATE bonus
    SET montant_bonus = montant_bonus,
        date_enregistrement = NOW(),
        nom_point_vente = NEW.nom_point_vente
    WHERE id_paiement = NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `paiement_modification`
--

CREATE TABLE `paiement_modification` (
  `id` int NOT NULL,
  `paiement_id` int NOT NULL,
  `ancien_montant` int DEFAULT NULL,
  `ancien_type_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ancien_commentaire` text COLLATE utf8mb4_unicode_ci,
  `nouveau_montant` int DEFAULT NULL,
  `nouveau_type_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nouveau_commentaire` text COLLATE utf8mb4_unicode_ci,
  `nom_vendeur` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nom_point_vente` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `justification` text COLLATE utf8mb4_unicode_ci,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `versement_pure` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement_modification`
--

INSERT INTO `paiement_modification` (`id`, `paiement_id`, `ancien_montant`, `ancien_type_service`, `ancien_commentaire`, `nouveau_montant`, `nouveau_type_service`, `nouveau_commentaire`, `nom_vendeur`, `nom_point_vente`, `justification`, `date_modification`, `versement_pure`) VALUES
(27, 173, 300, 'Film', 'normal', 300, 'Poste', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'p', '2025-08-24 10:23:57', 300),
(28, 174, 200, 'Plastification', 'normal', 2000, 'Plastification', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'm', '2025-08-24 10:24:55', 2000),
(29, 174, 2000, 'Plastification', 'normal', 2000, 'Installation systeme', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'o', '2025-08-24 10:25:28', 2000),
(30, 174, 2000, 'Installation systeme', 'normal', 2000, 'Film', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'f', '2025-08-24 10:26:10', 1333),
(31, 174, 2000, 'Film', 'normal', 4000, 'Film', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'f', '2025-08-24 10:26:49', 2667),
(32, 174, 4000, 'Film', 'normal', 4000, 'Saisie', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:27:14', 2667),
(33, 174, 4000, 'Saisie', 'normal', 3000, 'Saisie', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:28:17', 2000),
(34, 174, 3000, 'Saisie', 'normal', 3000, 'Application', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:28:56', 1500),
(35, 174, 3000, 'Application', 'normal', 3000, 'Autre', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'e', '2025-08-24 10:29:31', 2000),
(36, 174, 3000, 'Autre', 'normal', 3000, 'Mise a jour', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'd', '2025-08-24 10:29:55', 2000),
(37, 174, 3000, 'Mise a jour', 'normal', 3000, 'Wifi/Cable', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:30:48', 3000),
(38, 174, 3000, 'Wifi/Cable', 'normal', 3000, 'Mise a jour', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:31:17', 2000),
(39, 174, 3000, 'Mise a jour', 'normal', 3000, 'Impression/Photocopie/scan', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'q', '2025-08-24 10:31:46', 3000),
(40, 174, 3000, 'Impression/Photocopie/scan', 'normal', 3000, 'Installation systeme', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 10:32:10', 3000),
(41, 173, 300, 'Poste', 'normal', 15000, 'Installation systeme', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'gf', '2025-08-24 11:11:12', 10000),
(42, 175, 1800, 'Poste', 'normal', 1800, 'Film', 'normal', 'jerry@cybernet.com', 'Mini-croc', 'f', '2025-08-24 12:15:17', 1200),
(43, 177, 1800, 'Film, Saisie', 'normal', 1800, 'Saisie', 'normal', 'jerry@cybernet.com', 'Mini-croc', 's', '2025-08-24 12:57:06', 1200);

-- --------------------------------------------------------

--
-- Structure de la table `paiement_suppression`
--

CREATE TABLE `paiement_suppression` (
  `id` int NOT NULL,
  `paiement_id` int NOT NULL,
  `montant` int NOT NULL,
  `type_service` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentaire` text COLLATE utf8mb4_unicode_ci,
  `nom_vendeur` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_point_vente` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_heure_paiement` datetime NOT NULL,
  `cause` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_suppression` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `versement_pure` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `paiement_suppression`
--

INSERT INTO `paiement_suppression` (`id`, `paiement_id`, `montant`, `type_service`, `commentaire`, `nom_vendeur`, `nom_point_vente`, `date_heure_paiement`, `cause`, `date_suppression`, `versement_pure`) VALUES
(35, 172, 400, 'Impression-Photocopie-scan', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 13:02:43', 'e', '2025-08-24 13:33:47', 0),
(36, 174, 3000, 'Installation systeme', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 13:03:03', 'hh', '2025-08-24 13:40:36', 3000),
(37, 173, 15000, 'Installation systeme', 'normal', 'jerry@cybernet.com', 'Mini-croc', '2025-08-24 13:02:52', 'g', '2025-08-24 14:11:47', 10000);

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

-- --------------------------------------------------------

--
-- Structure de la table `wifi`
--

CREATE TABLE `wifi` (
  `id` int NOT NULL,
  `heure_demarrage` time NOT NULL,
  `heure_fin` time NOT NULL,
  `temps` int NOT NULL,
  `prix` int NOT NULL,
  `montant_limite` int DEFAULT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lieu_travail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_vendeur` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `wifi`
--

INSERT INTO `wifi` (`id`, `heure_demarrage`, `heure_fin`, `temps`, `prix`, `montant_limite`, `commentaire`, `date_enregistrement`, `lieu_travail`, `nom_vendeur`) VALUES
(30, '11:36:32', '11:36:32', 1136, 7000, 500, 'bnd', '2025-08-23 11:36:32', 'Tok', 'jerry@cybernet.com'),
(32, '14:05:31', '14:05:31', 765, 7000, 2000, 'sipa ak', '2025-08-23 14:05:31', 'Tok', 'jerry@cybernet.com'),
(33, '14:07:48', '14:07:48', 763, 7000, 0, 'zok ak', '2025-08-23 14:07:48', 'Mini-croc', 'jerry@cybernet.com'),
(34, '14:07:58', '14:07:58', 763, 7000, 500, 'zandr', '2025-08-23 14:07:58', 'Mini-croc', 'jerry@cybernet.com'),
(35, '12:20:34', '15:58:27', 218, 5000, 0, 'zok ak', '2025-08-24 12:20:34', 'Mini-croc', 'jerry@cybernet.com');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bonus`
--
ALTER TABLE `bonus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_paiement` (`id_paiement`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement_modification`
--
ALTER TABLE `paiement_modification`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement_suppression`
--
ALTER TABLE `paiement_suppression`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `wifi`
--
ALTER TABLE `wifi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bonus`
--
ALTER TABLE `bonus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT pour la table `paiement_modification`
--
ALTER TABLE `paiement_modification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `paiement_suppression`
--
ALTER TABLE `paiement_suppression`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `wifi`
--
ALTER TABLE `wifi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bonus`
--
ALTER TABLE `bonus`
  ADD CONSTRAINT `bonus_ibfk_1` FOREIGN KEY (`id_paiement`) REFERENCES `paiement` (`id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Évènements
--
CREATE DEFINER=`root`@`localhost` EVENT `increment_wifi` ON SCHEDULE EVERY 1 MINUTE STARTS '2025-08-23 11:51:02' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE wifi
    SET 
        temps = temps + 1,
        prix = CASE
            -- Temps ≤ 8
            WHEN temps + 1 <= 8 THEN 200
            -- Temps entre 9 et 12
            WHEN temps + 1 BETWEEN 9 AND 12 THEN 300
            -- Temps ≤ 240 mais prix calculé >= 5000
            WHEN temps + 1 <= 240 AND (temps + 1) * 25 >= 5000 THEN 5000
            -- Temps > 240
            WHEN temps + 1 > 240 THEN LEAST((temps + 1 - 240) * 15 + 5000, 7000)
            -- Sinon, arrondi au chiffre des centaines
            ELSE
                CASE
                    WHEN ((temps + 1) * 25) % 100 = 0 THEN (temps + 1) * 25
                    ELSE (FLOOR((temps + 1) * 25 / 100) + 1) * 100
                END
        END
    WHERE heure_fin = heure_demarrage;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
