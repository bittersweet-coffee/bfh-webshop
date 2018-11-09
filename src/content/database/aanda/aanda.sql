-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 09. Nov 2018 um 12:54
-- Server-Version: 10.1.36-MariaDB
-- PHP-Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `aanda`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `language`
--

INSERT INTO `language` (`id`, `name`, `short`) VALUES
(1, 'English', 'en'),
(2, 'Deutsch', 'de');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `lang_type_prod`
--

CREATE TABLE `lang_type_prod` (
  `id` int(11) NOT NULL,
  `id_l` int(11) NOT NULL,
  `id_t` int(11) NOT NULL,
  `id_p` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `lang_type_prod`
--

INSERT INTO `lang_type_prod` (`id`, `id_l`, `id_t`, `id_p`) VALUES
(1, 2, 1, 1),
(2, 1, 1, 2),
(3, 2, 1, 3),
(4, 1, 1, 4),
(5, 2, 2, 5),
(6, 1, 2, 6),
(7, 2, 2, 7),
(8, 1, 2, 8),
(9, 2, 1, 9),
(10, 2, 3, 10),
(11, 2, 4, 11),
(12, 2, 5, 12),
(13, 2, 3, 13),
(14, 2, 4, 14),
(15, 2, 5, 15),
(16, 1, 3, 16),
(17, 1, 4, 17),
(18, 1, 5, 18),
(19, 1, 3, 19),
(20, 1, 4, 20),
(21, 1, 5, 21),
(22, 2, 1, 22),
(23, 2, 2, 23),
(24, 2, 3, 24),
(25, 2, 4, 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`id`, `name`, `description`) VALUES
(1, 'Superangel', 'Superangel Beschreibung Superangel Beschreibung Superangel Beschreibung Superangel Beschreibung'),
(2, 'Superrod', 'Superrod Description Superrod Description Superrod Description Superrod Description'),
(3, 'Amateurangel', 'Amateurangel Beschreibung Amateurangel Beschreibung Amateurangel Beschreibung Amateurangel Beschreibung'),
(4, 'Amateurrod', 'Amateurrod Description Amateurrod Description Amateurrod Description Amateurrod Description'),
(5, 'Superrolle', 'Superrolle Beschreibung Superrolle Beschreibung Superrolle Beschreibung Superrolle Beschreibung'),
(6, 'Superreel', 'Superreel Description Superreel Description Superreel Description Superreel Description'),
(7, 'Amateurrolle', 'Amateurrolle Beschreiibung Amateurrolle Beschreiibung Amateurrolle Beschreiibung Amateurrolle Beschreiibung'),
(8, 'Amateurreel', 'Amateurreel Description Amateurreel Description Amateurreel Description Amateurreel Description'),
(9, 'Giga Angel', 'Wichtige Giga-Abgel Beschreibung'),
(10, 'Superkoeder', 'Beschreibung von Superkoeder'),
(11, 'Superschnur', 'Beschreibung von Superschnur'),
(12, 'Superzubehoer', 'Beschreibung von Superzubehoer'),
(13, 'Amateurkoeder', 'Beschreibung von Amateurkoeder'),
(14, 'Amateurschnur', 'Beschreibung von Amateurschnur'),
(15, 'Amateurzubehoer', 'Beschreibung von Amateurzubehoer'),
(16, 'Super Lure', 'Description of Super Lure'),
(17, 'Super Fishing Line', 'Description of Super Fishing Line'),
(18, 'Super Accessorie', 'Description of Super Accessories'),
(19, 'Amateur Lure', 'Description of Amateur Lure'),
(20, 'Amateur Fishing Line', 'Description of Amateur Fishing Line'),
(21, 'Amateur Accessorie', 'Description of Amateur Accessorie'),
(22, 'Mega Angel', 'Beschreibung von Mega Angel'),
(23, 'Mega Rolle', 'Beschreibung von Mega Rolle'),
(24, 'Mega Koeder', 'Beschreibung von Mega Koeder'),
(25, 'Mega Schnur', 'Beschreibung von Mega Schnur'),
(26, 'Mega Rod', 'Description of Mega Rod'),
(27, 'Mega Reel', 'Description of Mega Rod'),
(28, 'Mega Lure', 'Description of Mega Lure'),
(29, 'Mega Line', 'Description of Mega Line'),
(30, 'Mega Zubehoer', 'Beschriebung von Mega Zubehoer'),
(31, 'Mega Accessories', 'Description of Mega Accessories');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `p_type`
--

CREATE TABLE `p_type` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `p_type`
--

INSERT INTO `p_type` (`id`, `name`) VALUES
(1, 'Fishing Rods'),
(2, 'Reels'),
(3, 'Lures'),
(4, 'Fishing Lines'),
(5, 'Accessories');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `lang_type_prod`
--
ALTER TABLE `lang_type_prod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_l` (`id_l`),
  ADD KEY `fk_id_t` (`id_t`),
  ADD KEY `fk_id_p` (`id_p`);

--
-- Indizes für die Tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `p_type`
--
ALTER TABLE `p_type`
  ADD PRIMARY KEY (`id`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `lang_type_prod`
--
ALTER TABLE `lang_type_prod`
  ADD CONSTRAINT `fk_id_l` FOREIGN KEY (`id_l`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `fk_id_p` FOREIGN KEY (`id_p`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_id_t` FOREIGN KEY (`id_t`) REFERENCES `p_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
