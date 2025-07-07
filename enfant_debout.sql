-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 06 juil. 2025 à 15:05
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
(19, 'L’Éducation : un pilier fondamental chez Enfant Debout', 'Chez Enfant Debout, nous croyons fermement que l’éducation est la clé pour briser le cycle de la pauvreté et offrir un avenir meilleur à chaque enfant. C’est pourquoi nous faisons de l’accès à une éducation de qualité l’un de nos engagements prioritaires.\r\n\r\nNous intervenons dans les milieux où l’accès à l’école reste un défi, en soutenant la scolarisation des enfants défavorisés, en fournissant des fournitures scolaires, et en accompagnant les familles dans la prise de conscience de l’importance de l’instruction. En parallèle, nous menons des programmes de rattrapage scolaire et de soutien pédagogique pour que aucun enfant ne soit laissé de côté.\r\n\r\nEnfant Debout, c’est aussi un combat pour l’éducation des filles, trop souvent privées de leur droit à apprendre. Nous travaillons avec les communautés pour promouvoir l’égalité des chances et créer un environnement favorable à l’épanouissement de tous les enfants, sans distinction.\r\n\r\nParce qu’un enfant éduqué est un enfant debout, capable de rêver, de construire et d’agir.', '68265918af400_hero2.jpg', '2025-05-15'),
(20, 'Réflexion sur la Journée de l’Enfant Africain en RDC et au-delà', '16 juin 2025 Hommage aux enfants oubliés des guerres africaines \r\nÀ Goma, la terre tremble encore des pas des milices. À Bukavu, le lac Kivu emporte les larmes des mères disparues. En Ituri, les fosses communes sont devenues des terrains de jeu macabres. Partout en RDC, des enfants naissent, grandissent et meurent dans l’indifférence du monde.  \r\nQu’est-ce qu’un droit de l’enfant dans un pays où la loi est écrite par les kalachnikovs ? \r\nCes enfants-là ne connaissent ni la sécurité de l’école, ni la douceur d’un foyer. Leurs berceaux sont des camps de déplacés, leurs jouets, des douilles vides. Ils apprennent à compter les morts avant d’apprendre à lire.  \r\nPendant que certains pays africains célèbrent leur croissance économique, d’autres régions sombrent dans une violence qui dévore leur avenir :  \r\n-Nord-Kivu (RDC): 3,4 millions de déplacés, dont 60% d’enfants (ONU, 2024)  \r\n- Sahel (Mali, Burkina Faso) : 8.000 écoles fermées à cause du terrorismeSud-Soudan: 19.000 enfants-soldats recensés depuis 2013  \r\n\r\nCes chiffres ne sont pas des statistiques – ce sont des visages. Celui de Josué, 8 ans, forcé à porter un fusil plus lourd que lui. De Neema, 12 ans, violée devant sa famille. De Ali, 6 ans, qui mendie devant les hôtels climatisés de Goma.   \r\nCette tragédie pose une question brutale :  \r\nSommes-nous encore capables d’indignation quand la souffrance devient routine ?\r\nNous vivons dans un monde où :  \r\n- Un smartphone coûte plus cher que la scolarité annuelle de 50 enfants congolais  \r\n- Les minerais de nos batteries valent plus que la vie des petits creuseurs  \r\n- Les guerres se financent avec l’argent que l’humanité pourrait consacrer à sauver ses enfants  \r\nPourtant, au milieu de l’horreur, des phares persistent :  \r\n- Les Mamas Courage de Bunia qui cachent les enfants pendant les attaques  \r\n-Dr Denis Mukwege et son hôpital qui répare les filles brisées  \r\n-Les enseignants qui font classe sous des tentes bombardées  \r\nLeur combat prouve que même dans l’enfer, poussent des fleurs de dignité,\r\nEn cette Journée de l’Enfant Africain, faisons plus que pleurer engageons-nous :  \r\nBriser l’amnésie géographique : Ces enfants ne sont pas loin ils sont les nôtres.  \r\nBoycotter l’indifférence : Chaque produit contenant des minerais du sang rend complice.  \r\nExiger des comptes : Les bailleurs financent-ils vraiment les écoles ou les armes ?  \r\nÉcouter les survivants, Comme dit l’adage congolais :celui qui a traversé le fleuve ne ment pas sur la profondeur de l’eau.\r\n Leur Silence Nous Jugera  \r\nDemain, quand ces enfants grandiront, que leur dirons-nous ?  \r\n-Désolé, nous ne savions pas alors que les rapports s’empilent\r\n-Nous pensions que c’était compliqué alors que notre confort était simple\r\nUne civilisation se juge à la façon dont elle traite ses enfants (F. Douglass). En cette année 2025, l’Afrique  et le monde échouent à l’examen.  \r\nMais tant qu’un seul enfant résiste, l’espoir vit encore. \r\n\r\n???? Un enfant qui souffre en Afrique est une étoile qui s’éteint dans la voûte de l’humanité.  \r\n\r\nONG Enfant debout \r\n Une conscience africaine, le 16 juin 2025', '686804e191047_hq720.jpg', '2025-07-04'),
(21, 'Retour sur la célébration de la Journée de l’Enfant Africain 2025', 'Le 16 juin 2025 nous avons eu le plaisir de célébrer la Journée de l’Enfant Africain avec les écoliers de l EPA NDAHURA sous le thème « Le thème de la Journée de l\'Enfant Africain 2025 est \"Planification et budgétisation des droits de l\'enfant : Progrès depuis 2010.\" \r\nEn 2025, la Journée de l\'Enfant Africain, célébrée le 16 juin, se concentrera sur la planification et la budgétisation des droits de l\'enfant, en particulier en examinant les progrès accomplis depuis 2010. Ce thème souligne l\'importance de la planification et de la budgétisation pour garantir que les droits de l\'enfant soient respectés et que les enfants puissent bénéficier de leurs droits.》\r\n\r\nCette journée, pleine d’émotion, de partage et d’engagement, a rassemblé enfants, parents, éducateurs, partenaires et autorités autour d’un objectif commun : honorer les droits de l’enfant et rappeler l’importance d’un avenir juste, équitable et prometteur pour chaque enfant africain.\r\n\r\nAu programme :\r\n\r\n???? Discours inspirants de nos invités d’honneur\r\n\r\n Représentations artistiques et culturelles par les enfants\r\n\r\n Ateliers éducatifs sur les droits de l’enfant\r\nMoment de convivialité et de partage\r\nNous remercions chaleureusement tous les participants, ainsi que nos partenaires et sponsors pour leur soutien précieux. Leur engagement montre que, collectivement, nous pouvons créer un environnement favorable à l’épanouissement des enfants.\r\n\r\nLa Journée de l’Enfant Africain n’est pas qu’un événement annuel : c’est un appel à l’action permanente, à la protection, à l’éducation et à la valorisation de notre jeunesse.\r\n\r\nEnsemble, continuons à faire entendre la voix des enfants africains.\r\nRevivez la journée en images : [insérer images)', '686806a4b8afe_IMG-20250701-WA0006.jpg', '2025-07-04');

-- --------------------------------------------------------

--
-- Structure de la table `activity_images`
--

CREATE TABLE `activity_images` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'safalanyiayaya@gmail.com', '$2y$10$YG3hySE.VWMuKinp3SEhvOUJZuSTlGJ0F5IPcf2ru1WyVSyGYC75C');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `activity_images`
--
ALTER TABLE `activity_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `activity_images`
--
ALTER TABLE `activity_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activity_images`
--
ALTER TABLE `activity_images`
  ADD CONSTRAINT `activity_images_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
