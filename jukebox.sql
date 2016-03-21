-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 21. bře 2016, 22:27
-- Verze serveru: 10.1.10-MariaDB
-- Verze PHP: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `jukebox`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `addresses`
--

CREATE TABLE `addresses` (
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_used` datetime DEFAULT NULL,
  `bip32index` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `addresses`
--

INSERT INTO `addresses` (`address`, `last_used`, `bip32index`) VALUES
('12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', '2016-03-21 21:47:14', 6),
('13ngDv9EgzAug92hheRgT3GGduZonXRqpW', NULL, 12),
('149rdqMjMM6UVHzEkkwwtbJUcxE1d4tbhf', '2016-03-21 16:19:17', 16),
('153kXRdBULL7wCDwBFY418n6EN52zd4Yts', '2016-03-21 16:23:02', 11),
('154VoXxhFZ1JQbSoukvDjKXBpyEnRkWzbZ', '2016-03-21 16:36:05', 19),
('15jhVP2bKdMPRDs99ohenofv8KgY7wH9tS', NULL, 5),
('15XVbmCPfVohDYXkq1LAcjdzP4J1Zm445P', '2016-03-11 23:22:52', 24),
('16m6N7hUAwyfoZPUo8xGo4xMaqwshxJrVf', '2016-03-11 23:22:55', 2),
('16NQBnLawdnRGDDGpZPDdmASRqDfT2kA8b', '2016-03-04 18:51:41', 22),
('17QNPgWVPbbipuMvrrmMcod5uvwysfMq3a', NULL, 21),
('187T4b5jrAmJRJNa9NEzN3yq4YJrabMj6e', NULL, 9),
('18mKqvh7GVji8sSacBXT1ZvGaKTE3TuS6F', NULL, 25),
('19XtyZnC8ovEEi8eXjHW46iij7jB9qsVac', NULL, 3),
('1BezCAcxjYiePJQRTL3zu2wQyrii4mGDS3', NULL, 15),
('1BPLbb1Bt9KTvCzREfyX43Qm4cNj2yCM7d', NULL, 26),
('1Ca7nJ15amjqsBjM5Zn1RHZrghSYAo6grN', NULL, 10),
('1CuDFshsMakfFmexXW3cTSinG428yzHwhc', NULL, 13),
('1DQThcYk445eTxc8nYmce4ErFeZGPtmPye', NULL, 20),
('1Dxg5oeUtX1m2dBiW9c7jLbDocoHGvPPB6', NULL, 17),
('1EJwt6Cq4mU7oKtQoBszrrvdQtnaUfARZW', NULL, 8),
('1ELuWUitkGmU1YmDvXu8cv4q8udUqDzBGV', NULL, 7),
('1Ez4bFEUTAKXefJocduAd3SPvogwBES9XG', NULL, 1),
('1HDXLNn75oA4n4th7Yir1uYZm9hyV4W2oP', NULL, 27),
('1JH3ESeoMhTQ78bKMKg8WyGGWQ3jx8Nu5Z', NULL, 14),
('1KREuyPANbJ1guDGXug76GBoWpieDYJkVv', NULL, 4),
('1L496GNxPqAKBucd1WgxumRHGV3GXzFm4y', NULL, 23),
('1Q3jEi4M73GD1yb3Fd8s2oX6AE4Jv7mSoK', NULL, 18);

-- --------------------------------------------------------

--
-- Struktura tabulky `genre`
--

CREATE TABLE `genre` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `genre`
--

INSERT INTO `genre` (`name`, `id`) VALUES
('blues', 3),
('firefly', 1),
('rnb', 2),
('rock', 2001);

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid` tinyint(1) NOT NULL,
  `ordered` datetime NOT NULL,
  `price` double NOT NULL,
  `ordered_genre_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `orders`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `song` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `proceeded` tinyint(1) NOT NULL,
  `order_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `paid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `queue`
--


-- --------------------------------------------------------

--
-- Struktura tabulky `song`
--

CREATE TABLE `song` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `genre_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `album_cover` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `song`
--


--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address`),
  ADD UNIQUE KEY `UNIQ_6FCA7516FC609321` (`bip32index`);

--
-- Klíče pro tabulku `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_835033F85E237E06` (`name`);

--
-- Klíče pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E52FFDEED4E6F81` (`address`),
  ADD KEY `IDX_E52FFDEEC8C6A060` (`ordered_genre_id`);

--
-- Klíče pro tabulku `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7FFD7F6333EDEEA1` (`song`),
  ADD KEY `IDX_7FFD7F638D9F6D38` (`order_id`);

--
-- Klíče pro tabulku `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_33EDEEA14296D31F` (`genre_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2002;
--
-- AUTO_INCREMENT pro tabulku `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_E52FFDEEC8C6A060` FOREIGN KEY (`ordered_genre_id`) REFERENCES `genre` (`id`),
  ADD CONSTRAINT `FK_E52FFDEED4E6F81` FOREIGN KEY (`address`) REFERENCES `addresses` (`address`);

--
-- Omezení pro tabulku `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `FK_7FFD7F6333EDEEA1` FOREIGN KEY (`song`) REFERENCES `song` (`id`),
  ADD CONSTRAINT `FK_7FFD7F638D9F6D38` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Omezení pro tabulku `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `FK_33EDEEA14296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
