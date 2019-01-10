-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 10. Jan 2019 um 18:10
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
(1, 'Jan', 'Henzi', 'Angelstrasse 1', 1234, 'jan.henzi@angelmail.com', 'CH'),
(2, 'Admin', 'Master', 'Adminstrasse 999', 9999, 'admin@adminmail.com', 'AD');

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
(1, 'JAN HENZI', 1234123412341234, 123);

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
(1, 'Jan', 'Henzi', 'Angelstrasse 1', 1234, 'CH');

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
(1, 'SeatroutX', 60.5, 1, 1),
(2, 'SeatroutX', 60.5, 1, 2),
(3, 'Pose Rod', 30, 1, 3),
(4, 'Pose Rod', 30, 1, 4),
(5, 'Carp rod', 39.9, 1, 5),
(6, 'Carp rod', 39.9, 1, 6),
(7, 'Seareel', 289, 2, 7),
(8, 'Seareel', 289, 2, 8),
(9, 'Salt water reel', 99, 2, 9),
(10, 'Salt water reel', 99, 2, 10),
(11, 'Maggots', 3, 3, 11),
(12, 'Maggots', 3, 3, 12),
(13, 'Metal lures', 1.5, 3, 13),
(14, 'Metal lures', 1.5, 3, 14),
(15, 'Line yard goods', 0.8, 4, 15),
(16, 'Line yard goods', 0.8, 4, 16),
(17, 'Leader String', 3.5, 4, 17),
(18, 'Leader String', 3.5, 4, 18),
(19, 'Boot mat', 22.5, 5, 19),
(20, 'Boot mat', 22.5, 5, 20),
(21, 'Fishing cup', 5.3, 5, 21),
(22, 'Fishing cup', 5.3, 5, 22),
(23, 'All Round rod', 90, 1, 23),
(24, 'All Round rod', 90, 1, 24),
(25, 'Telescopic rod', 63, 1, 25),
(26, 'Telescopic rod', 63, 1, 26),
(27, 'Battle Brake Roll', 299, 2, 27),
(28, 'Battle Brake Roll', 299, 2, 28),
(29, 'Running reel', 69, 2, 29),
(30, 'Running reel', 69, 2, 30);

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
(1, 1, 'Sea Trout Rod', 'The trout rod has a fast jumping tip action which catapults the lure to enormous casting distances. In the drill, the action is transferred to a semi-parabolic action, which cushions fast cursing and head bumps.'),
(2, 2, 'Meerforellenrute', 'Die Meerforellenrute weist eine schnelle Süpitzenaktion auf, die den Köder auf enorme Wurfweiten katapultieren. Im Drill gehr die Aktion auf eine semi-parabolische Aktion über, die schnelle Fluchen und Kopfstöße abfedern.'),
(3, 1, 'Pose Rod', 'Poznan rods have a light, semi-parabolic blank that works up to the hand part under load and cushions head bumps easily.'),
(4, 2, 'Posenrute', 'Posenruten verfügen über einen leichten, semi-parabolischen Blank, der bei Belastung bis ins Handteil arbeitet und Kopfstöße spielend abfedert.'),
(5, 1, 'Carp rod', 'The carp rod inspires by processing and throwing distance. The hand part under the reel holder is completely covered with black shrinking tube and lies very handy in the hand. '),
(6, 2, 'Karpfenrute', 'Die Karpfenrute begeistert durch Verarbeitung und Wurfweite. Das Handteil unter dem Rollenhalter ist komplett mit schwarzem Schrumpfschlauch überzogen und liegt sehr griffig in der Hand. '),
(7, 1, 'Seareel', 'Sea reel for the demanding sea angler. Whether in Norway, Iceland or the Mediterranean, this powerful multi reel will be appreciated by sea anglers.'),
(8, 2, 'Meeresrolle', 'Meeresrolle für den anspruchsvollen Meeresangler. Gleichgültig ob in Norwegen, Island oder im Mittelmeer, diese leistungsstarke Multirolle werden Meeresangler zu schätzen wissen.'),
(9, 1, 'Salt water reel', 'Saltwater resistant fishing reel. These sturdy and powerful reels are ideal for fishing in Norway as well as for big fish in fresh water.'),
(10, 2, 'Salzwasserrolle', 'Salzwasserfeste Angelrolle. Diese robusten und leistungsstarken Rollen begeistern beim Angeln in Norwegen ebenso wie beim Angeln auf kapitale Fische im Süßwasser.'),
(11, 1, 'Fleischmaden', 'Die Fleischmade (Vermes carnium) wird verwendet als Top-Koeder zum Angeln.\r\nVerpackung 1/8 Liter.'),
(12, 2, 'Maggots', 'The Maggot (Vermes carnium) is used as top bait for fishing.\r\nPacking 1/8 litre.'),
(13, 1, 'Metal lures', 'Fishing method: boat fishing / trolling spin fishing perch fishing perch fishing in freshwater spinning bait casting sea fishing\r\n30 pcs.'),
(14, 2, 'Metallkoeder', 'Angelmethode: Bootsangeln / Schleppangelfischen Spinnfischen Barschangeln Fischen im Süßwasser Spinn Köderwerfen Seefischerei\r\n30 Stk.'),
(15, 1, 'Line yard goods', 'Line yard ware offers a braided high-performance cord at an excellent price/performance ratio. The line is very tightly braided according to highest Japanese quality standards and convinces in all points.'),
(16, 2, 'Schnur Meterware', 'Schnur Meterware bietet eine geflochtene Hochleistungsschnur zu einem hervorragenden Preis-/Leistungs-Verhältnis. Die Schnur wird nach höchsten japanischen Qualitätsstandards sehr eng geflochten und überzeugt in allen Punkten.'),
(17, 1, 'Leader String', 'A sea leader in a class of its own for professional anglers! In our eyes, the leader line is one of the most abrasion-resistant and bite resistant predator leader lines on the market! Extra unobtrusive due to its crystal clear colour.'),
(18, 2, 'Vorfachschnur', 'Ein Meeresvorfach der Extraklasse für professionelle Angler! In unseren Augen ist die Vorfachschnur eine der abriebsichersten und bissfestesten Raubfischvorfächer auf dem Markt! Extra unauffällig durch die glasklare Farbe.'),
(19, 1, 'Boot mat', 'Universal boot mat made of PVC\r\nWashable \r\nnon-slip\r\nWater and dirt repellent'),
(20, 2, 'Kofferraummatte', 'Universal-Kofferraummatte aus PVC\r\nAbwaschbar\r\nRutschfest\r\nWasser- und schmutzabweisend'),
(21, 1, 'Fishing cup', 'With stylish Fox logo'),
(22, 2, 'Angeltasse', 'Mit stylischem Fox Logo'),
(23, 1, 'All Round rod', 'The all-round rod lies like an extended arm in the hand. The casting characteristics convince by width and accuracy. Every bait movement is reliably transmitted to the angler.'),
(24, 2, 'Allroundrute', 'Die Allroundrute liegt wie ein verlaengerter Arm in der Hand. Die Wurfeigenschaften Ueberzeugen durch Weite und Genauigkeit. Bei der Fuehrung wird jede  KÃ¶derbewegung zuverlÃ¤ssig an den Angler Ã¼bertragen. '),
(25, 1, 'Telescopic rod', 'The telescopic rod is a versatile telescopic rod that covers a wide range of angling types. Tele rods with their high quality carbon fibre blanks and wound rings show an excellent action, which comes very close to that of rods.'),
(26, 2, 'Teleskoprute', 'Die Teleskoprute ist eine vielseitig einsetzbare Teleskoprute, die eine groÃŸe Bandbreite an Angelarten abdeckt. Tele Ruten weisen mit ihren hochwertigen Kohlefaserblanks und gewickelten Ringen eine hervorragende Aktion auf, die denen von Steckruten sehr nahe kommt.'),
(27, 1, 'Battle Brake Roll', 'Battle Brake Roll is a professional roll with Fighting\' Drag battle brake. This Fightin Drag function allows a lightning fast fine tuning in the drill.'),
(28, 2, 'Kampfbremsrolle', 'Kampfbremsrolle ist eine professionelle Rolle mit Fightingâ€˜ Drag Kampfbremse. Diese Fightin Drag Funktion erlaubt ein blitzschnelles Feinjustieren im Drill.'),
(29, 1, 'Running reel', 'Super smooth running aluminium Nottingham reel for hegenen fishing on whitefish.\r\nFeatures: 2 Japanese ball bearings. Aluminium spool. Lockable brake, which is released during drill.'),
(30, 2, 'Laufrolle', 'Super leichtlÃ¤ufige Nottingham-Rolle aus Aluminium zum Hegenenfischen auf Felchen.\r\nAusstattung: 2 japanische Kugellager. Spule aus Aluminium. Arretierbare Bremse, die sich bei Drill lÃ¶st.');

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
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Daten für Tabelle `shopusers`
--

INSERT INTO `shopusers` (`id`, `username`, `password`, `contact`) VALUES
(1, 'henzij', 'welcome1', 1),
(2, 'admin', '$2y$10$mRjvaAec8eh7vUVblw0McuQpIu5KKV0szheSQW4TU22KeZ00wUvpW', 2);

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
(1, 1, 1);

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
