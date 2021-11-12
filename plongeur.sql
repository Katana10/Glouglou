-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 18 jan. 2021 à 17:17
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `plongeur`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201211164949', '2020-12-11 18:06:53', 147),
('DoctrineMigrations\\Version20201211171650', '2020-12-11 18:16:58', 251),
('DoctrineMigrations\\Version20201228140321', '2020-12-28 15:04:04', 154),
('DoctrineMigrations\\Version20201229133826', '2020-12-29 14:40:44', 93);

-- --------------------------------------------------------

--
-- Structure de la table `profondeur`
--

CREATE TABLE `profondeur` (
  `id` int(11) NOT NULL,
  `profondeur` int(11) NOT NULL,
  `table_associee_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profondeur`
--

INSERT INTO `profondeur` (`id`, `profondeur`, `table_associee_id`) VALUES
(1, 9, 1),
(2, 12, 1),
(3, 15, 1),
(4, 18, 1),
(5, 21, 1),
(6, 24, 1),
(7, 27, 1),
(8, 30, 1),
(9, 33, 1),
(10, 36, 1),
(11, 39, 1),
(12, 42, 1),
(13, 45, 1),
(14, 48, 1),
(15, 51, 1),
(16, 54, 1),
(17, 57, 1),
(18, 61, 1),
(19, 63, 1),
(20, 6, 2),
(21, 8, 2),
(22, 10, 2),
(23, 12, 2),
(24, 15, 2),
(25, 18, 2),
(26, 20, 2),
(27, 22, 2),
(28, 25, 2),
(29, 28, 2),
(30, 30, 2),
(31, 32, 2),
(32, 35, 2),
(33, 38, 2),
(34, 40, 2),
(35, 42, 2),
(36, 45, 2),
(37, 48, 2),
(38, 50, 2),
(39, 52, 2),
(40, 55, 2),
(41, 58, 2),
(42, 60, 2),
(43, 62, 2),
(44, 65, 2);

-- --------------------------------------------------------

--
-- Structure de la table `table_plongee`
--

CREATE TABLE `table_plongee` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `table_plongee`
--

INSERT INTO `table_plongee` (`id`, `nom`) VALUES
(1, 'Buhlman'),
(2, 'MN90');

-- --------------------------------------------------------

--
-- Structure de la table `temps`
--

CREATE TABLE `temps` (
  `id` int(11) NOT NULL,
  `temps` int(11) NOT NULL,
  `palier15` int(11) DEFAULT NULL,
  `palier12` int(11) DEFAULT NULL,
  `palier9` int(11) DEFAULT NULL,
  `palier6` int(11) DEFAULT NULL,
  `palier3` int(11) DEFAULT NULL,
  `est_a_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `temps`
--

INSERT INTO `temps` (`id`, `temps`, `palier15`, `palier12`, `palier9`, `palier6`, `palier3`, `est_a_id`) VALUES
(1, 120, NULL, NULL, NULL, NULL, NULL, 1),
(2, 90, NULL, NULL, NULL, NULL, NULL, 2),
(3, 90, NULL, NULL, NULL, NULL, NULL, 3),
(4, 60, NULL, NULL, NULL, NULL, NULL, 4),
(5, 70, NULL, NULL, NULL, NULL, 4, 4),
(6, 80, NULL, NULL, NULL, NULL, 8, 4),
(7, 90, NULL, NULL, NULL, NULL, 15, 4),
(8, 30, NULL, NULL, NULL, NULL, NULL, 5),
(9, 40, NULL, NULL, NULL, NULL, 1, 5),
(10, 50, NULL, NULL, NULL, NULL, 3, 5),
(11, 55, NULL, NULL, NULL, NULL, 6, 5),
(12, 60, NULL, NULL, NULL, NULL, 9, 5),
(13, 65, NULL, NULL, NULL, NULL, 12, 5),
(14, 70, NULL, NULL, NULL, NULL, 16, 5),
(15, 75, NULL, NULL, NULL, NULL, 20, 5),
(16, 10, NULL, NULL, NULL, NULL, NULL, 6),
(17, 20, NULL, NULL, NULL, NULL, NULL, 6),
(18, 30, NULL, NULL, NULL, NULL, 1, 6),
(19, 40, NULL, NULL, NULL, NULL, 4, 6),
(20, 45, NULL, NULL, NULL, NULL, 7, 6),
(21, 50, NULL, NULL, NULL, NULL, 11, 6),
(22, 55, NULL, NULL, NULL, NULL, 15, 6),
(23, 60, NULL, NULL, NULL, 1, 19, 6),
(24, 65, NULL, NULL, NULL, 2, 24, 6),
(25, 70, NULL, NULL, NULL, 4, 26, 6),
(26, 75, NULL, NULL, NULL, 6, 29, 6),
(27, 10, NULL, NULL, NULL, NULL, NULL, 7),
(28, 20, NULL, NULL, NULL, NULL, NULL, 7),
(29, 25, NULL, NULL, NULL, NULL, 2, 7),
(30, 30, NULL, NULL, NULL, NULL, 3, 7),
(31, 35, NULL, NULL, NULL, NULL, 5, 7),
(32, 40, NULL, NULL, NULL, 1, 9, 7),
(33, 45, NULL, NULL, NULL, 1, 14, 7),
(34, 50, NULL, NULL, NULL, 3, 17, 7),
(35, 55, NULL, NULL, NULL, 4, 23, 7),
(36, 60, NULL, NULL, NULL, 7, 26, 7),
(37, 15, NULL, NULL, NULL, NULL, NULL, 8),
(38, 60, NULL, NULL, 2, 13, 30, 8),
(39, 10, NULL, NULL, NULL, NULL, NULL, 9),
(40, 50, NULL, NULL, 3, 12, 26, 9),
(41, 5, NULL, NULL, NULL, NULL, NULL, 10),
(42, 45, NULL, NULL, 5, 12, 29, 10),
(43, 5, NULL, NULL, NULL, NULL, NULL, 11),
(44, 40, NULL, 2, 5, 12, 28, 11),
(45, 5, NULL, NULL, NULL, NULL, NULL, 12),
(46, 10, NULL, NULL, NULL, NULL, 1, 12),
(47, 15, NULL, NULL, NULL, 1, 5, 12),
(48, 20, NULL, NULL, 1, 4, 6, 12),
(49, 25, NULL, NULL, 3, 5, 13, 12),
(50, 30, NULL, 1, 4, 7, 20, 12),
(51, 35, NULL, 4, 4, 11, 27, 12),
(52, 3, NULL, NULL, NULL, NULL, NULL, 13),
(53, 30, NULL, 3, 4, 9, 25, 13),
(54, 3, NULL, NULL, NULL, NULL, NULL, 14),
(55, 27, NULL, 4, 4, 8, 24, 14),
(56, 3, NULL, NULL, NULL, NULL, NULL, 15),
(57, 21, NULL, 3, 3, 6, 16, 15),
(58, 6, NULL, NULL, NULL, NULL, 1, 16),
(59, 21, 1, 3, 4, 7, 19, 16),
(60, 30, NULL, NULL, NULL, NULL, 1, 17),
(61, 21, 2, 3, 4, 9, 23, 17),
(62, 30, NULL, NULL, NULL, NULL, 1, 18),
(63, 21, 3, 4, 5, 10, 26, 18),
(64, 30, NULL, NULL, NULL, NULL, 1, 19),
(65, 18, 3, 3, 4, 8, 23, 19),
(66, 135, NULL, NULL, NULL, NULL, NULL, 20),
(67, 135, NULL, NULL, NULL, NULL, NULL, 21),
(68, 135, NULL, NULL, NULL, NULL, NULL, 22),
(69, 120, NULL, NULL, NULL, NULL, NULL, 23),
(70, 140, NULL, NULL, NULL, NULL, 2, 23),
(71, 70, NULL, NULL, NULL, NULL, NULL, 24),
(72, 80, NULL, NULL, NULL, NULL, 2, 24),
(73, 85, NULL, NULL, NULL, NULL, 4, 24),
(74, 90, NULL, NULL, NULL, NULL, 6, 24),
(75, 40, NULL, NULL, NULL, NULL, NULL, 25),
(76, 55, NULL, NULL, NULL, NULL, 1, 25),
(77, 60, NULL, NULL, NULL, NULL, 5, 25),
(78, 65, NULL, NULL, NULL, NULL, 8, 25),
(79, 70, NULL, NULL, NULL, NULL, 11, 25),
(80, 75, NULL, NULL, NULL, NULL, 14, 25),
(81, 5, NULL, NULL, NULL, NULL, NULL, 35),
(82, 10, NULL, NULL, NULL, NULL, 2, 35),
(83, 15, NULL, NULL, NULL, NULL, 5, 35),
(84, 20, NULL, NULL, NULL, 1, 12, 35),
(85, 25, NULL, NULL, NULL, 3, 22, 35),
(86, 30, NULL, NULL, NULL, 6, 31, 35),
(87, 35, NULL, NULL, NULL, 11, 37, 35);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `profondeur`
--
ALTER TABLE `profondeur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E3804DEA459793F1` (`table_associee_id`);

--
-- Index pour la table `table_plongee`
--
ALTER TABLE `table_plongee`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `temps`
--
ALTER TABLE `temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_60B4B72010C32089` (`est_a_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `profondeur`
--
ALTER TABLE `profondeur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `table_plongee`
--
ALTER TABLE `table_plongee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `temps`
--
ALTER TABLE `temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `profondeur`
--
ALTER TABLE `profondeur`
  ADD CONSTRAINT `FK_E3804DEA459793F1` FOREIGN KEY (`table_associee_id`) REFERENCES `table_plongee` (`id`);

--
-- Contraintes pour la table `temps`
--
ALTER TABLE `temps`
  ADD CONSTRAINT `FK_60B4B72010C32089` FOREIGN KEY (`est_a_id`) REFERENCES `profondeur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
