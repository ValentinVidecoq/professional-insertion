-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 09 Janvier 2020 à 19:42
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ip`
--

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`) VALUES
(1, 'Année de naissance', 3),
(2, 'Année d\'obtention du diplôme ', 3),
(3, 'Secteur d\'emploi ', 4),
(4, 'Tranche de salaire annuel ', 4);

-- --------------------------------------------------------

--
-- Structure de la table `question_type`
--

CREATE TABLE `question_type` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `multiple` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `question_type`
--

INSERT INTO `question_type` (`id`, `name`, `multiple`) VALUES
(1, 'Choix multiple', 1),
(2, 'Réponse libre', 0),
(3, 'Date', 0),
(4, 'Cases à cocher', 1),
(5, 'Liste déroulante', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id` int(11) NOT NULL,
  `idU` int(11) NOT NULL,
  `idQ` int(11) NOT NULL,
  `reponse` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reponses`
--

INSERT INTO `reponses` (`id`, `idU`, `idQ`, `reponse`) VALUES
(19, 1, 1, '1999'),
(20, 1, 2, '2022'),
(21, 1, 3, '1'),
(22, 1, 4, '2'),
(23, 4, 1, '1998'),
(24, 4, 2, '2023'),
(25, 4, 3, '3'),
(26, 4, 4, '1'),
(27, 3, 1, '2000'),
(28, 3, 2, '2021'),
(29, 3, 3, '2'),
(30, 3, 4, '2'),
(31, 2, 1, '1999'),
(32, 2, 2, '2022'),
(33, 2, 3, '1'),
(34, 2, 4, '4'),
(35, 5, 1, '2001'),
(36, 5, 2, '2024'),
(37, 6, 1, '2020'),
(38, 6, 2, '2020'),
(39, 6, 4, '1'),
(40, 7, 3, '3');

-- --------------------------------------------------------

--
-- Structure de la table `reponses_type`
--

CREATE TABLE `reponses_type` (
  `id` int(11) NOT NULL,
  `idQ` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reponses_type`
--

INSERT INTO `reponses_type` (`id`, `idQ`, `name`, `value`) VALUES
(1, 4, 'Moins de 15 000€', '1'),
(2, 4, 'Entre 15 000€ et 30 000€', '2'),
(4, 4, 'Plus de 50 000€', '4'),
(5, 3, 'Informatique', '1'),
(6, 3, 'Industrie', '2'),
(7, 3, 'Développement durable', '3');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `mail`, `password`, `auth`) VALUES
(1, 'Pottiez', 'Martin', 'martinp@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 2),
(2, 'Uyttersprot', 'Valentin', 'valentinu@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1),
(3, 'Videcoq', 'Valentin', 'valentinv@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1),
(4, 'Vasseur', 'Alexandre', 'alexv@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1),
(5, 'Plouvin', 'Théo', 'theop@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1),
(6, 'Leurette', 'Gauthier', 'gauthierl@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1),
(7, 'Boulay', 'Emeric', 'emericb@gmail.com', '$2y$10$Zn/yRyeOzsV/Avg6WtWBseDveFYvIK/rg2MmEPC73wxQwJXMJRNQO', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Index pour la table `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idU` (`idU`),
  ADD KEY `idQ` (`idQ`);

--
-- Index pour la table `reponses_type`
--
ALTER TABLE `reponses_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idQ` (`idQ`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `question_type`
--
ALTER TABLE `question_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `reponses_type`
--
ALTER TABLE `reponses_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`type`) REFERENCES `question_type` (`id`);

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`idU`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `reponses_ibfk_2` FOREIGN KEY (`idQ`) REFERENCES `questions` (`id`);

--
-- Contraintes pour la table `reponses_type`
--
ALTER TABLE `reponses_type`
  ADD CONSTRAINT `reponses_type_ibfk_1` FOREIGN KEY (`idQ`) REFERENCES `questions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
