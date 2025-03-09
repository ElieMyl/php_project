-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 09 mars 2025 à 22:14
-- Version du serveur : 8.0.35
-- Version de PHP : 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `project_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int NOT NULL,
  `libelle_categorie` varchar(50) NOT NULL,
  `description_categorie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `libelle_categorie`, `description_categorie`) VALUES
(1, 'Jeux', 'Plongez dans l’univers palpitant des jeux de casino, où le hasard et la stratégie s’entremêlent pour offrir une expérience unique. Que vous soyez un amateur de Blackjack, un adepte de la Roulette, ou un passionné des jeux de dés, cette catégorie regroupe les incontournables des casinos pour tester votre chance et vos compétences. Affrontez la maison, prenez des décisions stratégiques et vivez l’excitation du jeu à chaque tour !'),
(2, 'Machine à sous', 'Découvrez l’univers fascinant des machines à sous, où chaque spin peut vous réserver une surprise ! Des classiques à trois rouleaux aux slots modernes avec des fonctionnalités bonus innovantes, cette catégorie offre une grande variété de thèmes et de mécaniques de jeu. Plongez dans des univers captivants, déclenchez des free spins, des jackpots et des multiplicateurs, et laissez la chance faire le reste. Faites tourner les rouleaux et tentez de décrocher le gros lot ! 🎰✨');

-- --------------------------------------------------------

--
-- Structure de la table `historique_jeux`
--

CREATE TABLE `historique_jeux` (
  `id_historique` int NOT NULL,
  `montant_historique` varchar(50) NOT NULL,
  `date_historique` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_user_historique` int NOT NULL,
  `id_jeux_historique` int NOT NULL,
  `id_type_historique` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `historique_jeux`
--

INSERT INTO `historique_jeux` (`id_historique`, `montant_historique`, `date_historique`, `id_user_historique`, `id_jeux_historique`, `id_type_historique`) VALUES
(5, '100', '09-03-2025', 2, 1, 1),
(6, '100', '09-03-2025', 2, 1, 1),
(7, '150', '09-03-2025', 2, 1, 1),
(8, '870', '09-03-2025', 2, 1, 3),
(9, '870', '09-03-2025', 2, 1, 3),
(10, '870', '09-03-2025', 2, 1, 2),
(11, '200', '09-03-2025', 2, 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `jeux`
--

CREATE TABLE `jeux` (
  `id_jeux` int NOT NULL,
  `libelle_jeux` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_jeux` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_jeux` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien_jeux` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categorie` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `jeux`
--

INSERT INTO `jeux` (`id_jeux`, `libelle_jeux`, `description_jeux`, `image_jeux`, `lien_jeux`, `id_categorie`) VALUES
(1, 'Black Jack', 'Le Blackjack est un jeu de cartes où l’objectif est d’atteindre 21 sans le dépasser. Affrontez le croupier en décidant de tirer, rester, doubler ou séparer vos cartes. Stratégie et réflexion sont vos meilleurs atouts pour gagner. Prêt à battre la banque ?', '67c6022c59773_bj.png', 'www.zoom/bj/fasael-casion.com', 1),
(2, 'Roulette', 'Misez sur un numéro, une couleur ou une combinaison et regardez la bille tourner sur la roue. Avec chaque tour, la chance peut vous sourire et multiplier vos gains. Un jeu à la fois simple et excitant, où tout peut basculer en un instant !', '67c61c204a156_roulette.jpg', 'www.zoom/roulette/fasael-casion.com', 1),
(3, 'Le Bandit', 'Le Bandit Manchot, ou machine à sous classique, est un jeu de pur hasard. Appuyez sur un bouton, laissez les rouleaux tourner et croisez les doigts. Alignez les bons symboles pour remporter des gains et déclencher des bonus. Qui sait ? Le jackpot est peut-être à portée de main !', '67c6367d136e6_bandit.webp', 'www.zoom/bandit/fasael-casion.com', 2),
(4, 'Gate of Olympus', 'Plongez dans l’univers mythologique de Gate of Olympus, une machine à sous en ligne inspirée des dieux grecs. Zeus lui-même peut multiplier vos gains grâce à ses puissants multiplicateurs. Avec ses mécaniques innovantes et ses free spins, chaque tour peut être une explosion de récompenses. Déclenchez la foudre et tentez de décrocher des gains divins !', '67c6451117182_gates-of-olympus-slot-pragmaticplay.jpg', 'www.zoom/goo/fasael-casino.com', 2);

-- --------------------------------------------------------

--
-- Structure de la table `transaction`
--

CREATE TABLE `transaction` (
  `id_transaction` int NOT NULL,
  `montant_transaction` varchar(50) NOT NULL,
  `date_transaction` varchar(20) NOT NULL,
  `id_user_transaction` int NOT NULL,
  `id_type_transaction` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `transaction`
--

INSERT INTO `transaction` (`id_transaction`, `montant_transaction`, `date_transaction`, `id_user_transaction`, `id_type_transaction`) VALUES
(1, '100', '09-03-2025', 2, 1),
(2, '300', '09-03-2025', 2, 2),
(3, '1200', '09-03-2025', 2, 2),
(4, '800', '09-03-2025', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `type_historique_jeux`
--

CREATE TABLE `type_historique_jeux` (
  `id_type_historique` int NOT NULL,
  `libelle_type_historique` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type_historique_jeux`
--

INSERT INTO `type_historique_jeux` (`id_type_historique`, `libelle_type_historique`) VALUES
(1, 'Gagné'),
(2, 'Perdu'),
(3, 'Égalité');

-- --------------------------------------------------------

--
-- Structure de la table `type_transaction`
--

CREATE TABLE `type_transaction` (
  `id_type_transaction` int NOT NULL,
  `libelle_type_transaction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type_transaction`
--

INSERT INTO `type_transaction` (`id_type_transaction`, `libelle_type_transaction`) VALUES
(1, 'Dépôt'),
(2, 'Retrait');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `user_prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pseudo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_mail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_mdp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_birth` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_admin` tinyint(1) DEFAULT '0',
  `user_coins` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `user_prenom`, `user_nom`, `user_pseudo`, `user_mail`, `user_mdp`, `user_birth`, `user_admin`, `user_coins`) VALUES
(2, 'Elie', 'Moyal', 'Skhirat92', 'eliemoyal3@gmail.com', '$2y$10$MQstgM.f3IbLooR./lp7k.gysd1x5901rSmBweS9I8RdfiYzbYusa', '2005-11-03', 1, '6000'),
(3, 'Karl', 'Eemi', 'Karl le GOAT', 'Karl@gmail.com', '$2y$10$lBjTjDve6F7Ua7I3XDOrOuXdErwPTya023e.dmBIuyHacFHpwhFP2', '2000-01-01', 1, '0');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `historique_jeux`
--
ALTER TABLE `historique_jeux`
  ADD PRIMARY KEY (`id_historique`),
  ADD KEY `historique_jeux_type_historique_jeux_FK` (`id_type_historique`);

--
-- Index pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD PRIMARY KEY (`id_jeux`),
  ADD KEY `jeux_categorie_FK` (`id_categorie`);

--
-- Index pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_transaction`),
  ADD KEY `transaction_type_transaction_FK` (`id_type_transaction`);

--
-- Index pour la table `type_historique_jeux`
--
ALTER TABLE `type_historique_jeux`
  ADD PRIMARY KEY (`id_type_historique`);

--
-- Index pour la table `type_transaction`
--
ALTER TABLE `type_transaction`
  ADD PRIMARY KEY (`id_type_transaction`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `historique_jeux`
--
ALTER TABLE `historique_jeux`
  MODIFY `id_historique` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `jeux`
--
ALTER TABLE `jeux`
  MODIFY `id_jeux` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `type_historique_jeux`
--
ALTER TABLE `type_historique_jeux`
  MODIFY `id_type_historique` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type_transaction`
--
ALTER TABLE `type_transaction`
  MODIFY `id_type_transaction` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `historique_jeux`
--
ALTER TABLE `historique_jeux`
  ADD CONSTRAINT `historique_jeux_type_historique_jeux_FK` FOREIGN KEY (`id_type_historique`) REFERENCES `type_historique_jeux` (`id_type_historique`);

--
-- Contraintes pour la table `jeux`
--
ALTER TABLE `jeux`
  ADD CONSTRAINT `jeux_categorie_FK` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`);

--
-- Contraintes pour la table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_type_transaction_FK` FOREIGN KEY (`id_type_transaction`) REFERENCES `type_transaction` (`id_type_transaction`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
