-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 16 oct. 2023 à 00:34
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vie_store`
--

-- --------------------------------------------------------

--
-- Structure de la table `all_products`
--

CREATE TABLE `all_products` (
  `id` int(11) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `add_to_cart` varchar(10) NOT NULL,
  `link` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `all_products`
--

INSERT INTO `all_products` (`id`, `nom`, `price`, `add_to_cart`, `link`, `image`) VALUES
(20, 'Stretch Washed Chino', 99, '', '', 'src/images/products/PANT_DRESS-PANT_BWB00289SBLZ91_3_category.jpg'),
(24, 'new product', 200, '', '', 'src/images/products/PANT_DRESS-PANT_BWB00288SBK389_3_category.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

CREATE TABLE `images` (
  `img_src` varchar(500) NOT NULL,
  `link_to_page` varchar(500) NOT NULL,
  `Name_image` varchar(250) NOT NULL,
  `price` int(11) NOT NULL,
  `categorie` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`img_src`, `link_to_page`, `Name_image`, `price`, `categorie`) VALUES
('../src/images/admin/user_image.png', '#user_image', 'user_image', 0, 'user_image'),
('src/images/Home_page_slide/slide1.png', 'men_with_brown_custom_and_black_face', '/src/images/Home_page_slide/slide1.png', 0, 'slider'),
('src/images/Home_page_slide/HP-Banner-Wedding-Desktop.png', 'best_custom_with_green_background', '/src/images/Home_page_slide/HP-Banner-Wedding-Desktop.png', 0, 'slider'),
('src/images/Home_page_slide/StoresLikeBonobos_CoverImage.jpg', 'stores_like_bonobos_coverimage', '/src/images/Home_page_slide/StoresLikeBonobos_CoverImage.jpg', 0, 'slider'),
('src/images/Home_page_slide/HP_Hero_Desktop_BGOnly.avif', 'my_image', '/src/images/Home_page_slide/HP_Hero_Desktop_BGOnly.avif', 0, 'slider');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `Name` varchar(300) NOT NULL,
  `phone` int(11) NOT NULL,
  `Quantite` varchar(50) DEFAULT NULL,
  `Order_date` varchar(15) DEFAULT NULL,
  `ville` varchar(200) DEFAULT NULL,
  `Total` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`Name`, `phone`, `Quantite`, `Order_date`, `ville`, `Total`, `Status`, `product_id`, `order_id`) VALUES
('rachid', 673843377, '2', '10/15/2023', 'tifelt', 400, 'valider', 24, 319498),
('fatima', 2147483647, '2', '10/15/2023', 'khribga', 400, 'annuler', 24, 993995),
('rafie anas', 641399364, '2', '10/15/2023', 'sale', 198, 'en attente', 20, 270148),
('rafie anas', 641399364, '2', '10/15/2023', 'sale', 198, 'valider', 20, 562788),
('Taha bsd', 2147483647, '3', '10/15/2023', 'Tifelt', 297, 'en attente', 20, 830225);

-- --------------------------------------------------------

--
-- Structure de la table `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `user_admin`
--

INSERT INTO `user_admin` (`id`, `username`, `password`, `user_id`) VALUES
(2, 'yassine', '1234', 1013257),
(4, 'anas', '2005', 9540460),
(5, 'rashid', '1997', 666360);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `all_products`
--
ALTER TABLE `all_products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `all_products`
--
ALTER TABLE `all_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
