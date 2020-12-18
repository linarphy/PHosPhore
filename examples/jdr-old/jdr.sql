-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 21 mai 2020 à 19:07
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
-- Base de données : `jdr`
--

-- --------------------------------------------------------

--
-- Structure de la table `configuration`
--

CREATE TABLE `configuration` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `configuration`
--

INSERT INTO `configuration` (`id`, `id_user`, `name`, `value`) VALUES
(1, 9, 'lang', 'FR');

-- --------------------------------------------------------

--
-- Structure de la table `consumable`
--

CREATE TABLE `consumable` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `consumable`
--

INSERT INTO `consumable` (`id`, `id_name`, `value`, `quality`) VALUES
(3, 263, 20, 1),
(4, 264, 40, 2),
(5, 265, 60, 3),
(6, 266, 80, 4),
(7, 267, 100, 5),
(8, 268, 120, 6),
(9, 269, 140, 7),
(10, 270, 20, 1),
(11, 271, 40, 2),
(12, 272, 60, 3),
(13, 273, 80, 4),
(14, 274, 100, 5),
(15, 275, 120, 6),
(16, 276, 140, 7),
(17, 277, 30, 1),
(18, 278, 60, 2),
(19, 279, 90, 3),
(20, 280, 120, 4),
(21, 281, 150, 5),
(22, 282, 180, 6),
(23, 283, 210, 7),
(24, 284, 65, 1),
(25, 285, 80, 2),
(26, 286, 95, 3),
(27, 287, 110, 4),
(28, 288, 125, 5),
(29, 289, 140, 6),
(30, 290, 155, 7),
(31, 291, 100, 5),
(105, 374, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `content`
--

CREATE TABLE `content` (
  `id_content` int(11) NOT NULL,
  `lang` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `content`
--

INSERT INTO `content` (`id_content`, `lang`, `text`, `date_creation`) VALUES
(1, 'FR', 'Bouclier en bois', '2020-05-09 22:56:29'),
(1, 'EN', 'Wooden shield', '2020-05-09 22:56:29'),
(2, 'FR', 'Caque en cuir', '2020-05-09 22:56:29'),
(2, 'EN', 'Leather helmet', '2020-05-09 22:56:29'),
(3, 'FR', 'Dague en bois', '2020-05-09 23:10:52'),
(3, 'EN', 'Wooden dagger', '2020-05-09 23:10:52'),
(4, 'FR', 'Épée en bois', '2020-05-09 23:10:53'),
(4, 'EN', 'Wooden sword', '2020-05-09 23:10:54'),
(5, 'FR', 'Annneau ancien', '2020-05-09 23:30:17'),
(5, 'EN', 'Ancient ring', '2020-05-09 23:30:17'),
(6, 'FR', 'Collier ancien', '2020-05-09 23:30:17'),
(6, 'EN', 'Ancient necklace', '2020-05-09 23:30:17'),
(9, 'FR', 'Plastron en cuir', '2020-05-10 02:49:57'),
(9, 'EN', 'Leather chestplate', '2020-05-10 02:49:57'),
(10, 'FR', 'Gants en cuir', '2020-05-10 02:49:58'),
(10, 'EN', 'Leather gloves', '2020-05-10 02:49:58'),
(11, 'FR', 'Pantalon en cuir', '2020-05-10 02:49:58'),
(11, 'EN', 'Leather leggins', '2020-05-10 02:49:58'),
(12, 'FR', 'Bottes en cuir', '2020-05-10 02:49:59'),
(12, 'EN', 'Leather boots', '2020-05-10 02:49:59'),
(13, 'FR', 'Bouclier en fer', '2020-05-10 02:49:59'),
(13, 'EN', 'Iron Shield', '2020-05-10 02:49:59'),
(14, 'FR', 'Casque en fer', '2020-05-10 02:49:59'),
(14, 'EN', 'Iron helmet', '2020-05-10 02:49:59'),
(15, 'FR', 'Plastron en fer', '2020-05-10 02:49:59'),
(15, 'EN', 'Iron chestplate', '2020-05-10 02:50:00'),
(16, 'FR', 'Gants en fer', '2020-05-10 02:50:00'),
(16, 'EN', 'Iron gloves', '2020-05-10 02:50:00'),
(17, 'FR', 'Pantalon en fer', '2020-05-10 02:50:00'),
(17, 'EN', 'Iron leggins', '2020-05-10 02:50:00'),
(18, 'FR', 'Bottes en fer', '2020-05-10 02:50:00'),
(18, 'EN', 'Iron boots', '2020-05-10 02:50:00'),
(19, 'FR', 'Bouclier en acier', '2020-05-10 02:50:00'),
(19, 'EN', 'Steel Shield', '2020-05-10 02:50:00'),
(20, 'FR', 'Casque en acier', '2020-05-10 02:50:01'),
(20, 'EN', 'Steel helmet', '2020-05-10 02:50:01'),
(21, 'FR', 'Plastron en acier', '2020-05-10 02:50:01'),
(21, 'EN', 'Steel chestplate', '2020-05-10 02:50:01'),
(22, 'FR', 'Gants en acier', '2020-05-10 02:50:01'),
(22, 'EN', 'Steel gloves', '2020-05-10 02:50:01'),
(23, 'FR', 'Pantalon en acier', '2020-05-10 02:50:01'),
(23, 'EN', 'Steel leggins', '2020-05-10 02:50:01'),
(24, 'FR', 'Bottes en acier', '2020-05-10 02:50:01'),
(24, 'EN', 'Steel boots', '2020-05-10 02:50:02'),
(25, 'FR', 'Bouclier en Gylo', '2020-05-10 02:50:02'),
(25, 'EN', 'Gylo Shield', '2020-05-10 02:50:02'),
(26, 'FR', 'Casque en Gylo', '2020-05-10 02:50:02'),
(26, 'EN', 'Gylo helmet', '2020-05-10 02:50:02'),
(27, 'FR', 'Plastron en Gylo', '2020-05-10 02:50:02'),
(27, 'EN', 'Gylo chestplate', '2020-05-10 02:50:02'),
(28, 'FR', 'Gants en Gylo', '2020-05-10 02:50:02'),
(28, 'EN', 'Gylo gloves', '2020-05-10 02:50:02'),
(29, 'FR', 'Pantalon en Gylo', '2020-05-10 02:50:02'),
(29, 'EN', 'Gylo leggins', '2020-05-10 02:50:02'),
(30, 'FR', 'Bottes en Gylo', '2020-05-10 02:50:03'),
(30, 'EN', 'Gylo boots', '2020-05-10 02:50:03'),
(31, 'FR', 'Bouclier en Ladum', '2020-05-10 02:50:03'),
(31, 'EN', 'Ladum Shield', '2020-05-10 02:50:03'),
(32, 'FR', 'Casque en Ladum', '2020-05-10 02:50:03'),
(32, 'EN', 'Ladum helmet', '2020-05-10 02:50:03'),
(33, 'FR', 'Plastron en Ladum', '2020-05-10 02:50:03'),
(33, 'EN', 'Ladum chestplate', '2020-05-10 02:50:04'),
(34, 'FR', 'Gants en Ladum', '2020-05-10 02:50:04'),
(34, 'EN', 'Ladum gloves', '2020-05-10 02:50:04'),
(35, 'FR', 'Pantalon en Ladum', '2020-05-10 02:50:05'),
(35, 'EN', 'Ladum leggins', '2020-05-10 02:50:05'),
(36, 'FR', 'Bottes en Ladum', '2020-05-10 02:50:05'),
(36, 'EN', 'Ladum boots', '2020-05-10 02:50:05'),
(37, 'FR', 'Bouclier en Hudalion', '2020-05-10 02:50:06'),
(37, 'EN', 'Hudalion Shield', '2020-05-10 02:50:06'),
(38, 'FR', 'Casque en Hudalion', '2020-05-10 02:50:06'),
(38, 'EN', 'Hudalion helmet', '2020-05-10 02:50:06'),
(39, 'FR', 'Plastron en Hudalion', '2020-05-10 02:50:07'),
(39, 'EN', 'Hudalion chestplate', '2020-05-10 02:50:07'),
(40, 'FR', 'Gants en Hudalion', '2020-05-10 02:50:07'),
(40, 'EN', 'Hudalion gloves', '2020-05-10 02:50:07'),
(41, 'FR', 'Pantalon en Hudalion', '2020-05-10 02:50:07'),
(41, 'EN', 'Hudalion leggins', '2020-05-10 02:50:07'),
(42, 'FR', 'Bottes en Hudalion', '2020-05-10 02:50:07'),
(42, 'EN', 'Hudalion boots', '2020-05-10 02:50:07'),
(43, 'FR', 'Bouclier en Kulop', '2020-05-10 02:50:07'),
(43, 'EN', 'Kulop Shield', '2020-05-10 02:50:07'),
(44, 'FR', 'Casque en Kulop', '2020-05-10 02:50:08'),
(44, 'EN', 'Kulop helmet', '2020-05-10 02:50:08'),
(45, 'FR', 'Plastron en Kulop', '2020-05-10 02:50:08'),
(45, 'EN', 'Kulop chestplate', '2020-05-10 02:50:08'),
(46, 'FR', 'Gants en Kulop', '2020-05-10 02:50:08'),
(46, 'EN', 'Kulop gloves', '2020-05-10 02:50:08'),
(47, 'FR', 'Pantalon en Kulop', '2020-05-10 02:50:08'),
(47, 'EN', 'Kulop leggins', '2020-05-10 02:50:08'),
(48, 'FR', 'Bottes en Kulop', '2020-05-10 02:50:08'),
(48, 'EN', 'Kulop boots', '2020-05-10 02:50:08'),
(49, 'FR', 'Bouclier en Vui', '2020-05-10 02:50:09'),
(49, 'EN', 'Vui Shield', '2020-05-10 02:50:09'),
(50, 'FR', 'Casque en Vui', '2020-05-10 02:50:09'),
(50, 'EN', 'Vui helmet', '2020-05-10 02:50:09'),
(51, 'FR', 'Plastron en Vui', '2020-05-10 02:50:09'),
(51, 'EN', 'Vui chestplate', '2020-05-10 02:50:09'),
(52, 'FR', 'Gants en Vui', '2020-05-10 02:50:09'),
(52, 'EN', 'Vui gloves', '2020-05-10 02:50:09'),
(53, 'FR', 'Pantalon en Vui', '2020-05-10 02:50:09'),
(53, 'EN', 'Vui leggins', '2020-05-10 02:50:09'),
(54, 'FR', 'Bottes en Vui', '2020-05-10 02:50:10'),
(54, 'EN', 'Vui boots', '2020-05-10 02:50:10'),
(55, 'FR', 'Bouclier en Nalan', '2020-05-10 02:50:10'),
(55, 'EN', 'Nalan Shield', '2020-05-10 02:50:10'),
(56, 'FR', 'Casque en Nalan', '2020-05-10 02:50:10'),
(56, 'EN', 'Nalan helmet', '2020-05-10 02:50:10'),
(57, 'FR', 'Plastron en Nalan', '2020-05-10 02:50:10'),
(57, 'EN', 'Nalan chestplate', '2020-05-10 02:50:10'),
(58, 'FR', 'Gants en Nalan', '2020-05-10 02:50:10'),
(58, 'EN', 'Nalan gloves', '2020-05-10 02:50:10'),
(59, 'FR', 'Pantalon en Nalan', '2020-05-10 02:50:11'),
(59, 'EN', 'Nalan leggins', '2020-05-10 02:50:11'),
(60, 'FR', 'Bottes en Nalan', '2020-05-10 02:50:11'),
(60, 'EN', 'Nalan boots', '2020-05-10 02:50:11'),
(61, 'FR', 'Marteau en bois', '2020-05-10 02:50:11'),
(61, 'EN', 'Wooden hammer', '2020-05-10 02:50:11'),
(62, 'FR', 'Hache en bois', '2020-05-10 02:50:11'),
(62, 'EN', 'Wooden axe', '2020-05-10 02:50:11'),
(63, 'FR', 'Arc d\'Entraînement', '2020-05-10 02:50:11'),
(63, 'EN', 'Training Bow', '2020-05-10 02:50:12'),
(64, 'FR', 'Petit arc d\'Entraînement', '2020-05-10 02:50:12'),
(64, 'EN', 'Small training Bow', '2020-05-10 02:50:12'),
(65, 'FR', 'Arbalète d\'Entraînement', '2020-05-10 02:50:13'),
(65, 'EN', 'Training Crossbow', '2020-05-10 02:50:13'),
(66, 'FR', 'Bâton de feu pour débutant', '2020-05-10 02:50:13'),
(66, 'EN', 'Beginner\'s fire staff', '2020-05-10 02:50:13'),
(67, 'FR', 'Bâton de glace pour débutant', '2020-05-10 02:50:13'),
(67, 'EN', 'Beginner\'s ice staff', '2020-05-10 02:50:13'),
(68, 'FR', 'Bâton de terre pour débutant', '2020-05-10 02:50:13'),
(68, 'EN', 'Beginner\'s earth staff', '2020-05-10 02:50:13'),
(69, 'FR', 'Bâton d\'eau pour débutant', '2020-05-10 02:50:13'),
(69, 'EN', 'Beginner\'s water staff', '2020-05-10 02:50:13'),
(70, 'FR', 'Bâton de magma pour débutant', '2020-05-10 02:50:13'),
(70, 'EN', 'Beginner\'s magma staff', '2020-05-10 02:50:14'),
(71, 'FR', 'Bâton d\'ombre pour débutant', '2020-05-10 02:50:14'),
(71, 'EN', 'Beginner\'s shadow staff', '2020-05-10 02:50:14'),
(72, 'FR', 'Bâton de lumière pour débutant', '2020-05-10 02:50:14'),
(72, 'EN', 'Beginner\'s light staff', '2020-05-10 02:50:14'),
(73, 'FR', 'Bâton de destruction pour débutant', '2020-05-10 02:50:14'),
(73, 'EN', 'Beginner\'s destruction staff', '2020-05-10 02:50:14'),
(74, 'FR', 'Bâton de régénération pour débutant', '2020-05-10 02:50:14'),
(74, 'EN', 'Beginner\'s regeneration staff', '2020-05-10 02:50:14'),
(75, 'FR', 'Dague en fer', '2020-05-10 02:50:15'),
(75, 'EN', 'Iron dagger', '2020-05-10 02:50:15'),
(76, 'FR', 'Épée en fer', '2020-05-10 02:50:15'),
(76, 'EN', 'Iron sword', '2020-05-10 02:50:15'),
(77, 'FR', 'Marteau en fer', '2020-05-10 02:50:15'),
(77, 'EN', 'Iron hammer', '2020-05-10 02:50:15'),
(78, 'FR', 'Hache en fer', '2020-05-10 02:50:15'),
(78, 'EN', 'Iron axe', '2020-05-10 02:50:15'),
(79, 'FR', 'Arc de bandit', '2020-05-10 02:50:15'),
(79, 'EN', 'Bandit Bow', '2020-05-10 02:50:16'),
(80, 'FR', 'Petit arc de Bandit', '2020-05-10 02:50:16'),
(80, 'EN', 'Small bandit Bow', '2020-05-10 02:50:16'),
(81, 'FR', 'Arbalète de Bandit', '2020-05-10 02:50:17'),
(81, 'EN', 'Bandit Crossbow', '2020-05-10 02:50:17'),
(82, 'FR', 'Bâton de feu pour amateur', '2020-05-10 02:50:17'),
(82, 'EN', 'Amator\'s fire staff', '2020-05-10 02:50:17'),
(83, 'FR', 'Bâton de glace pour amateur', '2020-05-10 02:50:18'),
(83, 'EN', 'Amator\'s ice staff', '2020-05-10 02:50:18'),
(84, 'FR', 'Bâton de terre pour amateur', '2020-05-10 02:50:18'),
(84, 'EN', 'Amator\'s earth staff', '2020-05-10 02:50:18'),
(85, 'FR', 'Bâton d\'eau pour amateur', '2020-05-10 02:50:18'),
(85, 'EN', 'Amator\'s water staff', '2020-05-10 02:50:18'),
(86, 'FR', 'Bâton de magma pour amateur', '2020-05-10 02:50:18'),
(86, 'EN', 'Amator\'s magma staff', '2020-05-10 02:50:18'),
(87, 'FR', 'Bâton d\'ombre pour amateur', '2020-05-10 02:50:18'),
(87, 'EN', 'Amator\'s shadow staff', '2020-05-10 02:50:18'),
(88, 'FR', 'Bâton de lumière pour amateur', '2020-05-10 02:50:19'),
(88, 'EN', 'Amator\'s light staff', '2020-05-10 02:50:19'),
(89, 'FR', 'Bâton de destruction pour amateur', '2020-05-10 02:50:19'),
(89, 'EN', 'Amator\'s destruction staff', '2020-05-10 02:50:19'),
(90, 'FR', 'Bâton de régénération pour amateur', '2020-05-10 02:50:19'),
(90, 'EN', 'Amator\'s regeneration staff', '2020-05-10 02:50:19'),
(91, 'FR', 'Dague en Acier', '2020-05-10 02:50:19'),
(91, 'EN', 'Steel dagger', '2020-05-10 02:50:19'),
(92, 'FR', 'Épée en acier', '2020-05-10 02:50:19'),
(92, 'EN', 'Steel sword', '2020-05-10 02:50:20'),
(93, 'FR', 'Marteau en acier', '2020-05-10 02:50:20'),
(93, 'EN', 'Steel hammer', '2020-05-10 02:50:20'),
(94, 'FR', 'Hache en acier', '2020-05-10 02:50:20'),
(94, 'EN', 'Steel axe', '2020-05-10 02:50:20'),
(95, 'FR', 'Arc de Chasseur', '2020-05-10 02:50:20'),
(95, 'EN', 'Hunter Bow', '2020-05-10 02:50:20'),
(96, 'FR', 'Petit arc de Chasseur', '2020-05-10 02:50:20'),
(96, 'EN', 'Small hunter Bow', '2020-05-10 02:50:20'),
(97, 'FR', 'Arbalète de Chasseur', '2020-05-10 02:50:20'),
(97, 'EN', 'Hunter Crossbow', '2020-05-10 02:50:20'),
(98, 'FR', 'Bâton de feu pour apprenti', '2020-05-10 02:50:21'),
(98, 'EN', 'Apprentice\'s fire staff', '2020-05-10 02:50:21'),
(99, 'FR', 'Bâton de glace pour apprenti', '2020-05-10 02:50:21'),
(99, 'EN', 'Apprentice\'s ice staff', '2020-05-10 02:50:21'),
(100, 'FR', 'Bâton de terre pour apprenti', '2020-05-10 02:50:21'),
(100, 'EN', 'Apprentice\'s earth staff', '2020-05-10 02:50:21'),
(101, 'FR', 'Bâton d\'eau pour apprenti', '2020-05-10 02:50:22'),
(101, 'EN', 'Apprentice\'s water staff', '2020-05-10 02:50:22'),
(102, 'FR', 'Bâton de magma pour apprenti', '2020-05-10 02:50:22'),
(102, 'EN', 'Apprentice\'s magma staff', '2020-05-10 02:50:22'),
(103, 'FR', 'Bâton d\'ombre pour apprenti', '2020-05-10 02:50:22'),
(103, 'EN', 'Apprentice\'s shadow staff', '2020-05-10 02:50:22'),
(104, 'FR', 'Bâton de lumière pour apprenti', '2020-05-10 02:50:22'),
(104, 'EN', 'Apprentice\'s light staff', '2020-05-10 02:50:23'),
(105, 'FR', 'Bâton de destruction pour apprenti', '2020-05-10 02:50:23'),
(105, 'EN', 'Apprentice\'s destruction staff', '2020-05-10 02:50:23'),
(106, 'FR', 'Bâton de régénération pour apprenti', '2020-05-10 02:50:23'),
(106, 'EN', 'Apprentice\'s regeneration staff', '2020-05-10 02:50:23'),
(107, 'FR', 'Dague en Gylo', '2020-05-10 02:50:23'),
(107, 'EN', 'Gylo dagger', '2020-05-10 02:50:23'),
(108, 'FR', 'Épée en Gylo', '2020-05-10 02:50:23'),
(108, 'EN', 'Gylo sword', '2020-05-10 02:50:23'),
(109, 'FR', 'Marteau en Gylo', '2020-05-10 02:50:23'),
(109, 'EN', 'Gylo hammer', '2020-05-10 02:50:23'),
(110, 'FR', 'Hache en Gylo', '2020-05-10 02:50:24'),
(110, 'EN', 'Gylo axe', '2020-05-10 02:50:24'),
(111, 'FR', 'Arc de Soldat', '2020-05-10 02:50:24'),
(111, 'EN', 'Soldier Bow', '2020-05-10 02:50:24'),
(112, 'FR', 'Petit arc de Soldat', '2020-05-10 02:50:24'),
(112, 'EN', 'Small soldier Bow', '2020-05-10 02:50:24'),
(113, 'FR', 'Arbalète de Soldat', '2020-05-10 02:50:24'),
(113, 'EN', 'Soldier Crossbow', '2020-05-10 02:50:24'),
(114, 'FR', 'Bâton de feu pour mage', '2020-05-10 02:50:25'),
(114, 'EN', 'Mage\'s fire staff', '2020-05-10 02:50:25'),
(115, 'FR', 'Bâton de glace pour mage', '2020-05-10 02:50:25'),
(115, 'EN', 'Mage\'s ice staff', '2020-05-10 02:50:25'),
(116, 'FR', 'Bâton de terre pour mage', '2020-05-10 02:50:25'),
(116, 'EN', 'Mage\'s earth staff', '2020-05-10 02:50:25'),
(117, 'FR', 'Bâton d\'eau pour mage', '2020-05-10 02:50:25'),
(117, 'EN', 'Mage\'s water staff', '2020-05-10 02:50:26'),
(118, 'FR', 'Bâton de magma pour mage', '2020-05-10 02:50:26'),
(118, 'EN', 'Mage\'s magma staff', '2020-05-10 02:50:26'),
(119, 'FR', 'Bâton d\'ombre pour mage', '2020-05-10 02:50:26'),
(119, 'EN', 'Mage\'s shadow staff', '2020-05-10 02:50:26'),
(120, 'FR', 'Bâton de lumière pour mage', '2020-05-10 02:50:26'),
(120, 'EN', 'Mage\'s light staff', '2020-05-10 02:50:27'),
(121, 'FR', 'Bâton de destruction pour mage', '2020-05-10 02:50:27'),
(121, 'EN', 'Mage\'s destruction staff', '2020-05-10 02:50:27'),
(122, 'FR', 'Bâton de régénération pour mage', '2020-05-10 02:50:27'),
(122, 'EN', 'Mage\'s regeneration staff', '2020-05-10 02:50:27'),
(123, 'FR', 'Dague en Kulop', '2020-05-10 02:50:27'),
(123, 'EN', 'Kulop dagger', '2020-05-10 02:50:27'),
(124, 'FR', 'Épée en Kulop', '2020-05-10 02:50:27'),
(124, 'EN', 'Kulop sword', '2020-05-10 02:50:28'),
(125, 'FR', 'Marteau en Kulop', '2020-05-10 02:50:28'),
(125, 'EN', 'Kulop hammer', '2020-05-10 02:50:28'),
(126, 'FR', 'Hache en Kulop', '2020-05-10 02:50:28'),
(126, 'EN', 'Kulop axe', '2020-05-10 02:50:28'),
(127, 'FR', 'Arc d\'Officier', '2020-05-10 02:50:28'),
(127, 'EN', 'Officer Bow', '2020-05-10 02:50:28'),
(128, 'FR', 'Petit arc d\'Officier', '2020-05-10 02:50:29'),
(128, 'EN', 'Small officer Bow', '2020-05-10 02:50:29'),
(129, 'FR', 'Arbalète d\'Officier', '2020-05-10 02:50:29'),
(129, 'EN', 'Officer Crossbow', '2020-05-10 02:50:29'),
(130, 'FR', 'Bâton de feu pour enseignant', '2020-05-10 02:50:29'),
(130, 'EN', 'Teacher\'s fire staff', '2020-05-10 02:50:29'),
(131, 'FR', 'Bâton de glace pour enseignant', '2020-05-10 02:50:29'),
(131, 'EN', 'Teacher\'s ice staff', '2020-05-10 02:50:29'),
(132, 'FR', 'Bâton de terre pour enseignant', '2020-05-10 02:50:30'),
(132, 'EN', 'Teacher\'s earth staff', '2020-05-10 02:50:30'),
(133, 'FR', 'Bâton d\'eau pour enseignant', '2020-05-10 02:50:30'),
(133, 'EN', 'Teacher\'s water staff', '2020-05-10 02:50:30'),
(134, 'FR', 'Bâton de magma pour enseignant', '2020-05-10 02:50:30'),
(134, 'EN', 'Teacher\'s magma staff', '2020-05-10 02:50:30'),
(135, 'FR', 'Bâton d\'ombre pour enseignant', '2020-05-10 02:50:30'),
(135, 'EN', 'Teacher\'s shadow staff', '2020-05-10 02:50:30'),
(136, 'FR', 'Bâton de lumière pour enseignant', '2020-05-10 02:50:30'),
(136, 'EN', 'Teacher\'s light staff', '2020-05-10 02:50:30'),
(137, 'FR', 'Bâton de destruction pour enseignant', '2020-05-10 02:50:31'),
(137, 'EN', 'Teacher\'s destruction staff', '2020-05-10 02:50:31'),
(138, 'FR', 'Bâton de régénération pour mage', '2020-05-10 02:50:31'),
(138, 'EN', 'Mage\'s regeneration staff', '2020-05-10 02:50:31'),
(139, 'FR', 'Dague en Vui', '2020-05-10 02:50:31'),
(139, 'EN', 'Vui dagger', '2020-05-10 02:50:31'),
(140, 'FR', 'Épée en Vui', '2020-05-10 02:50:31'),
(140, 'EN', 'Vui sword', '2020-05-10 02:50:31'),
(141, 'FR', 'Marteau en Vui', '2020-05-10 02:50:31'),
(141, 'EN', 'Vui hammer', '2020-05-10 02:50:31'),
(142, 'FR', 'Hache en Vui', '2020-05-10 02:50:32'),
(142, 'EN', 'Vui axe', '2020-05-10 02:50:32'),
(143, 'FR', 'Arc de Général', '2020-05-10 02:50:32'),
(143, 'EN', 'General Bow', '2020-05-10 02:50:32'),
(144, 'FR', 'Petit arc de Général', '2020-05-10 02:50:32'),
(144, 'EN', 'Small general Bow', '2020-05-10 02:50:32'),
(145, 'FR', 'Arbalète de Général', '2020-05-10 02:50:32'),
(145, 'EN', 'General Crossbow', '2020-05-10 02:50:32'),
(146, 'FR', 'Bâton de feu pour maître', '2020-05-10 02:50:33'),
(146, 'EN', 'Master\'s fire staff', '2020-05-10 02:50:33'),
(147, 'FR', 'Bâton de glace pour maître', '2020-05-10 02:50:33'),
(147, 'EN', 'Master\'s ice staff', '2020-05-10 02:50:33'),
(148, 'FR', 'Bâton de terre pour maître', '2020-05-10 02:50:33'),
(148, 'EN', 'Master\'s earth staff', '2020-05-10 02:50:33'),
(149, 'FR', 'Bâton d\'eau pour maître', '2020-05-10 02:50:33'),
(149, 'EN', 'Master\'s water staff', '2020-05-10 02:50:33'),
(150, 'FR', 'Bâton de magma pour maître', '2020-05-10 02:50:33'),
(150, 'EN', 'Master\'s magma staff', '2020-05-10 02:50:34'),
(151, 'FR', 'Bâton d\'ombre pour maître', '2020-05-10 02:50:34'),
(151, 'EN', 'Master\'s shadow staff', '2020-05-10 02:50:34'),
(152, 'FR', 'Bâton de lumière pour maître', '2020-05-10 02:50:34'),
(152, 'EN', 'Master\'s light staff', '2020-05-10 02:50:34'),
(153, 'FR', 'Bâton de destruction pour maître', '2020-05-10 02:50:34'),
(153, 'EN', 'Master\'s destruction staff', '2020-05-10 02:50:34'),
(154, 'FR', 'Bâton de régénération pour maître', '2020-05-10 02:50:34'),
(154, 'EN', 'Master\'s regeneration staff', '2020-05-10 02:50:34'),
(155, 'FR', 'Dague en Nalan', '2020-05-10 02:50:35'),
(155, 'EN', 'Nalan dagger', '2020-05-10 02:50:35'),
(156, 'FR', 'Épée en Nalan', '2020-05-10 02:50:35'),
(156, 'EN', 'Nalan sword', '2020-05-10 02:50:35'),
(157, 'FR', 'Marteau en Nalan', '2020-05-10 02:50:35'),
(157, 'EN', 'Nalan hammer', '2020-05-10 02:50:35'),
(158, 'FR', 'Hache en Nalan', '2020-05-10 02:50:35'),
(158, 'EN', 'Nalan axe', '2020-05-10 02:50:35'),
(159, 'FR', 'Arc Héroïque', '2020-05-10 02:50:36'),
(159, 'EN', 'Heroic Bow', '2020-05-10 02:50:36'),
(160, 'FR', 'Petit arc Héroïque', '2020-05-10 02:50:36'),
(160, 'EN', 'Small heroic Bow', '2020-05-10 02:50:36'),
(161, 'FR', 'Arbalète Héroïque', '2020-05-10 02:50:36'),
(161, 'EN', 'Heroic Crossbow', '2020-05-10 02:50:36'),
(162, 'FR', 'Bâton de feu pour héro', '2020-05-10 02:50:36'),
(162, 'EN', 'Hero\'s fire staff', '2020-05-10 02:50:36'),
(163, 'FR', 'Bâton de glace pour héro', '2020-05-10 02:50:36'),
(163, 'EN', 'Hero\'s ice staff', '2020-05-10 02:50:36'),
(164, 'FR', 'Bâton de terre pour héro', '2020-05-10 02:50:37'),
(164, 'EN', 'Hero\'s earth staff', '2020-05-10 02:50:37'),
(165, 'FR', 'Bâton d\'eau pour héro', '2020-05-10 02:50:37'),
(165, 'EN', 'Hero\'s water staff', '2020-05-10 02:50:37'),
(166, 'FR', 'Bâton de magma pour héro', '2020-05-10 02:50:37'),
(166, 'EN', 'Hero\'s magma staff', '2020-05-10 02:50:37'),
(167, 'FR', 'Bâton d\'ombre pour héro', '2020-05-10 02:50:37'),
(167, 'EN', 'Hero\'s shadow staff', '2020-05-10 02:50:37'),
(168, 'FR', 'Bâton de lumière pour héro', '2020-05-10 02:50:38'),
(168, 'EN', 'Hero\'s light staff', '2020-05-10 02:50:38'),
(169, 'FR', 'Bâton de destruction pour héro', '2020-05-10 02:50:38'),
(169, 'EN', 'Hero\'s destruction staff', '2020-05-10 02:50:38'),
(170, 'FR', 'Bâton de régénération pour héro', '2020-05-10 02:50:38'),
(170, 'EN', 'Hero\'s regeneration staff', '2020-05-10 02:50:38'),
(171, 'FR', 'Anneau en or', '2020-05-10 02:50:38'),
(171, 'EN', 'Gloden ring', '2020-05-10 02:50:38'),
(172, 'FR', 'Anneau en rubis', '2020-05-10 02:50:38'),
(172, 'EN', 'Ruby ring', '2020-05-10 02:50:38'),
(173, 'FR', 'Anneau en lapis', '2020-05-10 02:50:39'),
(173, 'EN', 'Lapis ring', '2020-05-10 02:50:39'),
(174, 'FR', 'Anneau en cristaux', '2020-05-10 02:50:39'),
(174, 'EN', 'Crystal ring', '2020-05-10 02:50:39'),
(175, 'FR', 'Anneau en argent', '2020-05-10 02:50:39'),
(175, 'EN', 'Silver ring', '2020-05-10 02:50:39'),
(176, 'FR', 'Anneau en cuivre', '2020-05-10 02:50:39'),
(176, 'EN', 'Copper ring', '2020-05-10 02:50:40'),
(177, 'FR', 'Collier en or', '2020-05-10 02:50:40'),
(177, 'EN', 'Gloden necklace', '2020-05-10 02:50:40'),
(178, 'FR', 'Collier en rubis', '2020-05-10 02:50:40'),
(178, 'EN', 'Ruby necklace', '2020-05-10 02:50:40'),
(179, 'FR', 'Collier en lapis', '2020-05-10 02:50:40'),
(179, 'EN', 'Lapis necklace', '2020-05-10 02:50:40'),
(180, 'FR', 'Collier en cristaux', '2020-05-10 02:50:40'),
(180, 'EN', 'Crystal necklace', '2020-05-10 02:50:40'),
(181, 'FR', 'Collier en argent', '2020-05-10 02:50:41'),
(181, 'EN', 'Silver necklace', '2020-05-10 02:50:41'),
(182, 'FR', 'Collier en cuivre', '2020-05-10 02:50:41'),
(182, 'EN', 'Copper necklace', '2020-05-10 02:50:41'),
(183, 'FR', 'de saignement', '2020-05-12 17:14:35'),
(183, 'EN', 'of bleeding', '2020-05-12 17:14:35'),
(184, 'FR', 'dégâts de l\'arme / |1| pendant 2d|2| tours avec |3|% de chance', '2020-05-12 17:14:36'),
(184, 'EN', 'weapon damage / |1| for 2d|2| turns with a |3|% chance', '2020-05-12 17:14:36'),
(185, 'FR', 'de feu', '2020-05-12 21:34:39'),
(185, 'EN', 'of burning', '2020-05-12 21:34:39'),
(186, 'FR', '1d|1| dégâts de feu pendant 2d|2| tour avec |3|% de chance', '2020-05-12 21:34:39'),
(186, 'EN', '1d|1| fire damage for 2d|2| turns with a |3|% chance', '2020-05-12 21:34:39'),
(187, 'FR', 'de glace', '2020-05-12 21:34:40'),
(187, 'EN', 'of ice', '2020-05-12 21:34:40'),
(188, 'FR', '1d|1| dégâts de glace pendant 2d|2| tour avec |3|% de chance', '2020-05-12 21:34:40'),
(188, 'EN', '1d|1| ice damage for 2d|2| turns with a |3|% chance', '2020-05-12 21:34:41'),
(189, 'FR', 'empoisonnée', '2020-05-12 21:34:41'),
(189, 'EN', 'poisoned', '2020-05-12 21:34:41'),
(190, 'FR', '1d|1| dégâts de poison pendant 2d|2| tour avec |3|% de chance', '2020-05-12 21:34:41'),
(190, 'EN', '1d|1| poison damage for 2d|2| turns with a |3|% chance', '2020-05-12 21:34:41'),
(191, 'FR', 'de money', '2020-05-12 21:34:42'),
(191, 'EN', 'of money', '2020-05-12 21:34:42'),
(192, 'FR', 'fait gagner 3d|1| IST chaque tour', '2020-05-12 21:34:42'),
(192, 'EN', 'earns 3d|1| IST each turn', '2020-05-12 21:34:42'),
(193, 'FR', 'd\'étourdissement', '2020-05-12 21:34:42'),
(193, 'EN', 'of stunning', '2020-05-12 21:34:43'),
(194, 'FR', 'étourdit pendant 2d|1| tour avec |2|% de chance', '2020-05-12 21:34:43'),
(194, 'EN', 'stun for 2d|1| turns with a |2|% chance', '2020-05-12 21:34:43'),
(195, 'FR', 'critique', '2020-05-12 21:34:43'),
(195, 'EN', 'critical', '2020-05-12 21:34:43'),
(196, 'FR', '+|1| en jet critique', '2020-05-12 21:34:43'),
(196, 'EN', '+|1| in critical roll', '2020-05-12 21:34:43'),
(197, 'FR', 'de résistance au feu', '2020-05-12 23:16:06'),
(197, 'EN', 'of fire resistance', '2020-05-12 23:16:06'),
(198, 'FR', '+|1| résistance au feu', '2020-05-12 23:16:06'),
(198, 'EN', '+|1| of fire resistance', '2020-05-12 23:16:06'),
(199, 'FR', 'de résistance à la glace', '2020-05-12 23:16:07'),
(199, 'EN', 'of ice resistance', '2020-05-12 23:16:07'),
(200, 'FR', '+|1| résistance à la glace', '2020-05-12 23:16:07'),
(200, 'EN', '+|1| of ice resistance', '2020-05-12 23:16:07'),
(201, 'FR', 'de résistance à la terre', '2020-05-12 23:16:08'),
(201, 'EN', 'of earth resistance', '2020-05-12 23:16:08'),
(202, 'FR', '+|1| résistance à la terre', '2020-05-12 23:16:08'),
(202, 'EN', '+|1| of earth resistance', '2020-05-12 23:16:08'),
(203, 'FR', 'de résistance à l\'eau', '2020-05-12 23:16:08'),
(203, 'EN', 'of water resistance', '2020-05-12 23:16:08'),
(204, 'FR', '+|1| résistance à l\'eau', '2020-05-12 23:16:08'),
(204, 'EN', '+|1| of water resistance', '2020-05-12 23:16:08'),
(205, 'FR', 'de résistance au magma', '2020-05-12 23:16:09'),
(205, 'EN', 'of magma resistance', '2020-05-12 23:16:09'),
(206, 'FR', '+|1| résistance au magma', '2020-05-12 23:16:09'),
(206, 'EN', '+|1| of magma resistance', '2020-05-12 23:16:09'),
(207, 'FR', 'de résistance à l\'ombre', '2020-05-12 23:16:09'),
(207, 'EN', 'of shadow resistance', '2020-05-12 23:16:09'),
(208, 'FR', '+|1| résistance à l\'ombre', '2020-05-12 23:16:09'),
(208, 'EN', '+|1| of shadow resistance', '2020-05-12 23:16:09'),
(209, 'FR', 'de résistance à la lumière', '2020-05-12 23:16:09'),
(209, 'EN', 'of light resistance', '2020-05-12 23:16:09'),
(210, 'FR', '+|1| résistance à la lumière', '2020-05-12 23:16:09'),
(210, 'EN', '+|1| of light resistance', '2020-05-12 23:16:09'),
(211, 'FR', 'de force', '2020-05-12 23:16:10'),
(211, 'EN', 'of strength', '2020-05-12 23:16:10'),
(212, 'FR', '+|1| en FOR', '2020-05-12 23:16:10'),
(212, 'EN', '+|1| of STR', '2020-05-12 23:16:10'),
(213, 'FR', 'de dextérité', '2020-05-12 23:16:10'),
(213, 'EN', 'of dexterity', '2020-05-12 23:16:10'),
(214, 'FR', '+|1| en DEX', '2020-05-12 23:16:10'),
(214, 'EN', '+|1| of DEX', '2020-05-12 23:16:10'),
(215, 'FR', 'de constitution', '2020-05-12 23:16:10'),
(215, 'EN', 'of constitution', '2020-05-12 23:16:10'),
(216, 'FR', '+|1| en CON', '2020-05-12 23:16:10'),
(216, 'EN', '+|1| of CON', '2020-05-12 23:16:10'),
(217, 'FR', 'd\'intelligence', '2020-05-12 23:16:11'),
(217, 'EN', 'of cleverness', '2020-05-12 23:16:11'),
(218, 'FR', '+|1| en INT', '2020-05-12 23:16:11'),
(218, 'EN', '+|1| of CLE', '2020-05-12 23:16:11'),
(219, 'FR', 'de charisme', '2020-05-12 23:16:11'),
(219, 'EN', 'of charisma', '2020-05-12 23:16:11'),
(220, 'FR', '+|1| en CHA', '2020-05-12 23:16:11'),
(220, 'EN', '+|1| of CHA', '2020-05-12 23:16:11'),
(221, 'FR', 'd\'agilité', '2020-05-12 23:16:11'),
(221, 'EN', 'of agility', '2020-05-12 23:16:11'),
(222, 'FR', '+|1| en AGI', '2020-05-12 23:16:11'),
(222, 'EN', '+|1| of AGI', '2020-05-12 23:16:12'),
(223, 'FR', 'de magie', '2020-05-12 23:16:12'),
(223, 'EN', 'of magic', '2020-05-12 23:16:12'),
(224, 'FR', '+|1| en MAG', '2020-05-12 23:16:12'),
(224, 'EN', '+|1| of MAG', '2020-05-12 23:16:12'),
(225, 'FR', 'd\'acuité', '2020-05-12 23:16:12'),
(225, 'EN', 'of acuity', '2020-05-12 23:16:12'),
(226, 'FR', '+|1| en ACU', '2020-05-12 23:16:12'),
(226, 'EN', '+|1| of ACU', '2020-05-12 23:16:12'),
(227, 'FR', 'de money', '2020-05-12 23:16:13'),
(227, 'EN', 'of money', '2020-05-12 23:16:13'),
(228, 'FR', 'fait gagner 3d|1| IST chaque tour', '2020-05-12 23:16:13'),
(228, 'EN', 'earns 3d|1| IST each turn', '2020-05-12 23:16:13'),
(229, 'FR', 'de vitesse', '2020-05-12 23:16:13'),
(229, 'EN', 'of speed', '2020-05-12 23:16:13'),
(230, 'FR', '+|1| PA chaque tour', '2020-05-12 23:16:13'),
(230, 'EN', '+|1| of AP each turn', '2020-05-12 23:16:13'),
(231, 'FR', 'de vie', '2020-05-12 23:16:13'),
(231, 'EN', 'of health', '2020-05-12 23:16:14'),
(232, 'FR', '+|1| PV', '2020-05-12 23:16:14'),
(232, 'EN', '+|1| HP', '2020-05-12 23:16:14'),
(233, 'FR', 'de mana', '2020-05-12 23:16:14'),
(233, 'EN', 'of mana', '2020-05-12 23:16:14'),
(234, 'FR', '+|1| mana', '2020-05-12 23:16:14'),
(234, 'EN', '+|1| mana', '2020-05-12 23:16:14'),
(235, 'FR', 'du marin', '2020-05-12 23:16:14'),
(235, 'EN', 'of the sailor', '2020-05-12 23:16:14'),
(236, 'FR', '+|1| pour tout les jets concernant les bateaux', '2020-05-12 23:16:14'),
(236, 'EN', '+|1| for all rolls concerning boats', '2020-05-12 23:16:14'),
(237, 'FR', 'de feu', '2020-05-12 23:16:15'),
(237, 'EN', 'of fire', '2020-05-12 23:16:15'),
(238, 'FR', '+|1| dégâts de feu', '2020-05-12 23:16:15'),
(238, 'EN', '+|1| fire damage', '2020-05-12 23:16:15'),
(239, 'FR', 'de glace', '2020-05-12 23:16:15'),
(239, 'EN', 'of ice', '2020-05-12 23:16:15'),
(240, 'FR', '+|1| dégâts de glace', '2020-05-12 23:16:15'),
(240, 'EN', '+|1| ice damage', '2020-05-12 23:16:16'),
(241, 'FR', 'de terre', '2020-05-12 23:16:16'),
(241, 'EN', 'of earth', '2020-05-12 23:16:16'),
(242, 'FR', '+|1| dégâts de terre', '2020-05-12 23:16:16'),
(242, 'EN', '+|1| earth damage', '2020-05-12 23:16:16'),
(243, 'FR', 'd\'eau', '2020-05-12 23:16:17'),
(243, 'EN', 'of water', '2020-05-12 23:16:17'),
(244, 'FR', '+|1| dégâts d\'eau', '2020-05-12 23:16:17'),
(244, 'EN', '+|1| water damage', '2020-05-12 23:16:17'),
(245, 'FR', 'de magma', '2020-05-12 23:16:17'),
(245, 'EN', 'of magma', '2020-05-12 23:16:17'),
(246, 'FR', '+|1| dégâts de magma', '2020-05-12 23:16:17'),
(246, 'EN', '+|1| magma damage', '2020-05-12 23:16:17'),
(247, 'FR', 'd\'ombre', '2020-05-12 23:16:18'),
(247, 'EN', 'of shadow', '2020-05-12 23:16:18'),
(248, 'FR', '+|1| dégâts d\'ombre', '2020-05-12 23:16:18'),
(248, 'EN', '+|1| shadow damage', '2020-05-12 23:16:18'),
(249, 'FR', 'de lumière', '2020-05-12 23:16:18'),
(249, 'EN', 'of light', '2020-05-12 23:16:18'),
(250, 'FR', '+|1| dégâts de lumière', '2020-05-12 23:16:18'),
(250, 'EN', '+|1| light damage', '2020-05-12 23:16:18'),
(251, 'FR', 'de soin', '2020-05-12 23:16:18'),
(251, 'EN', 'of healing', '2020-05-12 23:16:18'),
(252, 'FR', '+|1| récupération de soin', '2020-05-12 23:16:18'),
(252, 'EN', '+|1| heal recovery', '2020-05-12 23:16:18'),
(253, 'FR', 'critique', '2020-05-12 23:16:19'),
(253, 'EN', 'critical', '2020-05-12 23:16:19'),
(254, 'FR', '+|1| pour les jets critiques', '2020-05-12 23:16:19'),
(254, 'EN', '+|1| for critical rolls', '2020-05-12 23:16:19'),
(255, 'FR', 'du marchand', '2020-05-12 23:16:19'),
(255, 'EN', 'of the seller', '2020-05-12 23:16:19'),
(256, 'FR', '+ ou - |1|% du prix des items (achat et vente)', '2020-05-12 23:16:19'),
(256, 'EN', '+ or - |1|% of items price (buying and selling)', '2020-05-12 23:16:19'),
(257, 'FR', 'de régénération de vie', '2020-05-12 23:16:19'),
(257, 'EN', 'of health regeneration', '2020-05-12 23:16:19'),
(258, 'FR', '+|1| PV à la fin de chaque tour', '2020-05-12 23:16:19'),
(258, 'EN', '+|1| HP at the end of each turn', '2020-05-12 23:16:19'),
(259, 'FR', 'de régénération de mana', '2020-05-12 23:16:20'),
(259, 'EN', 'of mana regeneration', '2020-05-12 23:16:20'),
(260, 'FR', '+|1| mana à la fin de chaque tour', '2020-05-12 23:16:20'),
(260, 'EN', '+|1| mana at the end of each turn', '2020-05-12 23:16:20'),
(261, 'FR', 'de focus', '2020-05-12 23:16:20'),
(261, 'EN', 'of focus', '2020-05-12 23:16:20'),
(262, 'FR', '+|1| focus maximum', '2020-05-12 23:16:20'),
(262, 'EN', '+|1| maximum focus', '2020-05-12 23:16:20'),
(263, 'FR', 'Potion de santé (15 PV)', '2020-05-12 23:56:28'),
(263, 'EN', 'Health potion (15 HP)', '2020-05-12 23:56:28'),
(264, 'FR', 'Potion de santé (30 PV)', '2020-05-12 23:56:28'),
(264, 'EN', 'Health potion (30 HP)', '2020-05-12 23:56:28'),
(265, 'FR', 'Potion de santé (45 PV)', '2020-05-12 23:56:28'),
(265, 'EN', 'Health potion (45 HP)', '2020-05-12 23:56:28'),
(266, 'FR', 'Potion de santé (60 PV)', '2020-05-12 23:56:28'),
(266, 'EN', 'Health potion (60 HP)', '2020-05-12 23:56:28'),
(267, 'FR', 'Potion de santé (75 PV)', '2020-05-12 23:56:29'),
(267, 'EN', 'Health potion (75 HP)', '2020-05-12 23:56:29'),
(268, 'FR', 'Potion de santé (90 PV)', '2020-05-12 23:56:29'),
(268, 'EN', 'Health potion (90 HP)', '2020-05-12 23:56:29'),
(269, 'FR', 'Potion de santé (105 PV)', '2020-05-12 23:56:29'),
(269, 'EN', 'Health potion (105 HP)', '2020-05-12 23:56:29'),
(270, 'FR', 'Potion de mana (15 mana)', '2020-05-12 23:56:29'),
(270, 'EN', 'Mana potion (15 mana)', '2020-05-12 23:56:29'),
(271, 'FR', 'Potion de mana (30 mana)', '2020-05-12 23:56:30'),
(271, 'EN', 'Mana potion (30 mana)', '2020-05-12 23:56:30'),
(272, 'FR', 'Potion de mana (45 mana)', '2020-05-12 23:56:30'),
(272, 'EN', 'Mana potion (45 mana)', '2020-05-12 23:56:30'),
(273, 'FR', 'Potion de mana (60 mana)', '2020-05-12 23:56:30'),
(273, 'EN', 'Mana potion (60 mana)', '2020-05-12 23:56:30'),
(274, 'FR', 'Potion de mana (75 mana)', '2020-05-12 23:56:31'),
(274, 'EN', 'Mana potion (75 mana)', '2020-05-12 23:56:31'),
(275, 'FR', 'Potion de mana (90 mana)', '2020-05-12 23:56:31'),
(275, 'EN', 'Mana potion (90 mana)', '2020-05-12 23:56:31'),
(276, 'FR', 'Potion de mana (105 mana)', '2020-05-12 23:56:31'),
(276, 'EN', 'Mana potion (105 mana)', '2020-05-12 23:56:31'),
(277, 'FR', 'Potion de vitesse (2 PA)', '2020-05-12 23:56:31'),
(277, 'EN', 'Speed potion (2 AP)', '2020-05-12 23:56:31'),
(278, 'FR', 'Potion de vitesse (4 PA)', '2020-05-12 23:56:31'),
(278, 'EN', 'Speed potion (4 AP)', '2020-05-12 23:56:31'),
(279, 'FR', 'Potion de vitesse (6 PA)', '2020-05-12 23:56:32'),
(279, 'EN', 'Speed potion (6 AP)', '2020-05-12 23:56:32'),
(280, 'FR', 'Potion de vitesse (8 PA)', '2020-05-12 23:56:32'),
(280, 'EN', 'Speed potion (8 AP)', '2020-05-12 23:56:32'),
(281, 'FR', 'Potion de vitesse (10 PA)', '2020-05-12 23:56:32'),
(281, 'EN', 'Speed potion (10 AP)', '2020-05-12 23:56:32'),
(282, 'FR', 'Potion de vitesse (12 PA)', '2020-05-12 23:56:32'),
(282, 'EN', 'Speed potion (12 AP)', '2020-05-12 23:56:32'),
(283, 'FR', 'Potion de vitesse (14 PA)', '2020-05-12 23:56:32'),
(283, 'EN', 'Speed potion (14 AP)', '2020-05-12 23:56:32'),
(284, 'FR', 'Potion d\'invisibilité (2 tours)', '2020-05-12 23:56:33'),
(284, 'EN', 'Invisibility potion (2 turns)', '2020-05-12 23:56:33'),
(285, 'FR', 'Potion d\'invisibilité (4 tours)', '2020-05-12 23:56:33'),
(285, 'EN', 'Invisibility potion (4 turns)', '2020-05-12 23:56:33'),
(286, 'FR', 'Potion d\'invisibilité (6 tours)', '2020-05-12 23:56:33'),
(286, 'EN', 'Invisibility potion (6 turns)', '2020-05-12 23:56:33'),
(287, 'FR', 'Potion d\'invisibilité (8 tours)', '2020-05-12 23:56:33'),
(287, 'EN', 'Invisibility potion (8 turns)', '2020-05-12 23:56:33'),
(288, 'FR', 'Potion d\'invisibilité (10 tours)', '2020-05-12 23:56:33'),
(288, 'EN', 'Invisibility potion (10 turns)', '2020-05-12 23:56:33'),
(289, 'FR', 'Potion d\'invisibilité (12 tours)', '2020-05-12 23:56:33'),
(289, 'EN', 'Invisibility potion (12 turns)', '2020-05-12 23:56:34'),
(290, 'FR', 'Potion d\'invisibilité (14 tours)', '2020-05-12 23:56:34'),
(290, 'EN', 'Invisibility potion (14 turns)', '2020-05-12 23:56:34'),
(291, 'FR', 'Potion de critique (+3)', '2020-05-12 23:56:34'),
(291, 'EN', 'Critical potion (+3)', '2020-05-12 23:56:34'),
(292, 'FR', 'Neutre', '2020-05-13 11:54:08'),
(292, 'EN', 'Neutral', '2020-05-13 11:54:08'),
(293, 'FR', 'Feu', '2020-05-13 11:54:08'),
(293, 'EN', 'Fire', '2020-05-13 11:54:08'),
(294, 'FR', 'Glace', '2020-05-13 11:54:08'),
(294, 'EN', 'Ice', '2020-05-13 11:54:08'),
(295, 'FR', 'Terre', '2020-05-13 11:54:08'),
(295, 'EN', 'Earth', '2020-05-13 11:54:08'),
(296, 'FR', 'Eau', '2020-05-13 11:54:08'),
(296, 'EN', 'Water', '2020-05-13 11:54:08'),
(297, 'FR', 'Magma', '2020-05-13 11:54:08'),
(297, 'EN', 'Magma', '2020-05-13 11:54:09'),
(298, 'FR', 'Ombre', '2020-05-13 11:54:09'),
(298, 'EN', 'Shadow', '2020-05-13 11:54:09'),
(299, 'FR', 'Lumière', '2020-05-13 11:54:09'),
(299, 'EN', 'Light', '2020-05-13 11:54:09'),
(300, 'FR', 'Soin', '2020-05-13 11:54:09'),
(300, 'EN', 'Heal', '2020-05-13 11:54:09'),
(301, 'FR', 'flammèche', '2020-05-13 14:52:49'),
(301, 'EN', 'fire spark', '2020-05-13 14:52:49'),
(302, 'FR', 'chuchotement glacé', '2020-05-13 14:52:49'),
(302, 'EN', 'icy whisper', '2020-05-13 14:52:49'),
(303, 'FR', 'mouvement de terre', '2020-05-13 14:52:50'),
(303, 'EN', 'earth movement', '2020-05-13 14:52:50'),
(304, 'FR', 'gouttelettes d\'eau', '2020-05-13 14:52:50'),
(304, 'EN', 'water droplets', '2020-05-13 14:52:50'),
(305, 'FR', 'éclaboussure de lave', '2020-05-13 14:52:50'),
(305, 'EN', 'lava splash', '2020-05-13 14:52:50'),
(306, 'FR', 'dague d\'ombre', '2020-05-13 14:52:50'),
(306, 'EN', 'shadow dagger', '2020-05-13 14:52:50'),
(307, 'FR', 'dague de lumière', '2020-05-13 14:52:50'),
(307, 'EN', 'light dagger', '2020-05-13 14:52:50'),
(308, 'FR', 'premier soin', '2020-05-13 14:52:51'),
(308, 'EN', 'primary care', '2020-05-13 14:52:51'),
(309, 'FR', 'boule de feu', '2020-05-13 14:52:51'),
(309, 'EN', 'fireball', '2020-05-13 14:52:51'),
(310, 'FR', 'tir glacé', '2020-05-13 14:52:51'),
(310, 'EN', 'icy shot', '2020-05-13 14:52:51'),
(311, 'FR', 'mini-éboulement', '2020-05-13 14:52:51'),
(311, 'EN', 'small landslide', '2020-05-13 14:52:51'),
(312, 'FR', 'jet d\'eau', '2020-05-13 14:52:51'),
(312, 'EN', 'water jets', '2020-05-13 14:52:51'),
(313, 'FR', 'jet de lave', '2020-05-13 14:52:51'),
(313, 'EN', 'lava jets', '2020-05-13 14:52:52'),
(314, 'FR', 'attaque de l\'ombre', '2020-05-13 14:52:52'),
(314, 'EN', 'shadow\'s attack', '2020-05-13 14:52:52'),
(315, 'FR', 'aveuglement lumineux', '2020-05-13 14:52:52'),
(315, 'EN', 'luminous blindness', '2020-05-13 14:52:52'),
(316, 'FR', 'assistance', '2020-05-13 14:52:52'),
(316, 'EN', 'support', '2020-05-13 14:52:52'),
(317, 'FR', 'lance de flamme', '2020-05-13 14:52:52'),
(317, 'EN', 'fire spear', '2020-05-13 14:52:52'),
(318, 'FR', 'souffle glacé', '2020-05-13 14:52:53'),
(318, 'EN', 'icy blast', '2020-05-13 14:52:53'),
(319, 'FR', 'éboulement', '2020-05-13 14:52:53'),
(319, 'EN', 'landslide', '2020-05-13 14:52:53'),
(320, 'FR', 'vague solitaire', '2020-05-13 14:52:53'),
(320, 'EN', 'lonely wave', '2020-05-13 14:52:53'),
(321, 'FR', 'petite éruption volcanique', '2020-05-13 14:52:53'),
(321, 'EN', 'small volcanic eruption', '2020-05-13 14:52:53'),
(322, 'FR', 'silence nocturne', '2020-05-13 14:52:53'),
(322, 'EN', 'nocturnal silence', '2020-05-13 14:52:53'),
(323, 'FR', 'prisme coloré', '2020-05-13 14:52:54'),
(323, 'EN', 'coloured prism', '2020-05-13 14:52:54'),
(324, 'FR', 'réparation', '2020-05-13 14:52:54'),
(324, 'EN', 'repair', '2020-05-13 14:52:54'),
(325, 'FR', 'roue de feu', '2020-05-13 14:52:54'),
(325, 'EN', 'fire wheel', '2020-05-13 14:52:54'),
(326, 'FR', 'tempête hivernale', '2020-05-13 14:52:54'),
(326, 'EN', 'winter storm', '2020-05-13 14:52:54'),
(327, 'FR', 'tremblement de terre', '2020-05-13 14:52:54'),
(327, 'EN', 'earthquake', '2020-05-13 14:52:54'),
(328, 'FR', 'rayon aquatique', '2020-05-13 14:52:55'),
(328, 'EN', 'aquatic beam', '2020-05-13 14:52:55'),
(329, 'FR', 'éruption volcanique', '2020-05-13 14:52:55'),
(329, 'EN', 'volcanic eruption', '2020-05-13 14:52:55'),
(330, 'FR', 'assassinat', '2020-05-13 14:52:55'),
(330, 'EN', 'assassination', '2020-05-13 14:52:55'),
(331, 'FR', 'souffle brillant', '2020-05-13 14:52:55'),
(331, 'EN', 'bright blast', '2020-05-13 14:52:55'),
(332, 'FR', 'sauvetage', '2020-05-13 14:52:55'),
(332, 'EN', 'rescue', '2020-05-13 14:52:56'),
(333, 'FR', 'mur de flamme', '2020-05-13 14:52:56'),
(333, 'EN', 'fire wall', '2020-05-13 14:52:56'),
(334, 'FR', 'muraille glacé', '2020-05-13 14:52:56'),
(334, 'EN', 'icy wall', '2020-05-13 14:52:56'),
(335, 'FR', 'séisme', '2020-05-13 14:52:56'),
(335, 'EN', 'seism', '2020-05-13 14:52:56'),
(336, 'FR', 'noyade', '2020-05-13 14:52:56'),
(336, 'EN', 'drowning', '2020-05-13 14:52:56'),
(337, 'FR', 'tempête de lave', '2020-05-13 14:52:57'),
(337, 'EN', 'lava storm', '2020-05-13 14:52:57'),
(338, 'FR', 'cri ténébreux', '2020-05-13 14:52:57'),
(338, 'EN', 'sark shout', '2020-05-13 14:52:57'),
(339, 'FR', 'méditation destructrice', '2020-05-13 14:52:57'),
(339, 'EN', 'desctructive meditation', '2020-05-13 14:52:57'),
(340, 'FR', 'soin grandiose', '2020-05-13 14:52:57'),
(340, 'EN', 'grand healing', '2020-05-13 14:52:57'),
(341, 'FR', 'cage enflammée', '2020-05-13 14:52:57'),
(341, 'EN', 'burning cage', '2020-05-13 14:52:57'),
(342, 'FR', 'zéro absolu', '2020-05-13 14:52:58'),
(342, 'EN', 'absolute zero', '2020-05-13 14:52:58'),
(343, 'FR', 'trou béant', '2020-05-13 14:52:58'),
(343, 'EN', 'gaping hole', '2020-05-13 14:52:58'),
(344, 'FR', 'raz-de-marée', '2020-05-13 14:52:58'),
(344, 'EN', 'seaquake', '2020-05-13 14:52:58'),
(345, 'FR', 'météore', '2020-05-13 14:52:58'),
(345, 'EN', 'meteor', '2020-05-13 14:52:58'),
(346, 'FR', 'appel de l\'ombre', '2020-05-13 14:52:59'),
(346, 'EN', 'shadow call', '2020-05-13 14:52:59'),
(347, 'FR', 'lance sainte', '2020-05-13 14:52:59'),
(347, 'EN', 'holy spear', '2020-05-13 14:52:59'),
(348, 'FR', 'soin miraculeux', '2020-05-13 14:52:59'),
(348, 'EN', 'miraculous healing', '2020-05-13 14:52:59'),
(349, 'FR', 'Fournaise de l\'Enfer', '2020-05-13 14:52:59'),
(349, 'EN', 'Hell\'s furnace', '2020-05-13 14:52:59'),
(350, 'FR', 'Hiver Infini', '2020-05-13 14:53:00'),
(350, 'EN', 'Infinite Winter', '2020-05-13 14:53:00'),
(351, 'FR', 'Brèche Continentale', '2020-05-13 14:53:00'),
(351, 'EN', 'Continental Breach', '2020-05-13 14:53:00'),
(352, 'FR', 'Tsunami Gigantesque', '2020-05-13 14:53:00'),
(352, 'EN', 'Gigantic Tsunami', '2020-05-13 14:53:00'),
(353, 'FR', 'Fusion Planétaire', '2020-05-13 14:53:00'),
(353, 'EN', 'Planetary Meltdown', '2020-05-13 14:53:00'),
(354, 'FR', 'Ténèbre Apocalyptique', '2020-05-13 14:53:00'),
(354, 'EN', 'Apocalyptic Darkness', '2020-05-13 14:53:01'),
(355, 'FR', 'Appel aux Dieux', '2020-05-13 14:53:01'),
(355, 'EN', 'Gods Call', '2020-05-13 14:53:01'),
(356, 'FR', 'Guérison Divine', '2020-05-13 14:53:01'),
(356, 'EN', 'Holy Healing', '2020-05-13 14:53:01'),
(357, 'FR', 'familier aquatique', '2020-05-13 14:53:01'),
(357, 'EN', 'aquatic familiar', '2020-05-13 14:53:01'),
(358, 'FR', 'bête enflammée', '2020-05-13 14:53:01'),
(358, 'EN', 'flamming beast', '2020-05-13 14:53:01'),
(359, 'FR', 'yéti', '2020-05-13 14:53:01'),
(359, 'EN', 'yeti', '2020-05-13 14:53:01'),
(360, 'FR', 'démon magmatique', '2020-05-13 14:53:01'),
(360, 'EN', 'magmatic demon', '2020-05-13 14:53:02'),
(361, 'FR', 'grand golem', '2020-05-13 14:53:02'),
(361, 'EN', 'great golem', '2020-05-13 14:53:02'),
(362, 'FR', 'tourelle de guérison', '2020-05-13 14:53:02'),
(362, 'EN', 'healing turret', '2020-05-13 14:53:02'),
(363, 'FR', 'Super Ninja', '2020-05-13 14:53:02'),
(363, 'EN', 'Super Ninja', '2020-05-13 14:53:02'),
(364, 'FR', 'Dieu Mineur', '2020-05-13 14:53:02'),
(364, 'EN', 'Minor God', '2020-05-13 14:53:02'),
(365, 'FR', 'petite invisibilité', '2020-05-13 14:53:02'),
(365, 'EN', 'small invisibility', '2020-05-13 14:53:02'),
(366, 'FR', 'invisibilité', '2020-05-13 14:53:03'),
(366, 'EN', 'invisibility', '2020-05-13 14:53:03'),
(367, 'FR', 'Grande invisibilité', '2020-05-13 14:53:03'),
(367, 'EN', 'Great invisibility', '2020-05-13 14:53:03'),
(368, 'FR', 'petite protection magique', '2020-05-13 14:53:03'),
(368, 'EN', 'small magical protection', '2020-05-13 14:53:03'),
(369, 'FR', 'protection magique mineure', '2020-05-13 14:53:03'),
(369, 'EN', 'minor magical protection', '2020-05-13 14:53:03'),
(370, 'FR', 'protection magique correcte', '2020-05-13 14:53:04'),
(370, 'EN', 'proper magical protection', '2020-05-13 14:53:04'),
(371, 'FR', 'bonne protection magique', '2020-05-13 14:53:04'),
(371, 'EN', 'good magical protection', '2020-05-13 14:53:04'),
(372, 'FR', 'grande protection magique', '2020-05-13 14:53:04'),
(372, 'EN', 'great magical protection', '2020-05-13 14:53:04'),
(373, 'FR', 'protection magique grandiose', '2020-05-13 14:53:04'),
(373, 'EN', 'grand magical protection', '2020-05-13 14:53:04'),
(374, 'FR', 'IST', '2020-05-14 10:21:54'),
(374, 'EN', 'IST', '2020-05-14 10:21:54'),
(375, 'FR', 'Elfe', '2020-05-19 01:12:45'),
(375, 'EN', 'Elf', '2020-05-19 01:12:45'),
(376, 'FR', 'Nain', '2020-05-19 01:12:46'),
(376, 'EN', 'Dwarf', '2020-05-19 01:12:46'),
(377, 'FR', 'Orc', '2020-05-19 01:12:46'),
(377, 'EN', 'Orc', '2020-05-19 01:12:46'),
(378, 'FR', 'Humain', '2020-05-19 01:12:47'),
(378, 'EN', 'Human', '2020-05-19 01:12:47'),
(379, 'FR', 'Voleur', '2020-05-19 01:31:41'),
(379, 'EN', 'Thief', '2020-05-19 01:31:41'),
(380, 'FR', 'Mage', '2020-05-19 01:31:41'),
(380, 'EN', 'Mage', '2020-05-19 01:31:41'),
(381, 'FR', 'Guerrier', '2020-05-19 01:31:42'),
(381, 'EN', 'Warrior', '2020-05-19 01:31:44'),
(382, 'FR', 'Archer', '2020-05-19 01:31:45'),
(382, 'EN', 'Archer', '2020-05-19 01:31:45'),
(383, 'FR', 'Civil', '2020-05-19 01:31:46'),
(383, 'EN', 'Civilian', '2020-05-19 01:31:46');

-- --------------------------------------------------------

--
-- Structure de la table `enchant_modifier`
--

CREATE TABLE `enchant_modifier` (
  `id_enchant` int(11) NOT NULL,
  `replacer` int(11) NOT NULL,
  `base` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `luck` float NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `enchant_modifier`
--

INSERT INTO `enchant_modifier` (`id_enchant`, `replacer`, `base`, `max`, `value`, `luck`, `type`) VALUES
(1, 1, 2, 8, -20, -0.5, 1),
(1, 2, 2, 5, 10, 0.2, 1),
(1, 3, 10, 50, 2, 0.04, 1),
(2, 1, 5, 10, 5, 0.3, 1),
(2, 2, 3, 5, 7, 0.2, 1),
(2, 3, 10, 50, 2, 0.04, 1),
(3, 1, 5, 10, 5, 0.3, 1),
(3, 2, 3, 5, 7, 0.2, 1),
(3, 3, 10, 50, 2, 0.04, 1),
(4, 1, 5, 10, 5, 0.3, 1),
(4, 2, 3, 5, 7, 0.2, 1),
(4, 3, 10, 50, 2, 0.04, 1),
(5, 1, 2, 5, 7, 0.4, 1),
(6, 1, 2, 5, 10, 0.4, 1),
(6, 2, 10, 50, 2, 0.04, 1),
(7, 1, 2, 5, 10, 0.4, 1),
(1, 1, 10, 100, 2, 0.02, 0),
(2, 1, 10, 100, 2, 0.02, 0),
(3, 1, 10, 100, 2, 0.02, 0),
(4, 1, 10, 100, 2, 0.02, 0),
(5, 1, 10, 100, 2, 0.02, 0),
(6, 1, 10, 100, 2, 0.02, 0),
(7, 1, 10, 100, 2, 0.02, 0),
(8, 1, 5, 15, 2, 0.2, 0),
(9, 1, 5, 15, 2, 0.2, 0),
(10, 1, 5, 15, 2, 0.2, 0),
(11, 1, 5, 15, 2, 0.2, 0),
(12, 1, 5, 15, 2, 0.2, 0),
(13, 1, 5, 15, 2, 0.2, 0),
(14, 1, 5, 15, 2, 0.2, 0),
(15, 1, 5, 15, 2, 0.2, 0),
(16, 1, 2, 5, 7, 0.4, 0),
(17, 1, 2, 5, 15, 0.4, 0),
(18, 1, 5, 20, 5, 0.2, 0),
(19, 1, 5, 20, 5, 0.2, 0),
(20, 1, 5, 20, 7, 0.1, 0),
(21, 1, 10, 100, 3, 0.02, 0),
(22, 1, 10, 100, 3, 0.02, 0),
(23, 1, 10, 100, 3, 0.02, 0),
(24, 1, 10, 100, 3, 0.02, 0),
(25, 1, 10, 100, 3, 0.02, 0),
(26, 1, 10, 100, 3, 0.02, 0),
(27, 1, 10, 100, 3, 0.02, 0),
(28, 1, 10, 100, 3, 0.02, 0),
(29, 1, 2, 5, 7, 0.4, 0),
(30, 1, 20, 100, 2, 0.04, 0),
(31, 1, 5, 20, 5, 0.1, 0),
(32, 1, 5, 20, 5, 0.1, 0),
(33, 1, 1, 3, 45, 0.5, 0);

-- --------------------------------------------------------

--
-- Structure de la table `enchant_other`
--

CREATE TABLE `enchant_other` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_description` int(11) NOT NULL,
  `base_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `enchant_other`
--

INSERT INTO `enchant_other` (`id`, `id_name`, `id_description`, `base_value`) VALUES
(1, 197, 198, 25),
(2, 199, 200, 25),
(3, 201, 202, 25),
(4, 203, 204, 25),
(5, 205, 206, 25),
(6, 207, 208, 25),
(7, 209, 210, 25),
(8, 211, 212, 35),
(9, 213, 214, 35),
(10, 215, 216, 35),
(11, 217, 218, 35),
(12, 219, 220, 35),
(13, 221, 222, 35),
(14, 223, 224, 35),
(15, 225, 226, 35),
(16, 227, 228, 40),
(17, 229, 230, 35),
(18, 231, 232, 25),
(19, 233, 234, 25),
(20, 235, 236, 25),
(21, 237, 238, 25),
(22, 239, 240, 25),
(23, 241, 242, 25),
(24, 243, 244, 25),
(25, 245, 246, 25),
(26, 247, 248, 25),
(27, 249, 250, 25),
(28, 251, 252, 25),
(29, 253, 254, 30),
(30, 255, 256, 25),
(31, 257, 258, 45),
(32, 259, 260, 45),
(33, 261, 262, 45);

-- --------------------------------------------------------

--
-- Structure de la table `enchant_weapon`
--

CREATE TABLE `enchant_weapon` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_description` int(11) NOT NULL,
  `base_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `enchant_weapon`
--

INSERT INTO `enchant_weapon` (`id`, `id_name`, `id_description`, `base_value`) VALUES
(1, 183, 184, 155),
(2, 185, 186, 30),
(3, 187, 188, 30),
(4, 189, 190, 30),
(5, 191, 192, 40),
(6, 193, 194, 30),
(7, 195, 196, 30);

-- --------------------------------------------------------

--
-- Structure de la table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `slot` varchar(255) NOT NULL,
  `weight` tinyint(1) NOT NULL,
  `armor` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `equipment`
--

INSERT INTO `equipment` (`id`, `id_name`, `slot`, `weight`, `armor`, `value`, `quality`) VALUES
(1, 1, '1H', 0, 1, 10, 1),
(2, 2, 'head', 0, 2, 14, 1),
(3, 9, 'body', 0, 3, 18, 1),
(4, 10, 'hands', 0, 1, 12, 1),
(5, 11, 'legs', 0, 2, 14, 1),
(6, 12, 'feet', 0, 1, 12, 1),
(7, 13, '1H', 0, 3, 25, 2),
(8, 14, 'head', 0, 4, 29, 2),
(9, 15, 'body', 0, 5, 33, 2),
(10, 16, 'hands', 0, 3, 27, 2),
(11, 17, 'legs', 0, 4, 29, 2),
(12, 18, 'feet', 0, 3, 27, 2),
(13, 19, '1H', 1, 5, 50, 3),
(14, 20, 'head', 1, 6, 54, 3),
(15, 21, 'body', 1, 7, 58, 3),
(16, 22, 'hands', 1, 5, 52, 3),
(17, 23, 'legs', 1, 6, 54, 3),
(18, 24, 'feet', 1, 5, 52, 3),
(19, 25, '1H', 0, 7, 75, 4),
(20, 26, 'head', 0, 8, 79, 4),
(21, 27, 'body', 0, 9, 83, 4),
(22, 28, 'hands', 0, 7, 77, 4),
(23, 29, 'legs', 0, 8, 79, 4),
(24, 30, 'feet', 0, 7, 77, 4),
(25, 31, '1H', 1, 9, 80, 5),
(26, 32, 'head', 1, 10, 84, 5),
(27, 33, 'body', 1, 11, 88, 5),
(28, 34, 'hands', 1, 9, 82, 5),
(29, 35, 'legs', 1, 10, 84, 5),
(30, 36, 'feet', 1, 9, 82, 5),
(31, 37, '1H', 0, 11, 115, 6),
(32, 38, 'head', 0, 12, 119, 6),
(33, 39, 'body', 0, 13, 123, 6),
(34, 40, 'hands', 0, 11, 117, 6),
(35, 41, 'legs', 0, 12, 119, 6),
(36, 42, 'feet', 0, 11, 117, 6),
(37, 43, '1H', 1, 13, 120, 6),
(38, 44, 'head', 1, 14, 124, 6),
(39, 45, 'body', 1, 15, 128, 6),
(40, 46, 'hands', 1, 13, 122, 6),
(41, 47, 'legs', 1, 14, 124, 6),
(42, 48, 'feet', 1, 13, 122, 6),
(43, 49, '1H', 0, 15, 175, 7),
(44, 50, 'head', 0, 16, 179, 7),
(45, 51, 'body', 0, 17, 183, 7),
(46, 52, 'hands', 0, 15, 177, 7),
(47, 53, 'legs', 0, 16, 179, 7),
(48, 54, 'feet', 0, 15, 177, 7),
(49, 55, '1H', 1, 17, 180, 7),
(50, 56, 'head', 1, 18, 184, 7),
(51, 57, 'body', 1, 19, 188, 7),
(52, 58, 'hands', 1, 17, 182, 7),
(53, 59, 'legs', 1, 18, 184, 7),
(54, 60, 'feet', 1, 17, 182, 7);

-- --------------------------------------------------------

--
-- Structure de la table `jewelry`
--

CREATE TABLE `jewelry` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `slot` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `jewelry`
--

INSERT INTO `jewelry` (`id`, `id_name`, `slot`, `value`, `quality`) VALUES
(1, 5, 'ring', 95, 7),
(2, 6, 'necklace', 95, 7),
(3, 171, 'ring', 80, 6),
(4, 172, 'ring', 70, 5),
(5, 173, 'ring', 60, 4),
(6, 174, 'ring', 50, 3),
(7, 175, 'ring', 40, 2),
(8, 176, 'ring', 30, 1),
(9, 177, 'necklace', 80, 6),
(10, 178, 'necklace', 70, 5),
(11, 179, 'necklace', 60, 4),
(12, 180, 'necklace', 50, 3),
(13, 181, 'necklace', 40, 2),
(14, 182, 'necklace', 30, 1);

-- --------------------------------------------------------

--
-- Structure de la table `linknotificationuser`
--

CREATE TABLE `linknotificationuser` (
  `id_notification` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_release` datetime NOT NULL,
  `id_content` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE `permission` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `application` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `permission`
--

INSERT INTO `permission` (`id`, `role_name`, `application`, `action`) VALUES
(1, 'guest', 'error', 'error'),
(3, 'guest', 'generator', 'chest'),
(4, 'guest', 'generator', 'validate_chest'),
(5, 'guest', 'user', 'login'),
(6, 'guest', 'user', 'validate_login'),
(7, 'guest', 'user', 'register'),
(8, 'guest', 'user', 'validate_register'),
(9, 'member', 'error', 'error'),
(10, 'member', 'user', 'logout'),
(11, 'member', 'home', 'hub'),
(12, 'member', 'generator', 'chest'),
(13, 'member', 'generator', 'validate_chest'),
(14, 'member', 'home', 'creation_character'),
(15, 'member', 'generator', 'character'),
(16, 'member', 'home', 'validate_creation_character'),
(17, 'member', 'home', 'play_character'),
(18, 'member', 'file', 'get');

-- --------------------------------------------------------

--
-- Structure de la table `rpg_attributes`
--

CREATE TABLE `rpg_attributes` (
  `id` int(11) NOT NULL,
  `str` int(11) NOT NULL,
  `dex` int(11) NOT NULL,
  `con` int(11) NOT NULL,
  `int_` int(11) NOT NULL,
  `cha` int(11) NOT NULL,
  `agi` int(11) NOT NULL,
  `mag` int(11) NOT NULL,
  `acu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rpg_attributes`
--

INSERT INTO `rpg_attributes` (`id`, `str`, `dex`, `con`, `int_`, `cha`, `agi`, `mag`, `acu`) VALUES
(1, 20, 35, 30, 70, 50, 75, 70, 50),
(2, 80, 75, 75, 20, 50, 20, 30, 50),
(3, 70, 50, 80, 50, 20, 30, 50, 50),
(4, 50, 70, 40, 40, 80, 50, 40, 30),
(5, -5, 8, -5, 5, -10, 8, 0, 7),
(6, -8, 0, 1, 8, 2, -1, 6, 0),
(7, 10, 5, 8, -6, 0, -6, -6, 3),
(8, 5, 8, -5, -7, 0, 7, -7, 7),
(9, 0, 7, -7, 2, 10, -2, -2, 0),
(142, 12, 35, 41, 78, 52, 74, 76, 50),
(143, 12, 35, 41, 78, 52, 74, 76, 50),
(194, 50, 77, 43, 42, 90, 48, 38, 30),
(195, 50, 77, 43, 42, 90, 48, 38, 30);

-- --------------------------------------------------------

--
-- Structure de la table `rpg_character`
--

CREATE TABLE `rpg_character` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_race` int(11) NOT NULL,
  `id_class` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `mana` int(11) NOT NULL,
  `max_mana` int(11) NOT NULL,
  `ap` int(11) NOT NULL,
  `max_ap` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `id_inventory` int(11) NOT NULL,
  `id_attributes` int(11) NOT NULL,
  `id_maxattributes` int(11) NOT NULL,
  `id_author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rpg_character`
--

INSERT INTO `rpg_character` (`id`, `name`, `id_race`, `id_class`, `hp`, `max_hp`, `mana`, `max_mana`, `ap`, `max_ap`, `level`, `xp`, `id_inventory`, `id_attributes`, `id_maxattributes`, `id_author`) VALUES
(1, 'Orlevent', 1, 2, 41, 41, 76, 76, 9, 9, 0, 0, 1, 142, 143, 9),
(2, 'Clara', 4, 5, 43, 43, 38, 38, 6, 6, 0, 0, 1, 194, 195, 9);

-- --------------------------------------------------------

--
-- Structure de la table `rpg_class`
--

CREATE TABLE `rpg_class` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_attributes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rpg_class`
--

INSERT INTO `rpg_class` (`id`, `id_name`, `id_attributes`) VALUES
(1, 379, 5),
(2, 380, 6),
(3, 381, 7),
(4, 382, 8),
(5, 383, 9);

-- --------------------------------------------------------

--
-- Structure de la table `rpg_inventory`
--

CREATE TABLE `rpg_inventory` (
  `id_inventory` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `rpg_race`
--

CREATE TABLE `rpg_race` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_attributes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `rpg_race`
--

INSERT INTO `rpg_race` (`id`, `id_name`, `id_attributes`) VALUES
(1, 375, 1),
(2, 376, 2),
(3, 377, 3),
(4, 378, 4);

-- --------------------------------------------------------

--
-- Structure de la table `spellbook`
--

CREATE TABLE `spellbook` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_element` int(11) NOT NULL,
  `damage` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `base_range` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `spellbook`
--

INSERT INTO `spellbook` (`id`, `id_name`, `id_element`, `damage`, `cost`, `base_range`, `area`, `value`, `quality`) VALUES
(1, 301, 293, 5, 5, 5, 2, 25, 1),
(2, 302, 294, 5, 5, 5, 2, 25, 1),
(3, 303, 295, 5, 5, 5, 2, 25, 1),
(4, 304, 296, 5, 5, 5, 2, 25, 1),
(5, 305, 297, 5, 5, 5, 2, 25, 1),
(6, 306, 298, 5, 5, 5, 2, 25, 1),
(7, 307, 299, 5, 5, 5, 2, 25, 1),
(8, 308, 300, 5, 5, 5, 2, 25, 1),
(9, 309, 293, 10, 10, 5, 2, 45, 2),
(10, 310, 294, 10, 10, 5, 2, 45, 2),
(11, 311, 295, 10, 10, 5, 2, 45, 2),
(12, 312, 296, 10, 10, 5, 2, 45, 2),
(13, 313, 297, 10, 10, 5, 2, 45, 2),
(14, 314, 298, 10, 10, 5, 2, 45, 2),
(15, 315, 299, 10, 10, 5, 2, 45, 2),
(16, 316, 300, 10, 10, 5, 2, 45, 2),
(17, 317, 293, 18, 15, 5, 2, 65, 3),
(18, 318, 294, 18, 15, 5, 2, 65, 3),
(19, 319, 295, 18, 15, 5, 2, 65, 3),
(20, 320, 296, 18, 15, 5, 2, 65, 3),
(21, 321, 297, 18, 15, 5, 2, 65, 3),
(22, 322, 298, 18, 15, 5, 2, 65, 3),
(23, 323, 299, 18, 15, 5, 2, 65, 3),
(24, 324, 300, 18, 15, 5, 2, 65, 3),
(25, 325, 293, 31, 20, 5, 2, 85, 4),
(26, 326, 294, 31, 20, 5, 2, 85, 4),
(27, 327, 295, 31, 20, 5, 2, 85, 4),
(28, 328, 296, 31, 20, 5, 2, 85, 4),
(29, 329, 297, 31, 20, 5, 2, 85, 4),
(30, 330, 298, 31, 20, 5, 2, 85, 4),
(31, 331, 299, 31, 20, 5, 2, 85, 4),
(32, 332, 300, 31, 20, 5, 2, 85, 4),
(33, 333, 293, 45, 25, 5, 4, 120, 5),
(34, 334, 294, 45, 25, 5, 4, 120, 5),
(35, 335, 295, 45, 25, 5, 4, 120, 5),
(36, 336, 296, 45, 25, 5, 4, 120, 5),
(37, 337, 297, 45, 25, 5, 4, 120, 5),
(38, 338, 298, 45, 25, 5, 4, 120, 5),
(39, 339, 299, 45, 25, 5, 4, 120, 5),
(40, 340, 300, 45, 25, 5, 4, 120, 5),
(41, 341, 293, 65, 35, 10, 4, 150, 6),
(42, 342, 294, 65, 35, 10, 4, 150, 6),
(43, 343, 295, 65, 35, 10, 4, 150, 6),
(44, 344, 296, 65, 35, 10, 4, 150, 6),
(45, 345, 297, 65, 35, 10, 4, 150, 6),
(46, 346, 298, 65, 35, 10, 4, 150, 6),
(47, 347, 299, 65, 35, 10, 4, 150, 6),
(48, 348, 300, 65, 35, 10, 4, 150, 6),
(49, 349, 293, 95, 45, 10, 6, 200, 7),
(50, 350, 294, 95, 45, 10, 6, 200, 7),
(51, 351, 295, 95, 45, 10, 6, 200, 7),
(52, 352, 296, 95, 45, 10, 6, 200, 7),
(53, 353, 297, 95, 45, 10, 6, 200, 7),
(54, 354, 298, 95, 45, 10, 6, 200, 7),
(55, 355, 299, 95, 45, 10, 6, 200, 7),
(56, 356, 300, 95, 45, 10, 6, 200, 7),
(57, 357, 296, 10, 10, 3, 1, 90, 4),
(58, 358, 293, 10, 10, 3, 1, 90, 4),
(59, 359, 294, 15, 15, 4, 1, 130, 5),
(60, 360, 297, 15, 15, 4, 1, 130, 5),
(61, 361, 295, 20, 20, 5, 1, 170, 6),
(62, 362, 300, 20, 20, 5, 1, 170, 6),
(63, 363, 298, 30, 25, 6, 1, 230, 7),
(64, 364, 299, 30, 25, 6, 1, 230, 7),
(65, 365, 298, 2, 30, 1, 1, 120, 5),
(66, 366, 298, 5, 40, 1, 1, 150, 6),
(67, 367, 298, 10, 60, 1, 1, 200, 7),
(68, 368, 299, 15, 5, 1, 1, 45, 2),
(69, 369, 299, 30, 10, 2, 2, 65, 3),
(70, 370, 299, 50, 15, 3, 3, 85, 4),
(71, 371, 299, 75, 20, 3, 3, 105, 5),
(72, 372, 299, 105, 30, 4, 4, 125, 6),
(73, 373, 299, 150, 50, 5, 5, 175, 7);

-- --------------------------------------------------------

--
-- Structure de la table `stored_enchantment`
--

CREATE TABLE `stored_enchantment` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_description` int(11) NOT NULL,
  `id_dynamic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `stored_item`
--

CREATE TABLE `stored_item` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `id_dynamic` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `id_enchantment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `stored_modifier`
--

CREATE TABLE `stored_modifier` (
  `id_enchant` int(11) NOT NULL,
  `replacer` int(11) NOT NULL,
  `upgrade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `password_hashed` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL,
  `role_name` varchar(255) DEFAULT NULL,
  `date_registration` datetime NOT NULL,
  `date_login` datetime NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nickname`, `password_hashed`, `avatar`, `role_name`, `date_registration`, `date_login`, `banned`, `email`) VALUES
(1, 'guest', '$2y$06$kpHc9c/j9mseVAI/XgUNg.9uwuMAE1ra9v4oatz2Z0xtV54HYD/1e', 'default.png', 'guest', '2000-01-01 00:00:00', '2020-05-21 16:54:57', 0, ''),
(9, 'gugus2000', '$2y$06$WO6KRLkLrW7nnfJ2M9qVW.IN1Wa0hRm8olSgju8OAWq6edAL0i/xC', 'default.png', 'member', '2020-05-14 08:19:47', '2020-05-21 17:03:43', 0, 'gugus2000@protonmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `weapon`
--

CREATE TABLE `weapon` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `attack_type` varchar(255) NOT NULL,
  `slot` varchar(255) NOT NULL,
  `damage` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `quality` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `weapon`
--

INSERT INTO `weapon` (`id`, `id_name`, `attack_type`, `slot`, `damage`, `value`, `quality`) VALUES
(1, 3, 'HTH', '1H', 6, 12, 1),
(2, 4, 'HTH', '1H', 8, 16, 1),
(3, 61, 'HTH', '2H', 10, 22, 1),
(4, 62, 'HTH', '2H', 12, 26, 1),
(5, 63, 'D', '2H', 8, 17, 1),
(6, 64, 'D', '1H', 4, 14, 1),
(7, 65, 'D', '2H', 12, 25, 1),
(8, 66, 'M', '1H', 6, 7, 1),
(9, 67, 'M', '1H', 6, 7, 1),
(10, 68, 'M', '1H', 6, 7, 1),
(11, 69, 'M', '1H', 6, 7, 1),
(12, 70, 'M', '1H', 6, 7, 1),
(13, 71, 'M', '1H', 6, 7, 1),
(14, 72, 'M', '1H', 6, 7, 1),
(15, 73, 'M', '2H', 6, 50, 1),
(16, 74, 'M', '1H', 6, 16, 1),
(17, 75, 'HTH', '1H', 12, 27, 2),
(18, 76, 'HTH', '1H', 14, 31, 2),
(19, 77, 'HTH', '2H', 16, 37, 2),
(20, 78, 'HTH', '2H', 18, 41, 2),
(21, 79, 'D', '2H', 14, 32, 2),
(22, 80, 'D', '1H', 8, 29, 2),
(23, 81, 'D', '2H', 18, 40, 2),
(24, 82, 'M', '1H', 12, 12, 2),
(25, 83, 'M', '1H', 12, 12, 2),
(26, 84, 'M', '1H', 12, 12, 2),
(27, 85, 'M', '1H', 12, 12, 2),
(28, 86, 'M', '1H', 12, 12, 2),
(29, 87, 'M', '1H', 12, 12, 2),
(30, 88, 'M', '1H', 12, 12, 2),
(31, 89, 'M', '2H', 12, 65, 2),
(32, 90, 'M', '1H', 12, 31, 2),
(33, 91, 'HTH', '1H', 22, 52, 3),
(34, 92, 'HTH', '1H', 24, 56, 3),
(35, 93, 'HTH', '2H', 26, 62, 3),
(36, 94, 'HTH', '2H', 28, 66, 3),
(37, 95, 'D', '2H', 24, 57, 3),
(38, 96, 'D', '1H', 15, 54, 3),
(39, 97, 'D', '2H', 28, 65, 3),
(40, 98, 'M', '1H', 22, 27, 3),
(41, 99, 'M', '1H', 22, 27, 3),
(42, 100, 'M', '1H', 22, 27, 3),
(43, 101, 'M', '1H', 22, 27, 3),
(44, 102, 'M', '1H', 22, 27, 3),
(45, 103, 'M', '1H', 22, 27, 3),
(46, 104, 'M', '1H', 22, 27, 3),
(47, 105, 'M', '2H', 22, 90, 3),
(48, 106, 'M', '1H', 22, 56, 3),
(49, 107, 'HTH', '1H', 32, 77, 4),
(50, 108, 'HTH', '1H', 34, 81, 4),
(51, 109, 'HTH', '2H', 36, 87, 4),
(52, 110, 'HTH', '2H', 38, 91, 4),
(53, 111, 'D', '2H', 34, 82, 4),
(54, 112, 'D', '1H', 22, 82, 4),
(55, 113, 'D', '2H', 38, 90, 4),
(56, 114, 'M', '1H', 32, 42, 4),
(57, 115, 'M', '1H', 32, 42, 4),
(58, 116, 'M', '1H', 32, 42, 4),
(59, 117, 'M', '1H', 32, 42, 4),
(60, 118, 'M', '1H', 32, 42, 4),
(61, 119, 'M', '1H', 32, 42, 4),
(62, 120, 'M', '1H', 32, 42, 4),
(63, 121, 'M', '2H', 32, 115, 4),
(64, 122, 'M', '1H', 32, 81, 4),
(65, 123, 'HTH', '1H', 46, 112, 5),
(66, 124, 'HTH', '1H', 48, 116, 5),
(67, 125, 'HTH', '2H', 50, 122, 5),
(68, 126, 'HTH', '2H', 52, 126, 5),
(69, 127, 'D', '2H', 48, 117, 5),
(70, 128, 'D', '1H', 32, 114, 5),
(71, 129, 'D', '2H', 52, 125, 5),
(72, 130, 'M', '1H', 46, 77, 5),
(73, 131, 'M', '1H', 46, 77, 5),
(74, 132, 'M', '1H', 46, 77, 5),
(75, 133, 'M', '1H', 46, 77, 5),
(76, 134, 'M', '1H', 46, 77, 5),
(77, 135, 'M', '1H', 46, 77, 5),
(78, 136, 'M', '1H', 46, 77, 5),
(79, 137, 'M', '2H', 46, 150, 5),
(80, 138, 'M', '1H', 46, 116, 5),
(81, 139, 'HTH', '1H', 66, 147, 6),
(82, 140, 'HTH', '1H', 68, 151, 6),
(83, 141, 'HTH', '2H', 70, 157, 6),
(84, 142, 'HTH', '2H', 72, 161, 6),
(85, 143, 'D', '2H', 68, 152, 6),
(86, 144, 'D', '1H', 47, 149, 6),
(87, 145, 'D', '2H', 72, 160, 5),
(88, 146, 'M', '1H', 66, 112, 6),
(89, 147, 'M', '1H', 66, 112, 6),
(90, 148, 'M', '1H', 66, 112, 6),
(91, 149, 'M', '1H', 66, 112, 6),
(92, 150, 'M', '1H', 66, 112, 6),
(93, 151, 'M', '1H', 66, 112, 6),
(94, 152, 'M', '1H', 66, 112, 6),
(95, 153, 'M', '2H', 66, 185, 6),
(96, 154, 'M', '1H', 66, 151, 6),
(97, 155, 'HTH', '1H', 96, 202, 7),
(98, 156, 'HTH', '1H', 98, 206, 7),
(99, 157, 'HTH', '2H', 100, 212, 7),
(100, 158, 'HTH', '2H', 102, 216, 7),
(101, 159, 'D', '2H', 98, 207, 7),
(102, 160, 'D', '1H', 67, 204, 7),
(103, 161, 'D', '2H', 102, 215, 7),
(104, 162, 'M', '1H', 96, 147, 7),
(105, 163, 'M', '1H', 96, 147, 7),
(106, 164, 'M', '1H', 96, 147, 7),
(107, 165, 'M', '1H', 96, 147, 7),
(108, 166, 'M', '1H', 96, 147, 7),
(109, 167, 'M', '1H', 96, 147, 7),
(110, 168, 'M', '1H', 96, 147, 7),
(111, 169, 'M', '2H', 96, 240, 7),
(112, 170, 'M', '1H', 96, 206, 7);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `configuration`
--
ALTER TABLE `configuration`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consumable`
--
ALTER TABLE `consumable`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enchant_other`
--
ALTER TABLE `enchant_other`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `enchant_weapon`
--
ALTER TABLE `enchant_weapon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jewelry`
--
ALTER TABLE `jewelry`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rpg_attributes`
--
ALTER TABLE `rpg_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rpg_character`
--
ALTER TABLE `rpg_character`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rpg_class`
--
ALTER TABLE `rpg_class`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rpg_race`
--
ALTER TABLE `rpg_race`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `spellbook`
--
ALTER TABLE `spellbook`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stored_enchantment`
--
ALTER TABLE `stored_enchantment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stored_item`
--
ALTER TABLE `stored_item`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `weapon`
--
ALTER TABLE `weapon`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `configuration`
--
ALTER TABLE `configuration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `consumable`
--
ALTER TABLE `consumable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT pour la table `enchant_other`
--
ALTER TABLE `enchant_other`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `enchant_weapon`
--
ALTER TABLE `enchant_weapon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `jewelry`
--
ALTER TABLE `jewelry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `rpg_attributes`
--
ALTER TABLE `rpg_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT pour la table `rpg_character`
--
ALTER TABLE `rpg_character`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `rpg_class`
--
ALTER TABLE `rpg_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `rpg_race`
--
ALTER TABLE `rpg_race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `spellbook`
--
ALTER TABLE `spellbook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT pour la table `stored_enchantment`
--
ALTER TABLE `stored_enchantment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stored_item`
--
ALTER TABLE `stored_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `weapon`
--
ALTER TABLE `weapon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
