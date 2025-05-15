-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 15 mai 2025 à 23:28
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
-- Base de données : `enfant_debout`
--

-- --------------------------------------------------------

--
-- Structure de la table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `activities`
--

INSERT INTO `activities` (`id`, `title`, `description`, `image`, `date`) VALUES
(18, 'La Santé au cœur de la mission d’Enfant Debout', 'Chez Enfant Debout, la santé des enfants et des femmes est une priorité essentielle. Nous savons que sans un accès adéquat aux soins de santé, il est impossible pour ces populations vulnérables de s’épanouir pleinement et de construire un avenir meilleur.\r\n\r\nNotre ONG s’engage à lutter contre les maladies infantiles courantes, à promouvoir la vaccination, et à sensibiliser les familles aux bonnes pratiques d’hygiène et de nutrition. Nous travaillons aussi pour faciliter l’accès aux soins médicaux de qualité, notamment dans les zones rurales et les quartiers défavorisés.\r\n\r\nGrâce à des campagnes de dépistage, des cliniques mobiles, et des ateliers d’éducation sanitaire, Enfant Debout accompagne les communautés afin de renforcer la résilience face aux défis sanitaires. Nous croyons qu’en investissant dans la santé, nous offrons aux enfants et aux femmes les meilleures chances pour grandir en sécurité, en bonne santé, et avec dignité.\r\n\r\nEnsemble, construisons un avenir où chaque enfant peut se lever debout, fort et en bonne santé.', '682658792eb91_postSante1.jpg', '2025-05-15'),
(19, 'L’Éducation : un pilier fondamental chez Enfant Debout', 'Chez Enfant Debout, nous croyons fermement que l’éducation est la clé pour briser le cycle de la pauvreté et offrir un avenir meilleur à chaque enfant. C’est pourquoi nous faisons de l’accès à une éducation de qualité l’un de nos engagements prioritaires.\r\n\r\nNous intervenons dans les milieux où l’accès à l’école reste un défi, en soutenant la scolarisation des enfants défavorisés, en fournissant des fournitures scolaires, et en accompagnant les familles dans la prise de conscience de l’importance de l’instruction. En parallèle, nous menons des programmes de rattrapage scolaire et de soutien pédagogique pour que aucun enfant ne soit laissé de côté.\r\n\r\nEnfant Debout, c’est aussi un combat pour l’éducation des filles, trop souvent privées de leur droit à apprendre. Nous travaillons avec les communautés pour promouvoir l’égalité des chances et créer un environnement favorable à l’épanouissement de tous les enfants, sans distinction.\r\n\r\nParce qu’un enfant éduqué est un enfant debout, capable de rêver, de construire et d’agir.', '68265918af400_hero2.jpg', '2025-05-15');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'salanyiayaya@gmail.com', '$2y$10$YG3hySE.VWMuKinp3SEhvOUJZuSTlGJ0F5IPcf2ru1WyVSyGYC75C');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
