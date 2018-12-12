-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 26. Nov 2018 um 18:31
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
-- Tabellenstruktur für Tabelle `contact_users`
--

CREATE TABLE `contact_users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalcode` int(4) NOT NULL,
  `email` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `contact_users`
--

INSERT INTO `contact_users` (`id`, `firstname`, `lastname`, `address`, `postalcode`, `email`, `country`) VALUES
(1, 'Jan', 'Henzi', 'Angelstrasse 1', 1234, 'jan.henzi@hotmail.com', 'CH'),
(2, 'TestUserFirstname', 'TestUserLastName', 'TestUserStrasse 12', 1234, 'testUser@mail.com', 'GB');

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
-- Tabellenstruktur für Tabelle `payment_card`
--

CREATE TABLE `payment_card` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` bigint(16) NOT NULL,
  `cvv` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `payment_card`
--

INSERT INTO `payment_card` (`id`, `name`, `number`, `cvv`) VALUES
(1, 'JAN HENZI', 1234123412341234, 123),
(2, 'TEST USER', 4321432143214321, 321);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `payment_paper`
--

CREATE TABLE `payment_paper` (
  `id` int(11) NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postalcode` int(4) NOT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `payment_paper`
--

INSERT INTO `payment_paper` (`id`, `firstname`, `lastname`, `address`, `postalcode`, `country`) VALUES
(1, 'Jan', 'Henzi', 'Angelstrasse 1', 1234, 'CH'),
(2, 'TestUserFirstname', 'TestUserLastName', 'TestUserStrasse 12', 1234, 'GB');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `p_id` int(11) NOT NULL,
  `d_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `p_id`, `d_id`) VALUES
(1, 'Superrod', 50, 1, 1),
(2, 'Superrod', 50, 1, 2),
(3, 'Amateurrod', 20, 1, 3),
(4, 'Amateurrod', 20, 1, 4),
(5, 'Megarod', 200, 1, 5),
(6, 'Megarod', 200, 1, 6),
(7, 'Superreel', 25.5, 2, 7),
(8, 'Superreel', 25.5, 2, 8),
(9, 'Amateurreel', 15.5, 2, 9),
(10, 'Amateurreel', 15.5, 2, 10),
(11, 'Super lure', 3, 3, 11),
(12, 'Super lure', 3, 3, 12),
(13, 'Amateur lure', 1.5, 3, 13),
(14, 'Amateur lure', 1.5, 3, 14),
(15, 'Superline', 5, 4, 15),
(16, 'Superline', 5, 4, 16),
(17, 'Amateur line', 3.5, 4, 17),
(18, 'Amateur line', 3.5, 4, 18),
(19, 'Superaccessories', 70, 5, 19),
(20, 'Superaccessories', 70, 5, 20),
(21, 'Amateuraccessories', 23.3, 5, 21),
(22, 'Amateuraccessories', 23.3, 5, 22),
(23, 'Gigarod', 99.9, 1, 23),
(24, 'Gigarod', 99.9, 1, 24);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `p_real`
--

CREATE TABLE `p_real` (
  `id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `p_real`
--

INSERT INTO `p_real` (`id`, `l_id`, `name`, `description`) VALUES
(1, 1, 'Superrod', 'Description of Superrod Description of Superrod Description of Superrod'),
(2, 2, 'Super Angel', 'Beschreibung von Super Angel Beschreibung von Super Angel Beschreibung von Super Angel'),
(3, 1, 'Amateurrod', 'Description of Amateurrod Description of Amateurrod Description of Amateurrod'),
(4, 2, 'Amateur Angel', 'Beschreibung von Amateur Angel'),
(5, 1, 'Megarod', 'Description of Megarod'),
(6, 2, 'Mega Angel', 'Beschreibung von Mega Angel'),
(7, 1, 'Superreel', 'Description of Superreel'),
(8, 2, 'Super Rolle', 'Beschreibung von Amateur Angel'),
(9, 1, 'Amateurreel', 'Beschreibung von Super Rolle'),
(10, 2, 'Amateur Rolle', 'Beschreibung von Amateur Rolle'),
(11, 1, 'Super lure', 'Description of lure'),
(12, 2, 'Super Koeder', 'Beschreibung von Koeder'),
(13, 1, 'Amateur lure', 'Description of lure'),
(14, 2, 'Amateur Koeder', 'Beschreibung von Koeder'),
(15, 1, 'Superline', 'Description of Superline'),
(16, 2, 'Super Schnur', 'Beschreibung von Schnur'),
(17, 1, 'Amateur line', 'Description of Amateurline'),
(18, 2, 'Amateur Schnur', 'Beschreibung von Schnut'),
(19, 1, 'Superaccessories', 'Description of super accessories'),
(20, 2, 'Super Zubehoer', 'Beschreibung von super Zubehoer'),
(21, 1, 'Amateuraccessories', 'Description of Amatueraccessories'),
(22, 2, 'Amateur Zubehoer', 'Beschreibung von Amateur Zubehoer'),
(23, 1, 'Gigarod', 'Description of Gigarod'),
(24, 2, 'Giga Angel', 'Beschreibung von Giga Angel');

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

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `shopusers`
--

CREATE TABLE `shopusers` (
  `id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `shopusers`
--

INSERT INTO `shopusers` (`id`, `username`, `password`, `contact`) VALUES
(1, 'henzij', 'welcome1', 1),
(2, 'testuser', 'welcome1', 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users_card_paper`
--

CREATE TABLE `users_card_paper` (
  `id_u` int(11) NOT NULL,
  `id_c` int(11) NOT NULL,
  `id_p` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `users_card_paper`
--

INSERT INTO `users_card_paper` (`id_u`, `id_c`, `id_p`) VALUES
(1, 1, 1),
(2, 2, 2);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `contact_users`
--
ALTER TABLE `contact_users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `payment_card`
--
ALTER TABLE `payment_card`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `payment_paper`
--
ALTER TABLE `payment_paper`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_id` (`p_id`),
  ADD KEY `d_id` (`d_id`);

--
-- Indizes für die Tabelle `p_real`
--
ALTER TABLE `p_real`
  ADD PRIMARY KEY (`id`),
  ADD KEY `l_id` (`l_id`);

--
-- Indizes für die Tabelle `p_type`
--
ALTER TABLE `p_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `shopusers`
--
ALTER TABLE `shopusers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact` (`contact`);

--
-- Indizes für die Tabelle `users_card_paper`
--
ALTER TABLE `users_card_paper`
  ADD KEY `id_u` (`id_u`),
  ADD KEY `id_c` (`id_c`),
  ADD KEY `id_p` (`id_p`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `p_type` (`id`),
  ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`d_id`) REFERENCES `p_real` (`id`),
  ADD CONSTRAINT `product_ibfk_4` FOREIGN KEY (`d_id`) REFERENCES `p_real` (`id`);

--
-- Constraints der Tabelle `p_real`
--
ALTER TABLE `p_real`
  ADD CONSTRAINT `p_real_ibfk_1` FOREIGN KEY (`l_id`) REFERENCES `language` (`id`);

--
-- Constraints der Tabelle `shopusers`
--
ALTER TABLE `shopusers`
  ADD CONSTRAINT `shopusers_ibfk_1` FOREIGN KEY (`contact`) REFERENCES `contact_users` (`id`);

--
-- Constraints der Tabelle `users_card_paper`
--
ALTER TABLE `users_card_paper`
  ADD CONSTRAINT `users_card_paper_ibfk_1` FOREIGN KEY (`id_u`) REFERENCES `contact_users` (`id`),
  ADD CONSTRAINT `users_card_paper_ibfk_2` FOREIGN KEY (`id_c`) REFERENCES `payment_card` (`id`),
  ADD CONSTRAINT `users_card_paper_ibfk_3` FOREIGN KEY (`id_p`) REFERENCES `payment_paper` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
