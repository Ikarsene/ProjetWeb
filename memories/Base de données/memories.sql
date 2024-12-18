-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 05:50 PM
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
-- Database: `memories`
--

-- --------------------------------------------------------

--
-- Table structure for table `cyclepresentation`
--

CREATE TABLE `cyclepresentation` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `etape` int(11) NOT NULL,
  `nbrejours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyclepresentation`
--

INSERT INTO `cyclepresentation` (`id`, `iduser`, `etape`, `nbrejours`) VALUES
(1, 1, 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `datepresentation`
--

CREATE TABLE `datepresentation` (
  `id` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idquestion` int(11) NOT NULL,
  `idcycle` int(11) NOT NULL,
  `memorisation` int(11) NOT NULL,
  `prochainedate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `datepresentation`
--

INSERT INTO `datepresentation` (`id`, `iduser`, `idquestion`, `idcycle`, `memorisation`, `prochainedate`) VALUES
(2, 1, 3, 1, 3, '2024-12-08'),
(3, 1, 2, 1, 3, '2024-12-08'),
(4, 1, 2, 1, 3, '2024-12-08'),
(5, 1, 2, 1, 2, '2024-12-07'),
(6, 1, 2, 1, 3, '2024-12-09'),
(7, 1, 2, 1, 3, '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `reponse` text NOT NULL,
  `idtheme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `reponse`, `idtheme`) VALUES
(2, 'Qu\'est-ce que l\'attribut `alt` dans une balise `<img>` et pourquoi est-il important pour l\'accessibilité d\'un site web ?', 'L\'attribut `alt` dans une balise `<img>` permet de fournir une description textuelle de l\'image. Ce texte est affiché si l\'image ne peut pas être chargée ou est utilisé par des technologies d\'assistance, comme les lecteurs d\'écran pour les personnes malvoyantes.', 1),
(3, 'Que fait la balise <a> en HTML ?', 'La balise <a> est utilisée pour créer un lien hypertexte. Elle permet de lier une page HTML à une autre page ou à un autre site web.\r\n\r\nExemple :\r\n\r\nhtml\r\nCopy code\r\n<a href=\"https://www.example.com\">Visitez notre site</a>', 1),
(4, 'Qu\'est-ce que la TVA et comment fonctionne-t-elle ?', 'La TVA (Taxe sur la Valeur Ajoutée) est un impôt indirect sur la consommation. Elle est collectée par les entreprises auprès des consommateurs et reversée à l\'État.', 2),
(5, 'Qu\'est-ce que le contrat de travail ?', 'Le contrat de travail est un accord entre un employeur et un salarié.', 2),
(6, 'Qu\'est-ce qu\'une liste en Python', 'Une liste en Python est une structure de données ordonnée qui peut contenir des éléments de types différents (entiers, chaînes de caractères, etc.). Elle est définie en utilisant des crochets []', 3),
(7, 'Comment pouvez-vous itérer sur une liste en Python ?', 'Vous pouvez utiliser une boucle for pour itérer sur les éléments d\'une liste.', 3),
(8, 'Comment gérer les exceptions en C# ?', 'Les exceptions en C# sont gérées à l\'aide des blocs try, catch, et finally', 4),
(9, 'Qu\'est-ce qu\'une suite arithmétique ?', 'Une suite arithmétique est une suite de nombres tels que la différence entre deux termes consécutifs est constante.', 5),
(10, 'Qu\'est-ce qu\'une suite géométrique', 'Une suite géométrique est une suite de nombres tels que le rapport entre deux termes consécutifs est constant.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `nomtheme` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `nomtheme`) VALUES
(1, 'HTML'),
(2, 'CEJM'),
(3, 'PYTHON'),
(4, 'C#'),
(5, 'MATHINFO');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(100) NOT NULL,
  `passwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `passwd`) VALUES
(1, 'toto', '$2y$10$YJeExW9x3GNx0Eq3D/97v.LlAQRj.tJFrx/gV9rjeq1wcKxI5aG7a'),
(2, 'user1', '$2y$10$uuzX048lMaCOM7Q/lnvAh.4RChSaiCzU4t1VyexGMOE8aZzChGfRW'),
(3, 'user2', '$2y$10$l5JczOIs2Gw8ycLx.Z8vvOLSzyA15BVmigJSxbC/RNupW2E2q.GSO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cyclepresentation`
--
ALTER TABLE `cyclepresentation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `datepresentation`
--
ALTER TABLE `datepresentation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idquestion` (`idquestion`),
  ADD KEY `idcycle` (`idcycle`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtheme` (`idtheme`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cyclepresentation`
--
ALTER TABLE `cyclepresentation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `datepresentation`
--
ALTER TABLE `datepresentation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cyclepresentation`
--
ALTER TABLE `cyclepresentation`
  ADD CONSTRAINT `cyclepresentation_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `datepresentation`
--
ALTER TABLE `datepresentation`
  ADD CONSTRAINT `datepresentation_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `datepresentation_ibfk_2` FOREIGN KEY (`idquestion`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `datepresentation_ibfk_3` FOREIGN KEY (`idcycle`) REFERENCES `cyclepresentation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`idtheme`) REFERENCES `themes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
