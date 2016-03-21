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

INSERT INTO `orders` (`id`, `address`, `paid`, `ordered`, `price`, `ordered_genre_id`) VALUES
('09778538-5f68-4ab4-9cc0-7f0aeface4d5', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-05 17:36:57', 0.0002, NULL),
('11368aba-8360-42a6-8dd4-4045f5a11437', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-21 16:38:26', 0.00006, NULL),
('11aab8bc-2614-4037-afd3-61defce1ad3d', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 18:22:02', 0.0002, NULL),
('140cb0fb-8bd5-4850-b402-79a1ae5646a7', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 1, '2016-03-21 16:39:20', 0.00008, NULL),
('1868de17-687c-4eda-806d-b2be291ce01e', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-07 21:07:25', 0.0001, NULL),
('24a63d8a-e9d6-4110-924b-d55204881452', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-15 16:31:13', 0.0005, NULL),
('3059fc39-b4c5-4b57-884c-2520e2fad2b5', '149rdqMjMM6UVHzEkkwwtbJUcxE1d4tbhf', 0, '2016-03-11 23:20:48', 0.0003, NULL),
('34702335-cdc6-4875-af3f-f6175c3e5cbd', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:19:03', 0.0004, NULL),
('3cad7fcf-cfbc-4e95-81ff-8eeaf3023964', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-15 16:28:28', 0.0003, NULL),
('40139a10-5696-4640-bf6e-4a56ef66b45c', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 17:52:41', 0.0002, NULL),
('42ee9302-032d-451a-8199-7718809f04cb', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-21 21:47:14', 0.00006, NULL),
('544683ef-03f4-40d0-9491-91d267bbe1b9', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 0, '2016-03-11 01:53:12', 0.0001, NULL),
('548600e0-b8e8-4c71-861c-9aa07439becc', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 0, '2016-03-14 20:11:32', 0.0001, NULL),
('596e17a8-b051-48ae-a7e3-7441a0b19549', '15jhVP2bKdMPRDs99ohenofv8KgY7wH9tS', 1, '2016-03-21 16:38:43', 0.00006, NULL),
('59c1ee02-ac4c-4a33-9291-bea35cd9b06d', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:12:50', 0.0005, NULL),
('607373c4-4983-484c-be63-7347950157a2', '16m6N7hUAwyfoZPUo8xGo4xMaqwshxJrVf', 0, '2016-03-11 23:22:55', 0.0001, NULL),
('647d02a9-2a04-43ae-bbd1-2542c060982e', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-16 11:29:41', 0.0003, NULL),
('64a6798f-2e66-4bf3-ad11-09ca516a54ce', '149rdqMjMM6UVHzEkkwwtbJUcxE1d4tbhf', 0, '2016-03-21 16:19:17', 0.0000004, NULL),
('65b2a9d6-8eb0-417e-84cd-a31a658045c7', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-07 21:33:44', 0.0003, NULL),
('6b13542c-889a-4b45-b05f-085152080c4f', '153kXRdBULL7wCDwBFY418n6EN52zd4Yts', 0, '2016-03-11 23:22:11', 0.0003, NULL),
('6f573ee5-38ea-4acc-b009-650d5c9348ec', '153kXRdBULL7wCDwBFY418n6EN52zd4Yts', 0, '2016-03-21 16:23:02', 0.0000004, NULL),
('772286db-4c2f-45ea-974e-da88ab40bc51', '154VoXxhFZ1JQbSoukvDjKXBpyEnRkWzbZ', 0, '2016-03-21 16:36:05', 0.00004, NULL),
('7a53f042-7ece-4bdf-92fc-a4b4856430aa', '154VoXxhFZ1JQbSoukvDjKXBpyEnRkWzbZ', 0, '2016-03-11 23:22:25', 0.0003, NULL),
('7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-21 19:32:35', 0.00006, NULL),
('8001157b-ce25-427d-b836-12105efa8206', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-08 21:36:34', 0.0003, NULL),
('87d4e47b-d0b1-40d7-a9bd-ba7e29d99720', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:25:26', 0.0004, NULL),
('87fa3e16-551e-478d-9e4f-f1eddebed525', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 18:58:03', 0.0004, NULL),
('8c32425f-ee58-47c3-b1fa-629a7986d55f', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 1, '2016-03-21 19:33:22', 0.00006, NULL),
('91426b28-66bd-4486-a19c-70356338d757', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-07 21:08:15', 0.0001, NULL),
('92af7bb7-72d9-452d-8233-8f429d96b653', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-12 01:34:52', 0.0007, NULL),
('932b1a16-8b88-4286-8837-7cea15790e99', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:21:41', 0.0004, NULL),
('9ace3f64-1cd6-4b34-b66f-0600ec14858f', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:10:22', 0.0006, NULL),
('9fb19822-e88c-4642-a4a6-51a4263f6e02', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-11 23:17:25', 0.0003, NULL),
('a8e5794d-7250-40de-b8f9-5428e0e07156', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-09 18:23:19', 0.0003, NULL),
('ab5244dd-aba4-4711-9a01-78915641495e', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-07 21:36:44', 0.0003, NULL),
('b8adba1c-7262-4be8-a1d3-492254749b71', '15jhVP2bKdMPRDs99ohenofv8KgY7wH9tS', 0, '2016-03-11 23:22:45', 0.0001, NULL),
('bad9058f-fea5-4a51-882c-d423a3c4a908', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-12 02:27:24', 0.0004, NULL),
('bb34d9d7-81a8-4f57-ae1d-3fb70b340f6e', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-08 21:38:00', 0.0002, NULL),
('c29383ab-b4b8-405a-ab13-96b1451720e8', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-14 16:39:13', 0.0006, NULL),
('c447d407-0f5a-493b-ae28-0f575d2fb7e9', '15jhVP2bKdMPRDs99ohenofv8KgY7wH9tS', 1, '2016-03-21 16:36:34', 0.00006, NULL),
('c9240836-c529-42f1-ae8d-33d4596cd612', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 1, '2016-03-05 17:58:21', 0.0001, NULL),
('c9678890-738f-4d4f-9340-7cc8d9e50b8d', '15XVbmCPfVohDYXkq1LAcjdzP4J1Zm445P', 0, '2016-03-11 23:22:52', 0.0001, NULL),
('cd31be39-397e-4d65-bc8f-df7eb58c35c8', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-14 20:11:20', 0.0006, NULL),
('d387f3cd-9ee5-4539-a12e-c6b13ddd6cda', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 0, '2016-03-11 23:20:25', 0.0003, NULL),
('dc8b4162-6f38-4520-b876-b5340fc57bb4', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 1, '2016-03-21 16:41:55', 0.00008, NULL),
('e919cdd3-f38c-4e22-ac08-24024a4c84c2', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-05 17:55:12', 0.0001, NULL),
('eb7823d7-80e2-4a06-8653-81493ac67a1f', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 1, '2016-03-05 19:03:55', 0.0005, NULL),
('ef89dc5a-9c44-4be3-90c3-661a675f4fa6', '13ngDv9EgzAug92hheRgT3GGduZonXRqpW', 1, '2016-03-21 16:47:05', 0.00006, NULL),
('f255b19a-7f05-4a3d-97e4-f6fca9bd8dfe', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-11 01:50:04', 0.0001, NULL),
('f397001b-a9b7-4f02-9f30-c59f3e975140', '12U1QLFTMTyAFqEzrsH4G4jS8EeWbB1EnJ', 0, '2016-03-07 17:28:17', 0.0001, NULL);

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

INSERT INTO `queue` (`id`, `song`, `proceeded`, `order_id`, `paid`) VALUES
(9, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '09778538-5f68-4ab4-9cc0-7f0aeface4d5', 0),
(10, '73a55de1-5602-4f49-9446-5eb795612efd', 0, '09778538-5f68-4ab4-9cc0-7f0aeface4d5', 0),
(11, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '40139a10-5696-4640-bf6e-4a56ef66b45c', 0),
(12, '73a55de1-5602-4f49-9446-5eb795612efd', 0, '40139a10-5696-4640-bf6e-4a56ef66b45c', 0),
(13, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, 'e919cdd3-f38c-4e22-ac08-24024a4c84c2', 0),
(14, '73a55de1-5602-4f49-9446-5eb795612efd', 0, 'c9240836-c529-42f1-ae8d-33d4596cd612', 0),
(15, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '11aab8bc-2614-4037-afd3-61defce1ad3d', 1),
(16, '73a55de1-5602-4f49-9446-5eb795612efd', 1, '11aab8bc-2614-4037-afd3-61defce1ad3d', 1),
(17, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '87fa3e16-551e-478d-9e4f-f1eddebed525', 1),
(18, '50938bf2-5553-4f8b-86f5-088358222787', 1, '87fa3e16-551e-478d-9e4f-f1eddebed525', 1),
(19, '5a0799e1-9f83-4527-8c4a-623c2e051f59', 1, '87fa3e16-551e-478d-9e4f-f1eddebed525', 1),
(20, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '87fa3e16-551e-478d-9e4f-f1eddebed525', 1),
(21, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, 'eb7823d7-80e2-4a06-8653-81493ac67a1f', 0),
(22, '50938bf2-5553-4f8b-86f5-088358222787', 0, 'eb7823d7-80e2-4a06-8653-81493ac67a1f', 0),
(23, '73a55de1-5602-4f49-9446-5eb795612efd', 0, 'eb7823d7-80e2-4a06-8653-81493ac67a1f', 0),
(24, '7acfa683-4b45-49cf-8959-35be25f2f252', 0, 'eb7823d7-80e2-4a06-8653-81493ac67a1f', 0),
(25, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'eb7823d7-80e2-4a06-8653-81493ac67a1f', 0),
(26, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(27, '50938bf2-5553-4f8b-86f5-088358222787', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(28, '73a55de1-5602-4f49-9446-5eb795612efd', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(29, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(30, '7acfa683-4b45-49cf-8959-35be25f2f252', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(31, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '9ace3f64-1cd6-4b34-b66f-0600ec14858f', 0),
(32, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '59c1ee02-ac4c-4a33-9291-bea35cd9b06d', 1),
(33, '73a55de1-5602-4f49-9446-5eb795612efd', 1, '59c1ee02-ac4c-4a33-9291-bea35cd9b06d', 1),
(34, '751451a6-6be6-4875-bb47-c59cefa50899', 1, '59c1ee02-ac4c-4a33-9291-bea35cd9b06d', 1),
(35, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '59c1ee02-ac4c-4a33-9291-bea35cd9b06d', 1),
(36, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '59c1ee02-ac4c-4a33-9291-bea35cd9b06d', 1),
(37, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '34702335-cdc6-4875-af3f-f6175c3e5cbd', 1),
(38, '751451a6-6be6-4875-bb47-c59cefa50899', 1, '34702335-cdc6-4875-af3f-f6175c3e5cbd', 1),
(39, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '34702335-cdc6-4875-af3f-f6175c3e5cbd', 1),
(40, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '34702335-cdc6-4875-af3f-f6175c3e5cbd', 1),
(41, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '932b1a16-8b88-4286-8837-7cea15790e99', 0),
(42, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '932b1a16-8b88-4286-8837-7cea15790e99', 0),
(43, '7acfa683-4b45-49cf-8959-35be25f2f252', 0, '932b1a16-8b88-4286-8837-7cea15790e99', 0),
(44, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '932b1a16-8b88-4286-8837-7cea15790e99', 0),
(45, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '87d4e47b-d0b1-40d7-a9bd-ba7e29d99720', 1),
(46, '751451a6-6be6-4875-bb47-c59cefa50899', 1, '87d4e47b-d0b1-40d7-a9bd-ba7e29d99720', 1),
(47, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '87d4e47b-d0b1-40d7-a9bd-ba7e29d99720', 1),
(48, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '87d4e47b-d0b1-40d7-a9bd-ba7e29d99720', 1),
(49, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'f397001b-a9b7-4f02-9f30-c59f3e975140', 0),
(50, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '1868de17-687c-4eda-806d-b2be291ce01e', 1),
(51, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '91426b28-66bd-4486-a19c-70356338d757', 0),
(52, '73a55de1-5602-4f49-9446-5eb795612efd', 1, '65b2a9d6-8eb0-417e-84cd-a31a658045c7', 1),
(53, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 1, '65b2a9d6-8eb0-417e-84cd-a31a658045c7', 1),
(54, 'e904dcdf-2173-4161-851d-83a35368bac1', 1, '65b2a9d6-8eb0-417e-84cd-a31a658045c7', 1),
(55, '73a55de1-5602-4f49-9446-5eb795612efd', 1, 'ab5244dd-aba4-4711-9a01-78915641495e', 1),
(56, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 1, 'ab5244dd-aba4-4711-9a01-78915641495e', 1),
(57, 'e904dcdf-2173-4161-851d-83a35368bac1', 1, 'ab5244dd-aba4-4711-9a01-78915641495e', 1),
(58, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '8001157b-ce25-427d-b836-12105efa8206', 1),
(59, '751451a6-6be6-4875-bb47-c59cefa50899', 1, '8001157b-ce25-427d-b836-12105efa8206', 1),
(60, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '8001157b-ce25-427d-b836-12105efa8206', 1),
(61, '22e6bda0-8819-47cb-a243-131edb2d373d', 1, 'bb34d9d7-81a8-4f57-ae1d-3fb70b340f6e', 1),
(62, '5a0799e1-9f83-4527-8c4a-623c2e051f59', 1, 'bb34d9d7-81a8-4f57-ae1d-3fb70b340f6e', 1),
(63, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 1, 'a8e5794d-7250-40de-b8f9-5428e0e07156', 1),
(64, '22e6bda0-8819-47cb-a243-131edb2d373d', 1, 'a8e5794d-7250-40de-b8f9-5428e0e07156', 1),
(65, 'adc25c56-ee90-4456-904d-71a4b6120263', 1, 'a8e5794d-7250-40de-b8f9-5428e0e07156', 1),
(66, '30939792-0de5-48f7-9935-b98010b82c13', 0, 'f255b19a-7f05-4a3d-97e4-f6fca9bd8dfe', 0),
(67, '30939792-0de5-48f7-9935-b98010b82c13', 0, '544683ef-03f4-40d0-9491-91d267bbe1b9', 0),
(68, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '9fb19822-e88c-4642-a4a6-51a4263f6e02', 0),
(69, 'adc25c56-ee90-4456-904d-71a4b6120263', 0, '9fb19822-e88c-4642-a4a6-51a4263f6e02', 0),
(70, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, '9fb19822-e88c-4642-a4a6-51a4263f6e02', 0),
(71, '751451a6-6be6-4875-bb47-c59cefa50899', 0, 'd387f3cd-9ee5-4539-a12e-c6b13ddd6cda', 0),
(72, 'adc25c56-ee90-4456-904d-71a4b6120263', 0, 'd387f3cd-9ee5-4539-a12e-c6b13ddd6cda', 0),
(73, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, 'd387f3cd-9ee5-4539-a12e-c6b13ddd6cda', 0),
(74, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '3059fc39-b4c5-4b57-884c-2520e2fad2b5', 0),
(75, 'adc25c56-ee90-4456-904d-71a4b6120263', 0, '3059fc39-b4c5-4b57-884c-2520e2fad2b5', 0),
(76, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, '3059fc39-b4c5-4b57-884c-2520e2fad2b5', 0),
(77, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '6b13542c-889a-4b45-b05f-085152080c4f', 0),
(78, 'adc25c56-ee90-4456-904d-71a4b6120263', 0, '6b13542c-889a-4b45-b05f-085152080c4f', 0),
(79, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, '6b13542c-889a-4b45-b05f-085152080c4f', 0),
(80, '751451a6-6be6-4875-bb47-c59cefa50899', 0, '7a53f042-7ece-4bdf-92fc-a4b4856430aa', 0),
(81, 'adc25c56-ee90-4456-904d-71a4b6120263', 0, '7a53f042-7ece-4bdf-92fc-a4b4856430aa', 0),
(82, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, '7a53f042-7ece-4bdf-92fc-a4b4856430aa', 0),
(83, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'b8adba1c-7262-4be8-a1d3-492254749b71', 0),
(84, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'c9678890-738f-4d4f-9340-7cc8d9e50b8d', 0),
(85, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '607373c4-4983-484c-be63-7347950157a2', 0),
(86, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(87, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(88, '22e6bda0-8819-47cb-a243-131edb2d373d', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(89, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(90, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(91, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(92, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 0, '92af7bb7-72d9-452d-8233-8f429d96b653', 0),
(93, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, 'bad9058f-fea5-4a51-882c-d423a3c4a908', 0),
(94, '22e6bda0-8819-47cb-a243-131edb2d373d', 0, 'bad9058f-fea5-4a51-882c-d423a3c4a908', 0),
(95, '50938bf2-5553-4f8b-86f5-088358222787', 0, 'bad9058f-fea5-4a51-882c-d423a3c4a908', 0),
(96, '73a55de1-5602-4f49-9446-5eb795612efd', 0, 'bad9058f-fea5-4a51-882c-d423a3c4a908', 0),
(97, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(98, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(99, '30939792-0de5-48f7-9935-b98010b82c13', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(100, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(101, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(102, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, 'c29383ab-b4b8-405a-ab13-96b1451720e8', 1),
(103, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(104, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(105, '22e6bda0-8819-47cb-a243-131edb2d373d', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(106, '30939792-0de5-48f7-9935-b98010b82c13', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(107, '751451a6-6be6-4875-bb47-c59cefa50899', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(108, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'cd31be39-397e-4d65-bc8f-df7eb58c35c8', 0),
(109, '242af1b9-23d3-4f04-b446-dc1ea8ebe935', 0, '548600e0-b8e8-4c71-861c-9aa07439becc', 0),
(110, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '3cad7fcf-cfbc-4e95-81ff-8eeaf3023964', 1),
(111, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '3cad7fcf-cfbc-4e95-81ff-8eeaf3023964', 1),
(112, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, '3cad7fcf-cfbc-4e95-81ff-8eeaf3023964', 1),
(113, '2ab1c32f-57de-4200-a5aa-90df210f431f', 1, '24a63d8a-e9d6-4110-924b-d55204881452', 1),
(114, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, '24a63d8a-e9d6-4110-924b-d55204881452', 1),
(115, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '24a63d8a-e9d6-4110-924b-d55204881452', 1),
(116, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '24a63d8a-e9d6-4110-924b-d55204881452', 1),
(117, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, '24a63d8a-e9d6-4110-924b-d55204881452', 1),
(118, 'e904dcdf-2173-4161-851d-83a35368bac1', 0, '647d02a9-2a04-43ae-bbd1-2542c060982e', 0),
(119, '242af1b9-23d3-4f04-b446-dc1ea8ebe935', 0, '647d02a9-2a04-43ae-bbd1-2542c060982e', 0),
(120, 'c964c81c-871c-4058-a7fb-5af8d0ad50b2', 0, '647d02a9-2a04-43ae-bbd1-2542c060982e', 0),
(121, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '64a6798f-2e66-4bf3-ad11-09ca516a54ce', 0),
(122, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '64a6798f-2e66-4bf3-ad11-09ca516a54ce', 0),
(123, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '64a6798f-2e66-4bf3-ad11-09ca516a54ce', 0),
(124, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '64a6798f-2e66-4bf3-ad11-09ca516a54ce', 0),
(125, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '6f573ee5-38ea-4acc-b009-650d5c9348ec', 0),
(126, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '6f573ee5-38ea-4acc-b009-650d5c9348ec', 0),
(127, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '6f573ee5-38ea-4acc-b009-650d5c9348ec', 0),
(128, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '6f573ee5-38ea-4acc-b009-650d5c9348ec', 0),
(129, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '772286db-4c2f-45ea-974e-da88ab40bc51', 0),
(130, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '772286db-4c2f-45ea-974e-da88ab40bc51', 0),
(131, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '772286db-4c2f-45ea-974e-da88ab40bc51', 0),
(132, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '772286db-4c2f-45ea-974e-da88ab40bc51', 0),
(133, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(134, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(135, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(136, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(137, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(138, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, 'c447d407-0f5a-493b-ae28-0f575d2fb7e9', 0),
(139, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(140, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(141, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(142, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(143, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(144, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '11368aba-8360-42a6-8dd4-4045f5a11437', 0),
(145, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(146, '2ab1c32f-57de-4200-a5aa-90df210f431f', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(147, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(148, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(149, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(150, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, '596e17a8-b051-48ae-a7e3-7441a0b19549', 1),
(151, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(152, '50938bf2-5553-4f8b-86f5-088358222787', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(153, '5a0799e1-9f83-4527-8c4a-623c2e051f59', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(154, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(155, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(156, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(157, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(158, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, '140cb0fb-8bd5-4850-b402-79a1ae5646a7', 1),
(159, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(160, '50938bf2-5553-4f8b-86f5-088358222787', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(161, '5a0799e1-9f83-4527-8c4a-623c2e051f59', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(162, '7acfa683-4b45-49cf-8959-35be25f2f252', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(163, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(164, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(165, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(166, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, 'dc8b4162-6f38-4520-b876-b5340fc57bb4', 1),
(167, '13b6f480-4703-4380-9dfe-81f968f6a0ca', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(168, '50938bf2-5553-4f8b-86f5-088358222787', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(169, '751451a6-6be6-4875-bb47-c59cefa50899', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(170, '2ab1c32f-57de-4200-a5aa-90df210f431f', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(171, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(172, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, 'ef89dc5a-9c44-4be3-90c3-661a675f4fa6', 1),
(173, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(174, '483932cb-bfdc-4e8c-9d00-fc7f49460f42', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(175, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(176, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(177, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(178, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '7e0f2ddc-56a4-4e43-8f7e-43a0841a8731', 0),
(179, 'c1fd573e-44ea-40b6-841f-a829fb2b815f', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(180, '483932cb-bfdc-4e8c-9d00-fc7f49460f42', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(181, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(182, 'b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(183, 'c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(184, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 1, '8c32425f-ee58-47c3-b1fa-629a7986d55f', 1),
(185, '12c933d6-b5fb-4acd-a883-ebc0914a29fb', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0),
(186, '30939792-0de5-48f7-9935-b98010b82c13', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0),
(187, '2ab1c32f-57de-4200-a5aa-90df210f431f', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0),
(188, '5a7c67f0-f10a-4598-99f8-ebe34316474b', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0),
(189, '0485e2ff-f5a5-44c3-9274-705fc8932e70', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0),
(190, 'fc4466c9-7628-4630-849c-9f5764f35de5', 0, '42ee9302-032d-451a-8199-7718809f04cb', 0);

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

INSERT INTO `song` (`id`, `genre_id`, `name`, `album_cover`) VALUES
('0485e2ff-f5a5-44c3-9274-705fc8932e70', 3, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('12c933d6-b5fb-4acd-a883-ebc0914a29fb', NULL, '01 - Ravenheart.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('13b6f480-4703-4380-9dfe-81f968f6a0ca', NULL, '11_blutengel-lucifer.mp3', 'http://ecx.images-amazon.com/images/I/61l3trijl1L.jpg'),
('22e6bda0-8819-47cb-a243-131edb2d373d', NULL, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('242af1b9-23d3-4f04-b446-dc1ea8ebe935', 1, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('2ab1c32f-57de-4200-a5aa-90df210f431f', 1, '01 - ''Log Horizon'' Main Theme.mp3', 'http://ecx.images-amazon.com/images/I/514W7eAzkNL.jpg'),
('30939792-0de5-48f7-9935-b98010b82c13', NULL, '03 - Back To The River.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('483932cb-bfdc-4e8c-9d00-fc7f49460f42', 1, '_Show_Me_Your_Firetruck_[1].mp3', ''),
('4af02667-5581-49e7-9f5d-3243441f6d47', NULL, '02 - The Lioness.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('50938bf2-5553-4f8b-86f5-088358222787', NULL, '03 Fable.mpeg', ''),
('5a0799e1-9f83-4527-8c4a-623c2e051f59', NULL, '05 Remember.mpeg', ''),
('5a7c67f0-f10a-4598-99f8-ebe34316474b', 1, '18 - Shin Sekai.mp3', 'http://ecx.images-amazon.com/images/I/514W7eAzkNL.jpg'),
('6b6d3a44-7836-404f-802f-779cf93b4020', NULL, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('73a55de1-5602-4f49-9446-5eb795612efd', NULL, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('751451a6-6be6-4875-bb47-c59cefa50899', NULL, '02 Riversong.mpeg', ''),
('7acfa683-4b45-49cf-8959-35be25f2f252', NULL, '01 Anima.mpeg', ''),
('82c2bffa-e1dd-4675-9c44-419e11a7abfa', NULL, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('90baaba1-ec33-4c62-889b-407012be0267', NULL, '05 - Fire Of Universe.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('939ff5ee-3aa9-4588-b36a-20965d466c29', NULL, '_Show_Me_Your_Firetruck_[1].mp3', ''),
('94765d00-2cfd-43b9-b889-adceb8ccc36b', 2001, '01 - Ravenheart.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('aa6761d0-0fbb-4951-b541-f1a0988e848d', NULL, '03 Fable.mpeg', ''),
('adc25c56-ee90-4456-904d-71a4b6120263', NULL, '04 - Eversleeping.mp3', 'http://ecx.images-amazon.com/images/I/513144J3UBL.jpg'),
('b2ca2e1e-aba2-440b-855e-730995b62c2f', 1, 'Ďáblovy námluvy (The Devil''s Courtship).mp3', ''),
('b65c259e-f5d2-4d2b-9837-0a58a82a2155', NULL, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('c1fd573e-44ea-40b6-841f-a829fb2b815f', NULL, '06 A Story Unfold.mpeg', ''),
('c36aac46-e37e-4ab3-987f-9f31d65ffca1', 1, '20 - Elder Tale no Waltz.mp3', 'http://ecx.images-amazon.com/images/I/514W7eAzkNL.jpg'),
('c964c81c-871c-4058-a7fb-5af8d0ad50b2', 3, '_Show_Me_Your_Firetruck_[1].mp3', ''),
('e904dcdf-2173-4161-851d-83a35368bac1', NULL, '04 The Red Dawn.mpeg', ''),
('fc4466c9-7628-4630-849c-9f5764f35de5', 2001, '01_blutengel-no_eternity-fwyh.mp3', 'http://ecx.images-amazon.com/images/I/51bNGyndm4L.jpg'),
('fd796968-42aa-46f5-8507-ef5a37836ee2', NULL, '_Show_Me_Your_Firetruck_[1].mp3', '');

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
