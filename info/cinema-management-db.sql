-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Poèítaè: 127.0.0.1
-- Vytvoøeno: Stø 18. lis 2020, 17:34
-- Verze serveru: 10.4.14-MariaDB
-- Verze PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES cp1250 */;

--
-- Databáze: `cinema-management-db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `cinemas`
--

CREATE TABLE `cinemas` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `city` varchar(64) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `cover_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `cinemas`
--

INSERT INTO `cinemas` (`id`, `title`, `city`, `address`, `cover_url`) VALUES
(1, 'Cinema City', 'Pardubice', 'Masarykovo nám. 2799, 530 02 Pardubice I-Zelené Pøedmìstí', 'https://www.cinemacity.cz/static/dam/jcr:7ca9a5b5-b5f4-4826-becc-118f90b08bdb');

-- --------------------------------------------------------

--
-- Struktura tabulky `completed_orders`
--

CREATE TABLE `completed_orders` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `completed` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `completed_orders`
--

INSERT INTO `completed_orders` (`id`, `created`, `completed`, `user_id`) VALUES
(1, '2020-11-16 23:05:54', '2020-11-17 21:22:43', 1),
(2, '2020-11-17 23:13:15', '2020-11-17 23:16:00', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `completed_reservations`
--

CREATE TABLE `completed_reservations` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `completed_order_id` int(11) NOT NULL,
  `program_entry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `completed_reservations`
--

INSERT INTO `completed_reservations` (`id`, `price`, `completed_order_id`, `program_entry_id`) VALUES
(1, 240, 1, 1),
(2, 240, 1, 3),
(3, 480, 2, 4);

-- --------------------------------------------------------

--
-- Struktura tabulky `confirmed_seats`
--

CREATE TABLE `confirmed_seats` (
  `id` int(11) NOT NULL,
  `completed_reservation_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `confirmed_seats`
--

INSERT INTO `confirmed_seats` (`id`, `completed_reservation_id`, `seat_id`) VALUES
(1, 1, 7),
(2, 1, 8),
(3, 2, 7),
(4, 2, 8),
(5, 3, 17),
(6, 3, 18),
(7, 3, 5),
(8, 3, 19);

-- --------------------------------------------------------

--
-- Struktura tabulky `halls`
--

CREATE TABLE `halls` (
  `id` int(11) NOT NULL,
  `uid` varchar(32) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `cinema_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `halls`
--

INSERT INTO `halls` (`id`, `uid`, `type`, `cinema_id`) VALUES
(1, 'A', 'Normal', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `year` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `cover_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `movies`
--

INSERT INTO `movies` (`id`, `title`, `year`, `duration`, `description`, `cover_url`) VALUES
(3, 'Avengers', 2012, 143, 'Earth\'s mightiest heroes must come together and learn to fight as a team if they are going to stop the mischievous Loki and his alien army from enslaving humanity. (IMDb)', 'https://m.media-amazon.com/images/M/MV5BNDYxNjQyMjAtNTdiOS00NGYwLWFmNTAtNThmYjU5ZGI2YTI1XkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_FMjpg_UX800_.jpg'),
(4, 'Avengers: Age of Ultron', 2015, 141, 'When Tony Stark and Bruce Banner try to jump-start a dormant peacekeeping program called Ultron, things go horribly wrong and it\'s up to Earth\'s mightiest heroes to stop the villainous Ultron from enacting his terrible plan. (IMDb)', 'https://m.media-amazon.com/images/M/MV5BMTM4OGJmNWMtOTM4Ni00NTE3LTg3MDItZmQxYjc4N2JhNmUxXkEyXkFqcGdeQXVyNTgzMDMzMTg@._V1_FMjpg_UX864_.jpg'),
(5, 'Avengers: Infinity War', 2018, 149, 'The Avengers and their allies must be willing to sacrifice all in an attempt to defeat the powerful Thanos before his blitz of devastation and ruin puts an end to the universe. (IMDb)', 'https://m.media-amazon.com/images/M/MV5BMjMxNjY2MDU1OV5BMl5BanBnXkFtZTgwNzY1MTUwNTM@._V1_FMjpg_UY863_.jpg'),
(6, 'Avengers: Endgame', 2019, 181, 'After the devastating events of Avengers: Infinity War (2018), the universe is in ruins. With the help of remaining allies, the Avengers assemble once more in order to reverse Thanos\' actions and restore balance to the universe. (IMDb)', 'https://m.media-amazon.com/images/M/MV5BMTc5MDE2ODcwNV5BMl5BanBnXkFtZTgwMzI2NzQ2NzM@._V1_FMjpg_UY863_.jpg');

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`id`, `created`, `user_id`) VALUES
(2, '2020-11-17 21:44:16', 1),
(4, '2020-11-18 17:08:09', 2),
(5, '2020-11-18 17:31:33', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `program_entries`
--

CREATE TABLE `program_entries` (
  `id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `price` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `hall_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `program_entries`
--

INSERT INTO `program_entries` (`id`, `start`, `price`, `movie_id`, `hall_id`) VALUES
(1, '2021-11-17 16:00:00', 120, 3, 1),
(2, '2021-11-18 16:00:00', 120, 4, 1),
(3, '2021-11-19 17:00:00', 120, 5, 1),
(4, '2021-11-20 14:00:00', 120, 6, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `program_entry_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `reservations`
--

INSERT INTO `reservations` (`id`, `order_id`, `program_entry_id`) VALUES
(3, 2, 1),
(5, 4, 3),
(6, 5, 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `reserved_seats`
--

CREATE TABLE `reserved_seats` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `seat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `reserved_seats`
--

INSERT INTO `reserved_seats` (`id`, `reservation_id`, `seat_id`) VALUES
(5, 3, 11),
(6, 3, 13),
(11, 5, 11),
(12, 5, 13),
(13, 6, 14),
(14, 6, 4),
(15, 6, 15),
(16, 6, 16);

-- --------------------------------------------------------

--
-- Struktura tabulky `seats`
--

CREATE TABLE `seats` (
  `id` int(11) NOT NULL,
  `pos_x` int(11) NOT NULL,
  `pos_y` int(11) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `hall_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `seats`
--

INSERT INTO `seats` (`id`, `pos_x`, `pos_y`, `type`, `hall_id`) VALUES
(1, 1, 1, 'Normal', 1),
(3, 10, 1, 'Normal', 1),
(4, 2, 2, 'Normal', 1),
(5, 3, 3, 'Normal', 1),
(6, 4, 4, 'Normal', 1),
(7, 2, 1, 'Normal', 1),
(8, 3, 1, 'Normal', 1),
(9, 4, 1, 'Normal', 1),
(10, 7, 1, 'Normal', 1),
(11, 8, 1, 'Normal', 1),
(13, 9, 1, 'Normal', 1),
(14, 1, 2, 'Normal', 1),
(15, 3, 2, 'Normal', 1),
(16, 4, 2, 'Normal', 1),
(17, 1, 3, 'Normal', 1),
(18, 2, 3, 'Normal', 1),
(19, 4, 3, 'Normal', 1),
(20, 1, 4, 'Normal', 1),
(21, 2, 4, 'Normal', 1),
(22, 3, 4, 'Normal', 1),
(23, 7, 2, 'Normal', 1),
(24, 8, 2, 'Normal', 1),
(25, 9, 2, 'Normal', 1),
(26, 9, 2, 'Normal', 1),
(27, 10, 2, 'Normal', 1),
(28, 7, 3, 'Normal', 1),
(29, 8, 3, 'Normal', 1),
(30, 9, 3, 'Normal', 1),
(31, 10, 3, 'Normal', 1),
(32, 7, 4, 'Normal', 1),
(33, 8, 4, 'Normal', 1),
(34, 9, 4, 'Normal', 1),
(35, 10, 4, 'Normal', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `permission` tinyint(3) UNSIGNED NOT NULL DEFAULT 100,
  `registered` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `first_name`, `last_name`, `permission`, `registered`) VALUES
(1, 'admin', '$2y$10$sL4gYDrZn20XXH1b0cdjGO2MRo3KJuo2hV5S4JwjHjB.cPa6ghui2', NULL, NULL, 0, '2020-11-16 22:31:51'),
(2, 'user@gmail.com', '$2y$10$sL4gYDrZn20XXH1b0cdjGO2MRo3KJuo2hV5S4JwjHjB.cPa6ghui2', 'Petr', 'Bednáø', 100, '2020-11-17 23:11:37'),
(3, 'worker', '$2y$10$sL4gYDrZn20XXH1b0cdjGO2MRo3KJuo2hV5S4JwjHjB.cPa6ghui2', NULL, NULL, 10, '2020-11-17 23:14:26');

--
-- Klíèe pro exportované tabulky
--

--
-- Klíèe pro tabulku `cinemas`
--
ALTER TABLE `cinemas`
  ADD PRIMARY KEY (`id`);

--
-- Klíèe pro tabulku `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Klíèe pro tabulku `completed_reservations`
--
ALTER TABLE `completed_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_entry_id` (`program_entry_id`),
  ADD KEY `completed_order_id` (`completed_order_id`);

--
-- Klíèe pro tabulku `confirmed_seats`
--
ALTER TABLE `confirmed_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `completed_reservation_id` (`completed_reservation_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Klíèe pro tabulku `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`);

--
-- Klíèe pro tabulku `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Klíèe pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Klíèe pro tabulku `program_entries`
--
ALTER TABLE `program_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Klíèe pro tabulku `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `program_entry_id` (`program_entry_id`);

--
-- Klíèe pro tabulku `reserved_seats`
--
ALTER TABLE `reserved_seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `seat_id` (`seat_id`);

--
-- Klíèe pro tabulku `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hall_id` (`hall_id`);

--
-- Klíèe pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `cinemas`
--
ALTER TABLE `cinemas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `completed_orders`
--
ALTER TABLE `completed_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `completed_reservations`
--
ALTER TABLE `completed_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `confirmed_seats`
--
ALTER TABLE `confirmed_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `halls`
--
ALTER TABLE `halls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `program_entries`
--
ALTER TABLE `program_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pro tabulku `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `reserved_seats`
--
ALTER TABLE `reserved_seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pro tabulku `seats`
--
ALTER TABLE `seats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `completed_orders`
--
ALTER TABLE `completed_orders`
  ADD CONSTRAINT `completed_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `completed_reservations`
--
ALTER TABLE `completed_reservations`
  ADD CONSTRAINT `completed_reservations_ibfk_1` FOREIGN KEY (`program_entry_id`) REFERENCES `program_entries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `completed_reservations_ibfk_2` FOREIGN KEY (`completed_order_id`) REFERENCES `completed_orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `confirmed_seats`
--
ALTER TABLE `confirmed_seats`
  ADD CONSTRAINT `confirmed_seats_ibfk_1` FOREIGN KEY (`completed_reservation_id`) REFERENCES `completed_reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `confirmed_seats_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `program_entries`
--
ALTER TABLE `program_entries`
  ADD CONSTRAINT `program_entries_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `program_entries_ibfk_2` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`program_entry_id`) REFERENCES `program_entries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `reserved_seats`
--
ALTER TABLE `reserved_seats`
  ADD CONSTRAINT `reserved_seats_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reserved_seats_ibfk_2` FOREIGN KEY (`seat_id`) REFERENCES `seats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`hall_id`) REFERENCES `halls` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
