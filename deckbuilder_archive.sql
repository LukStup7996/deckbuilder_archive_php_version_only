-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Jul 2024 um 11:25
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `deckbuilder_archive`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `archiveuser`
--

CREATE TABLE `archiveuser` (
  `user_id` int(11) NOT NULL,
  `mail_adress` varchar(252) NOT NULL,
  `archive_name` varchar(50) NOT NULL,
  `user_password` varchar(252) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `archiveuser`
--

INSERT INTO `archiveuser` (`user_id`, `mail_adress`, `archive_name`, `user_password`) VALUES
(1, 'magicluks@live.at', 'CroweTest', '$2y$10$tKnIoJYLdcOeylsHR9zqmeLPaRWw2f7Vx0BoH2uu1EGG0HkHMXeAa'),
(2, 'deckTester@tester.gg', 'TestDud', '$2y$10$0lZkbUL2Q/aa6NZcW29poONE3wZKxWmMej1iymR3pH0gTInEqVMei');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cards`
--

CREATE TABLE `cards` (
  `card_id` varchar(10) NOT NULL,
  `card_name` varchar(152) NOT NULL,
  `card_type` varchar(152) NOT NULL,
  `super_type` varchar(152) DEFAULT NULL,
  `sub_type` varchar(152) DEFAULT NULL,
  `mana_value` varchar(152) DEFAULT NULL,
  `cmc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `cards`
--

INSERT INTO `cards` (`card_id`, `card_name`, `card_type`, `super_type`, `sub_type`, `mana_value`, `cmc`) VALUES
('2X2094', 'Surgical Extraction', 'Instant', NULL, NULL, '{-B}', 1),
('2X2123', 'Seasoned Pyromancer', 'Creature', NULL, 'Human Shaman', '{1}{R}{R}', 3),
('2X2274', 'Mishra\'s Bauble', 'Artifact', NULL, NULL, '{0}', 0),
('2XM114', 'Abrade', 'Instant', NULL, NULL, '{1}{R}', 2),
('2XM208', 'Manamorphose', 'Instant', NULL, NULL, '{1}{R}', 2),
('A25147', 'Red Elemental Blast', 'Instant', NULL, NULL, '{R}', 1),
('BBD171', 'Chain Lightning', 'Sorcery', NULL, NULL, '{R}', 1),
('BRO144', 'Monastery Swiftspear', 'Creature', NULL, 'Human Monk', '{R}', 1),
('DMR082', 'Entomb', 'Instant', NULL, NULL, '{B}', 1),
('DMR119', 'Fireblast', 'Instant', NULL, NULL, '{4}{R}{R}', 6),
('ELD058', 'Mystical Dispute', 'Instant', NULL, NULL, '{2}{U}', 3),
('EMA038', 'Cabal Therapy', 'Instant', NULL, NULL, '{B}', 1),
('EMA128', 'Faithless Looting', 'Sorcery', NULL, NULL, '{R}', 1),
('GRN091', 'Arclight Phoenix', 'Creature', NULL, 'Phoenix', '{3}{R}', 4),
('GRN257', 'Steam Vents', 'Land', NULL, NULL, '{0}', 0),
('IMA055', 'Flusterstorm', 'Instant', NULL, NULL, '{U}', 1),
('KLD249', 'Spirebluff Canal', 'Land', NULL, NULL, '{0}', 0),
('KTK230', 'Bloodstained Mire', 'Land', NULL, NULL, '{0}', 0),
('KTK233', 'Flooded Strand', 'Land', NULL, NULL, '{0}', 0),
('KTK239', 'Polluted Delta', 'Land', NULL, NULL, '{0}', 0),
('KTK249', 'Wooded Foothills', 'Land', NULL, NULL, '{0}', 0),
('LTR0071', 'Stern Scolding', 'Instant', NULL, NULL, '{U}', 1),
('LTR0103', 'Orcish Bowmaster', 'Creature', NULL, 'Orc Archer', '{1}{B}', 2),
('LTR0118', 'Cast into the Fire', 'Instant', NULL, NULL, '{1}{R}', 2),
('M10146', 'Lightning Bolt', 'Instant', NULL, NULL, '{R}', 1),
('M11070', 'Preordain', 'Sorcery', NULL, NULL, '{U}', 1),
('MH1052', 'Force of Negation', 'Instant', NULL, NULL, '{1}{U}{U}', 3),
('MH1100', 'Plague Engineer', 'Creature', NULL, 'Phyrexian Carrier', '{2}{B}', 3),
('MH1134', 'Lava Dart', 'Instant', NULL, NULL, '{R}', 1),
('MH1238', 'Fiery Islet', 'Land', NULL, NULL, '{0}', 0),
('MH2039', 'Dress Down', 'Enchantment', NULL, NULL, '{1}{U}', 2),
('MH2067', 'Subtlety', 'Creature', NULL, 'Elemental Incarnation', '{2}{U}{U}', 4),
('MH2121', 'Dragon\'s Rage Channeler', 'Creature', NULL, 'Human Shaman', '{R}', 1),
('MH2138', 'Ragavan, Nimble Pilferer', 'Creature', 'Legendray', 'Monkey Pirate', '{R}', 1),
('MH2145', 'Unholy Heat', 'Instant', NULL, NULL, '{R}', 1),
('MH2244', 'Arid Mesa', 'Land', NULL, NULL, '{0}', 0),
('MH2250', 'Misty Rainforest', 'Land', NULL, NULL, '{0}', 0),
('MH2267', 'Counterspell', 'Instant', NULL, NULL, '{U}{U}', 2),
('MH2337', 'Murktide Regent', 'Creature', NULL, 'Dragon', '{5}{U}{U}', 7),
('MID044', 'Consider', 'Instant', NULL, NULL, '{U}', 1),
('MM3051', 'Spell Pierce', 'Instant', NULL, NULL, '{U}', 1),
('MM3090', 'Blood Moon', 'Enchantment', NULL, NULL, '{2}{R}', 3),
('NEO271', 'Otawara, Soaring City', 'Land', 'Legendary', NULL, '{0}', 0),
('RNA107', 'Light Up the Stage', 'Sorcery', NULL, NULL, '{2}{R}', 3),
('RVR273', 'Blood Crypt', 'Land', NULL, 'Swamp Mountain', '{o}', 0),
('SNC046', 'Ledger Shredder', 'Creature', NULL, 'Bird Advisor', '{1}{U}', 2),
('SNC246', 'Unlicensed Hearse', 'Artifact', NULL, 'Vehicle', '{2}', 2),
('STX186', 'Expressive Iteration', 'Sorcery', NULL, NULL, '{U}{R}', 0),
('TPR225', 'Lotus Petal', 'Artifact', NULL, NULL, '{0}', 0),
('UMA227', 'Engineered Explosives', 'Artifact', NULL, NULL, '{X}', 0),
('UNH136', 'Plains', 'Land', 'Basic', 'Plains', '{0}', 0),
('UNH137', 'Island', 'Land', NULL, NULL, '{0}', 0),
('UNH138', 'Swamp', 'Land', 'Basic', 'Swamp', '{0}', 0),
('UNH139', 'Mountain', 'Land', 'Basic', 'Mountain', '{0}', 0),
('UNH140', 'Forest', 'Land', 'Basic', 'Forest', '{0}', 0),
('ZEN223', 'Scalding Tarn', 'Land', NULL, NULL, '{0}', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cards_decklists`
--

CREATE TABLE `cards_decklists` (
  `card_id` varchar(10) NOT NULL,
  `deck_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `side_board` varchar(3) DEFAULT NULL,
  `maybe_board` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `cards_decklists`
--

INSERT INTO `cards_decklists` (`card_id`, `deck_id`, `quantity`, `side_board`, `maybe_board`) VALUES
('2X2094', 9, 1, 'No', 'No'),
('MM3090', 7, 1, 'Yes', 'No'),
('2X2094', 8, 1, 'No', 'Yes'),
('2X2274', 10, 4, 'No', 'No'),
('2XM208', 10, 2, 'Yes', 'No'),
('A25147', 10, 3, 'No', 'Yes');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `decklists`
--

CREATE TABLE `decklists` (
  `deck_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` date NOT NULL DEFAULT current_timestamp(),
  `deck_name` varchar(152) NOT NULL,
  `format` varchar(52) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `decklists`
--

INSERT INTO `decklists` (`deck_id`, `user_id`, `creation_date`, `deck_name`, `format`) VALUES
(7, 1, '2024-06-03', 'TestBase', 'Standard'),
(8, 1, '2024-06-06', 'TestBaseTwo', 'Standard'),
(9, 1, '2024-06-06', 'TestBaseDrei', 'Standard'),
(10, 1, '2024-06-17', 'TestBaseSix', 'Standard');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `archiveuser`
--
ALTER TABLE `archiveuser`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `mail_adress` (`mail_adress`);

--
-- Indizes für die Tabelle `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indizes für die Tabelle `cards_decklists`
--
ALTER TABLE `cards_decklists`
  ADD UNIQUE KEY `deck_identifier` (`card_id`,`deck_id`,`side_board`,`maybe_board`),
  ADD KEY `deck_id` (`deck_id`);

--
-- Indizes für die Tabelle `decklists`
--
ALTER TABLE `decklists`
  ADD PRIMARY KEY (`deck_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `archiveuser`
--
ALTER TABLE `archiveuser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `decklists`
--
ALTER TABLE `decklists`
  MODIFY `deck_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cards_decklists`
--
ALTER TABLE `cards_decklists`
  ADD CONSTRAINT `cards_decklists_ibfk_1` FOREIGN KEY (`card_id`) REFERENCES `cards` (`card_id`),
  ADD CONSTRAINT `cards_decklists_ibfk_2` FOREIGN KEY (`deck_id`) REFERENCES `decklists` (`deck_id`);

--
-- Constraints der Tabelle `decklists`
--
ALTER TABLE `decklists`
  ADD CONSTRAINT `decklists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `archiveuser` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
