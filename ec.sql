-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 10:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ec`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `Id_compte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `Id_compte`) VALUES
(2, 'mohamed', 2);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ID_client` int(100) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `adresse` varchar(30) NOT NULL,
  `num_tel` int(10) NOT NULL,
  `date_naiss` varchar(20) NOT NULL,
  `sexe` varchar(20) NOT NULL,
  `Id_compte` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ID_client`, `nom`, `prenom`, `adresse`, `num_tel`, `date_naiss`, `sexe`, `Id_compte`) VALUES
(3, 'adb', 'sdadf', '02safa', 555622552, '02255', '1', 13);

-- --------------------------------------------------------

--
-- Table structure for table `commande_client`
--

CREATE TABLE `commande_client` (
  `id_commande` int(11) NOT NULL,
  `prix` int(255) NOT NULL,
  `date_com` date NOT NULL,
  `etat_commande` varchar(50) NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_pannier` int(11) NOT NULL,
  `id_livreur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande_client`
--

INSERT INTO `commande_client` (`id_commande`, `prix`, `date_com`, `etat_commande`, `id_client`, `id_pannier`, `id_livreur`) VALUES
(97, 5, '2024-05-18', 'livred', 3, 4, 1),
(98, 15, '2024-05-19', 'livred', 3, 4, 1),
(99, 220, '2024-05-19', 'refuse', 3, 4, NULL),
(100, 1090, '2024-05-19', 'v', 3, 4, NULL),
(101, 690, '2024-05-20', 'retour', 3, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL,
  `mot_de_passe` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `etat_compte` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `compte`
--

INSERT INTO `compte` (`id_compte`, `mot_de_passe`, `email`, `etat_compte`) VALUES
(2, '1', 'ad@a', 'active'),
(6, '00', 'abdoddubenh3@gmail.co', 'active'),
(7, '0', 'abdoubenh73@gmail.co', 'active'),
(13, '11', 'abdnh7ddddddd3@gmail.com', 'active'),
(15, '[value-2]', '[value-3]', '[value-4]'),
(16, '', 'abdoddubenh3@gmail.co', 'active'),
(17, '0', 'abdoubenh73@gmail.co', 'active'),
(18, '0', 'abdoubenh73@gmail.co', 'active'),
(19, '0', 'abdoubenh73@gmail.coccc', 'active'),
(20, '0', 'abdoubenh73@gmail.coccc', 'active'),
(21, '', 'abdoddubenh3@gmail.co', 'active'),
(22, '', 'abdoddubenh3@gmail.co', 'active'),
(23, '', 'abdoddubenh3@gmail.co', 'active'),
(24, '', 'abdoddubenh3@gmail.co', 'active'),
(25, '00', 'abdoddubenh73@gmail.co', 'active'),
(26, '00', 'abdoddubenh73@gmail.co', 'active'),
(27, '0', 'abdoubenh73@gmail.coccc', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `contient`
--

CREATE TABLE `contient` (
  `code_p` int(11) NOT NULL,
  `num_cmd` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contient`
--

INSERT INTO `contient` (`code_p`, `num_cmd`, `quantite`) VALUES
(1, 97, 1),
(1, 98, 1),
(1, 100, 1),
(1, 101, 1),
(2, 97, 1),
(2, 98, 1),
(2, 101, 1),
(3, 98, 1),
(3, 100, 1),
(4, 97, 1),
(4, 99, 5),
(5, 97, 1);

-- --------------------------------------------------------

--
-- Table structure for table `demande_livreur`
--

CREATE TABLE `demande_livreur` (
  `Id_demande_livreur` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `num_comptB` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` char(1) DEFAULT NULL,
  `type_vehicule` varchar(50) DEFAULT NULL,
  `type_contra` varchar(50) DEFAULT NULL,
  `etat_demande` varchar(50) DEFAULT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demande_livreur`
--

INSERT INTO `demande_livreur` (`Id_demande_livreur`, `nom`, `email`, `num_tel`, `num_comptB`, `prenom`, `sexe`, `type_vehicule`, `type_contra`, `etat_demande`, `password`) VALUES
(1, '', 'abdoddubenh3@gmail.co', '00', 'dsa', 'dfdf', 'm', 'njkk', 'mcmc', 'rejected', ''),
(2, 'fff', 'abdoddubenh73@gmail.co', '00', 'dsa', 'dfdf', 'm', 'njkk', 'mcmc', 'accepted', '00');

-- --------------------------------------------------------

--
-- Table structure for table `demande_magasin`
--

CREATE TABLE `demande_magasin` (
  `Id_demande_magasin` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `num_compB` varchar(50) DEFAULT NULL,
  `type_mag` varchar(100) DEFAULT NULL,
  `num_Reg` varchar(50) DEFAULT NULL,
  `etat_demande` varchar(50) DEFAULT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `nom_R_mag` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demande_magasin`
--

INSERT INTO `demande_magasin` (`Id_demande_magasin`, `nom`, `email`, `mot_de_passe`, `num_tel`, `num_compB`, `type_mag`, `num_Reg`, `etat_demande`, `localisation`, `nom_R_mag`) VALUES
(1, 'admin', 'abdoubenh73@gmail.coccc', '0', '0555622552', '0025', 'jkksd', '0223', 'rejected', 'afd', 'ABDERRAHMANEBENCHAB');

-- --------------------------------------------------------

--
-- Table structure for table `evaleur_client_livreur`
--

CREATE TABLE `evaleur_client_livreur` (
  `id_client` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaleur_mag_livreur`
--

CREATE TABLE `evaleur_mag_livreur` (
  `id_livreur` int(11) NOT NULL,
  `id_mag` int(11) NOT NULL,
  `note` int(11) DEFAULT NULL,
  `commentaire` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaleur_produit`
--

CREATE TABLE `evaleur_produit` (
  `id_client` int(255) NOT NULL,
  `code_p` int(255) NOT NULL,
  `note` int(255) NOT NULL,
  `fedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation`
--

CREATE TABLE `evaluation` (
  `id_evaluation` int(11) NOT NULL,
  `code_p` int(11) DEFAULT NULL,
  `id_client` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `date_eval` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laivreur`
--

CREATE TABLE `laivreur` (
  `Id_livreur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `type_vehicule` varchar(255) DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `type_contra` varchar(255) DEFAULT NULL,
  `num_compteB` varchar(255) DEFAULT NULL,
  `Id_compte` int(11) DEFAULT NULL,
  `Id_demande_livreur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laivreur`
--

INSERT INTO `laivreur` (`Id_livreur`, `nom`, `prenom`, `num_tel`, `type_vehicule`, `sexe`, `type_contra`, `num_compteB`, `Id_compte`, `Id_demande_livreur`) VALUES
(1, 'kkkk', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 6, 1),
(2, '', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 16, 1),
(3, '', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 21, 1),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(7, '', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 22, 1),
(8, '', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 23, 1),
(9, '', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 24, 1),
(10, 'fff', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 25, 2),
(11, 'fff', 'dfdf', '00', 'njkk', 'm', 'mcmc', 'dsa', 26, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ligne_panier`
--

CREATE TABLE `ligne_panier` (
  `id_ligne` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `id_panier` int(11) DEFAULT NULL,
  `code_p` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livreur`
--

CREATE TABLE `livreur` (
  `id_livreur` int(11) NOT NULL,
  `num_com` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `magasin`
--

CREATE TABLE `magasin` (
  `Id_mag` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `nom_R_mag` varchar(255) DEFAULT NULL,
  `type_mag` varchar(255) DEFAULT NULL,
  `num_tel` varchar(20) DEFAULT NULL,
  `num_Reg_mag` varchar(255) DEFAULT NULL,
  `num_comptB` varchar(255) DEFAULT NULL,
  `localisation` varchar(255) DEFAULT NULL,
  `image_01` varchar(255) NOT NULL,
  `Id_compte` int(11) DEFAULT NULL,
  `Id_demande_mag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magasin`
--

INSERT INTO `magasin` (`Id_mag`, `nom`, `adresse`, `nom_R_mag`, `type_mag`, `num_tel`, `num_Reg_mag`, `num_comptB`, `localisation`, `image_01`, `Id_compte`, `Id_demande_mag`) VALUES
(1, 'magasin ', 'kik', 'ABDERRAHMANEBENCHAB', 'p1', '0555622552', '0223', '0025', 'afd', '', 7, 1),
(5, '[value-2]', '4mila', '[value-4]', '[value-5]', '[value-6]', '[value-7]', '[value-8]', 'tri9 zghya', '', 15, 1),
(6, 'admin', NULL, 'ABDERRAHMANEBENCHAB', 'jkksd', '0555622552', '0223', '0025', 'afd', '', 17, 1),
(7, 'admin', NULL, 'ABDERRAHMANEBENCHAB', 'jkksd', '0555622552', '0223', '0025', 'afd', '', 18, 1),
(8, 'admin', NULL, 'ABDERRAHMANEBENCHAB', 'jkksd', '0555622552', '0223', '0025', 'afd', '', 19, 1),
(9, 'admin', NULL, 'ABDERRAHMANEBENCHAB', 'jkksd', '0555622552', '0223', '0025', 'afd', '', 20, 1),
(10, 'admin', NULL, 'ABDERRAHMANEBENCHAB', 'jkksd', '0555622552', '0223', '0025', 'afd', '', 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `magcom`
--

CREATE TABLE `magcom` (
  `num_command` int(11) NOT NULL,
  `id_magasin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `magcom`
--

INSERT INTO `magcom` (`num_command`, `id_magasin`) VALUES
(97, 1),
(97, 5),
(98, 1),
(99, 5),
(100, 1),
(101, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `ID_client` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `ID_client`, `name`, `email`, `number`, `message`) VALUES
(3, 3, 'sdadf ab', 'abdnh7ddddddd3@gmail.com', '02225555', 'kkkkkkkkkkkkkk');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `id_pannier` int(200) NOT NULL,
  `nbr_produit` int(200) NOT NULL,
  `montant_total` int(200) NOT NULL,
  `id_compte` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`id_pannier`, `nbr_produit`, `montant_total`, `id_compte`) VALUES
(4, 0, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `code_p` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `prix_u` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `quantite` int(20) NOT NULL,
  `marque` varchar(20) NOT NULL,
  `id_magasin` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`code_p`, `name`, `description`, `prix_u`, `image_01`, `image_02`, `image_03`, `type`, `quantite`, `marque`, `id_magasin`) VALUES
(1, 'p1', '0kjk', 646, 'home3.png', 'home2.jpg', 'icon-1.png', '', 0, '', 1),
(2, 'pp1', 'fda', 44, 'icon-4.png', 'icon-1.png', 'icon-4.png', '', 0, '', 1),
(3, 'phone', 'dsafafasdgfgw', 444, 'home-img-6.jpg', 'home-img-3.png', 'home-img-11.png', '', 0, '', 1),
(4, 'p2', '001', 44, 'home-img-2.png', 'icon-2.png', 'icon-5.png', '', 0, '', 5),
(5, 'pp2', 'dsafsdf', 2, 'home-img-6.jpg', 'home-img-6.jpg', 'home-img-11.png', '', 0, '', 5),
(6, 'ABDERRAHMANE BENCHABANE', 'jhbj', 25, 'home-img-6.jpg', 'home-img-11.png', 'home-img-11.png', 'kk', 7, 'kjo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `signal_problem`
--

CREATE TABLE `signal_problem` (
  `id_signal` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `id_commande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signal_problem`
--

INSERT INTO `signal_problem` (`id_signal`, `description`, `id_commande`) VALUES
(42, 'kkkkkkkmk', 101);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `ID_client` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admins_ibfk_1` (`Id_compte`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ID_client`),
  ADD KEY `client_ibfk_1` (`Id_compte`);

--
-- Indexes for table `commande_client`
--
ALTER TABLE `commande_client`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `commande_client_ibfk_1` (`id_client`),
  ADD KEY `commande_client_ibfk_2` (`id_pannier`),
  ADD KEY `commande_client_ibfk_3` (`id_livreur`);

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`);

--
-- Indexes for table `contient`
--
ALTER TABLE `contient`
  ADD PRIMARY KEY (`code_p`,`num_cmd`),
  ADD KEY `num_cmd` (`num_cmd`),
  ADD KEY `code_p` (`code_p`);

--
-- Indexes for table `demande_livreur`
--
ALTER TABLE `demande_livreur`
  ADD PRIMARY KEY (`Id_demande_livreur`);

--
-- Indexes for table `demande_magasin`
--
ALTER TABLE `demande_magasin`
  ADD PRIMARY KEY (`Id_demande_magasin`),
  ADD UNIQUE KEY `Id_demande_magasin` (`Id_demande_magasin`),
  ADD UNIQUE KEY `Id_demande_magasin_2` (`Id_demande_magasin`);

--
-- Indexes for table `evaleur_client_livreur`
--
ALTER TABLE `evaleur_client_livreur`
  ADD PRIMARY KEY (`id_client`,`id_livreur`),
  ADD KEY `id_client` (`id_client`,`id_livreur`),
  ADD KEY `id_livreur` (`id_livreur`);

--
-- Indexes for table `evaleur_mag_livreur`
--
ALTER TABLE `evaleur_mag_livreur`
  ADD PRIMARY KEY (`id_livreur`,`id_mag`),
  ADD UNIQUE KEY `id_livreur` (`id_livreur`,`id_mag`),
  ADD KEY `id_mag` (`id_mag`);

--
-- Indexes for table `evaleur_produit`
--
ALTER TABLE `evaleur_produit`
  ADD PRIMARY KEY (`id_client`,`code_p`),
  ADD KEY `code_p` (`code_p`);

--
-- Indexes for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id_evaluation`),
  ADD KEY `code_p` (`code_p`),
  ADD KEY `id_client` (`id_client`);

--
-- Indexes for table `laivreur`
--
ALTER TABLE `laivreur`
  ADD PRIMARY KEY (`Id_livreur`),
  ADD KEY `Id_compte` (`Id_compte`),
  ADD KEY `Id_demande_livreur` (`Id_demande_livreur`);

--
-- Indexes for table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  ADD PRIMARY KEY (`id_ligne`),
  ADD KEY `code_p` (`code_p`),
  ADD KEY `id_panier` (`id_panier`);

--
-- Indexes for table `livreur`
--
ALTER TABLE `livreur`
  ADD PRIMARY KEY (`id_livreur`);

--
-- Indexes for table `magasin`
--
ALTER TABLE `magasin`
  ADD PRIMARY KEY (`Id_mag`),
  ADD KEY `Id_compte` (`Id_compte`),
  ADD KEY `magasin_ibfk_2` (`Id_demande_mag`);

--
-- Indexes for table `magcom`
--
ALTER TABLE `magcom`
  ADD PRIMARY KEY (`num_command`,`id_magasin`),
  ADD KEY `num_command` (`num_command`,`id_magasin`),
  ADD KEY `id_magasin` (`id_magasin`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`ID_client`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_pannier`),
  ADD KEY `Id_compte` (`id_compte`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`code_p`),
  ADD KEY `id_magasin` (`id_magasin`);

--
-- Indexes for table `signal_problem`
--
ALTER TABLE `signal_problem`
  ADD PRIMARY KEY (`id_signal`),
  ADD KEY `signal_problem_ibfk_1` (`id_commande`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_client` (`ID_client`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ID_client` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `demande_livreur`
--
ALTER TABLE `demande_livreur`
  MODIFY `Id_demande_livreur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `demande_magasin`
--
ALTER TABLE `demande_magasin`
  MODIFY `Id_demande_magasin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id_evaluation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laivreur`
--
ALTER TABLE `laivreur`
  MODIFY `Id_livreur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  MODIFY `id_ligne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `magasin`
--
ALTER TABLE `magasin`
  MODIFY `Id_mag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_pannier` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `code_p` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `signal_problem`
--
ALTER TABLE `signal_problem`
  MODIFY `id_signal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`Id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`Id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `commande_client`
--
ALTER TABLE `commande_client`
  ADD CONSTRAINT `commande_client_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_client_ibfk_2` FOREIGN KEY (`id_pannier`) REFERENCES `panier` (`id_pannier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `commande_client_ibfk_3` FOREIGN KEY (`id_livreur`) REFERENCES `laivreur` (`Id_livreur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `contient`
--
ALTER TABLE `contient`
  ADD CONSTRAINT `contient_ibfk_1` FOREIGN KEY (`code_p`) REFERENCES `produit` (`code_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contient_ibfk_2` FOREIGN KEY (`num_cmd`) REFERENCES `commande_client` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaleur_client_livreur`
--
ALTER TABLE `evaleur_client_livreur`
  ADD CONSTRAINT `evaleur_client_livreur_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaleur_client_livreur_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `laivreur` (`Id_livreur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaleur_mag_livreur`
--
ALTER TABLE `evaleur_mag_livreur`
  ADD CONSTRAINT `evaleur_mag_livreur_ibfk_1` FOREIGN KEY (`id_livreur`) REFERENCES `laivreur` (`Id_livreur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaleur_mag_livreur_ibfk_2` FOREIGN KEY (`id_mag`) REFERENCES `magasin` (`Id_mag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaleur_produit`
--
ALTER TABLE `evaleur_produit`
  ADD CONSTRAINT `evaleur_produit_ibfk_1` FOREIGN KEY (`code_p`) REFERENCES `produit` (`code_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evaleur_produit_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluation`
--
ALTER TABLE `evaluation`
  ADD CONSTRAINT `evaluation_ibfk_1` FOREIGN KEY (`code_p`) REFERENCES `produit` (`code_p`),
  ADD CONSTRAINT `evaluation_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `client` (`ID_client`);

--
-- Constraints for table `laivreur`
--
ALTER TABLE `laivreur`
  ADD CONSTRAINT `laivreur_ibfk_1` FOREIGN KEY (`Id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laivreur_ibfk_2` FOREIGN KEY (`Id_demande_livreur`) REFERENCES `demande_livreur` (`Id_demande_livreur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  ADD CONSTRAINT `ligne_panier_ibfk_1` FOREIGN KEY (`code_p`) REFERENCES `produit` (`code_p`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ligne_panier_ibfk_2` FOREIGN KEY (`id_panier`) REFERENCES `panier` (`id_pannier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `magasin`
--
ALTER TABLE `magasin`
  ADD CONSTRAINT `magasin_ibfk_1` FOREIGN KEY (`Id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `magasin_ibfk_2` FOREIGN KEY (`Id_demande_mag`) REFERENCES `demande_magasin` (`Id_demande_magasin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `magcom`
--
ALTER TABLE `magcom`
  ADD CONSTRAINT `magcom_ibfk_1` FOREIGN KEY (`id_magasin`) REFERENCES `magasin` (`Id_mag`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `magcom_ibfk_2` FOREIGN KEY (`num_command`) REFERENCES `commande_client` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`ID_client`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`id_magasin`) REFERENCES `magasin` (`Id_mag`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `signal_problem`
--
ALTER TABLE `signal_problem`
  ADD CONSTRAINT `signal_problem_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande_client` (`id_commande`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`ID_client`) REFERENCES `client` (`ID_client`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
