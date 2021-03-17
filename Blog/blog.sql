-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 26 Sty 2021, 03:10
-- Wersja serwera: 5.7.31
-- Wersja PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `content` varchar(2000) COLLATE utf8_polish_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tag` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `a_user_id_fk` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `article`
--

INSERT INTO `article` (`article_id`, `title`, `content`, `user_id`, `time`, `tag`) VALUES
(1, 'konto admina', 'mail: admin@mail.com<br />\r\nhasÅ‚o: 12345', 14, '2020-12-31 23:00:00', 'konta'),
(2, 'konto autora', 'mail: autor@mail.com<br />\r\nhasÅ‚o: 12345', 14, '2020-12-31 23:00:01', 'konta'),
(3, 'konto usera aktywowanego', 'mail: user1@mail.com<br />\r\nhasÅ‚o: 12345', 14, '2020-12-31 23:00:02', 'konta'),
(4, 'konto usera nieaktywowanego', 'mail: user2@mail.com<br />\r\nhasÅ‚o: 12345', 14, '2020-12-31 23:00:03', 'konta'),
(15, 'Lorem Ipsum 1', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus. Maecenas ac est et ligula molestie varius. Curabitur euismod tempus vulputate. Nulla non metus a odio luctus aliquet. Aliquam ac sollicitudin nisi. Sed sodales sapien facilisis congue hendrerit. Maecenas lacus quam, malesuada id eros in, porta porta metus. Fusce pulvinar nibh nec aliquam efficitur. Integer sed sagittis turpis.</p>', 15, '2020-12-31 23:00:04', 'lorem_ipsum'),
(16, 'Lorem ipsum 2', '<ins>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus. Maecenas ac est et ligula molestie varius. Curabitur euismod tempus vulputate. Nulla non metus a odio luctus aliquet. Aliquam ac sollicitudin nisi. Sed sodales sapien facilisis congue hendrerit. Maecenas lacus quam, malesuada id eros in, porta porta metus. Fusce pulvinar nibh nec aliquam efficitur. Integer sed sagittis turpis.</ins>', 14, '2020-12-31 23:00:05', 'lorem_ipsum'),
(17, 'Data 02.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-02 13:14:10', 'styczeÅ„'),
(18, 'Data 03.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-03 13:14:37', 'styczeÅ„'),
(19, 'Data 14.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-14 13:15:24', 'styczeÅ„'),
(20, 'Data 15.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-15 13:15:45', 'styczeÅ„'),
(21, 'Data 17.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-17 13:16:07', 'styczeÅ„'),
(22, 'Data 20.01.2021', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2021-01-20 13:16:32', 'styczeÅ„'),
(23, 'Data 31.12.2020', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ac consectetur quam, id luctus risus. Aenean in mi elit. Aliquam ex arcu, mollis vitae ligula in, posuere finibus purus.', 14, '2020-12-31 13:17:18', 'grudzieÅ„');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `nickname` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `content` varchar(500) COLLATE utf8_polish_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `c_user_id_fk` (`user_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `comment`
--

INSERT INTO `comment` (`comment_id`, `type`, `nickname`, `email`, `content`, `user_id`, `article_id`) VALUES
(3, 'anonymous', 'kamil', 'k@k.k', 'kamil', NULL, 22),
(4, 'anonymous', 'a', 'a@a.a', 'a', NULL, 21),
(5, 'registered', NULL, NULL, 'komentarz 2', 14, 22);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `permission`
--

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `permission`
--

INSERT INTO `permission` (`permission_id`, `description`) VALUES
(5, 'login'),
(6, 'comment_delete'),
(7, 'article_create'),
(8, 'user_modify');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `role`
--

INSERT INTO `role` (`role_id`, `name`) VALUES
(1, 'user'),
(2, 'admin'),
(4, 'author');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE IF NOT EXISTS `role_permission` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `rp_role_id_fk` (`role_id`) USING BTREE,
  KEY `rp_permission_id_fk` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `role_permission`
--

INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES
(1, 5),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(4, 5),
(4, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `first_name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `website` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `activate` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `u_role_id_fk` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `first_name`, `last_name`, `website`, `description`, `role_id`, `activate`) VALUES
(14, 'admin@mail.com', '$2y$10$kzb9Nz2m8EJxZHxzNtaWe.iyu8o485ahP5CqRzdxmAjyZHOZXYTPu', 'admin', '', NULL, NULL, 2, 1),
(15, 'autor@mail.com', '$2y$10$MPRH/XmLhvePpmysrBlRQu00yh951GM8vL26PMYaIRFQklLsjDbR2', 'autor', '', NULL, NULL, 4, 1),
(16, 'user1@mail.com', '$2y$10$rXQQkojuydL8SWyvZl.QvOIjdVIHQeCgkdaGUsmF7QB8m0PXvs7Ye', 'user aktywowany', '', NULL, NULL, 1, 1),
(17, 'user2@mail.com', '$2y$10$NRUsHWlTN.AD6n253CrLwuDh6.bZBKN4e5ZXLxZaPyR6TkVjAnPMa', 'user nieaktywowany', '', NULL, NULL, 1, 0),
(18, 'h@a.a', '$2y$10$ZOYH9nTfbWuEI8KVsAHeAOKi8XvRgmQARBe/YiFVYGk.G3N0Vjsji', '', '', NULL, NULL, 1, 0),
(19, 'a@a.a', '$2y$10$KkZJJKqdP6OY11ZeQGyBJuL5GeLZkShf/nfmG4hxJtyTeE63vyUt.', '', '', NULL, NULL, 1, 0);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `a_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `c_article_id_fk` FOREIGN KEY (`article_id`) REFERENCES `article` (`article_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `c_user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `rp_permission_id_fk` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rp_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `u_role_id_fk` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
